<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Load library phpspreadsheet
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// End load library phpspreadsheet

class KartuStock extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model("ModelBarang");
        $this->load->model("ModelTransaksi");
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_filterlaporan",
            'page_title' => "Kartu Stock Barang",
            'modul' => $this->uri->segment(1),
            'action' => $this->uri->segment(2),
            'breadcrumb1' => "Laporan",
            'breadcrumb2' => "Daftar Barang"
        );
        return $this->load->view('v_home', array_merge($item, $pushdata));
    }
    
    public function index(){
        $qbarang = $this->ModelBarang->getAllItems();
        $data = array(
            'list_item' => $qbarang->result()
        );
        $this->headload($data);
    }
    
    public function ExpExcelKartu(){
        $barang = $this->input->post('nmbarang');
        $date_1 = TglPicker($this->input->post('tglawal'));
        $date_2 = TglPicker($this->input->post('tglakhir'));
                   
        $qreport = $this->ModelBarang->getDetailItems("code", $barang);
       // $qreport = $this->ModelBarang->getDetailItems("","");,
        $jml_qData = count($qreport);
        if($jml_qData < 1){
            $this->session->set_flashdata('msg_laporan', '<div class="alert alert-warning alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Belum Ada Data </div>');
            redirect('LaporanBarangMasuk');
        }
       // echo "jumlah>>> ".$jml_qData;
        $title = "KartuStockBarang";
        $filename = "KartuStockBarang";
        $spreadsheet = new Spreadsheet();
        // Set document properties
        $spreadsheet->getProperties()->setCreator($this->session->userdata('useradminlog'))
        ->setLastModifiedBy($this->session->userdata('useradminlog'))
        ->setTitle('Office 2007 XLSX Test Document')
        ->setSubject('Office 2007 XLSX Test Document')
        ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
        ->setKeywords('office 2007 openxml php')
        ->setCategory('Test result file');

                // Add some data
        $spreadsheet->setActiveSheetIndex(0)
        ->mergeCells('A1:H1')
        ->setCellValueByColumnAndRow(1, 1, "KARTU STOCK BARANG")
        ->mergeCells('A2:H2')
        ->setCellValueByColumnAndRow(1, 2, "NAMA BARANG : ".$qreport[0]->name_item."")
        ->mergeCells('A3:H3')
        ->setCellValueByColumnAndRow(1, 3, "KARTU NO. : ")
        
        ->setCellValue('A4', 'TANGGAL.')
        ->setCellValue('B4', 'NO.INVOICE')
        ->setCellValue('C4', 'KETERANGAN')
        ->mergeCells('D4:E4')
        ->setCellValueByColumnAndRow(4, 4,"MASUK")
        ->mergeCells('F4:G4')
        ->setCellValue('F4',"KELUAR")
        ->setCellValue('H4', 'SISA')
        ;
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
            'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ]];
        $style_value = [
                'font' => [
                    'bold' => false,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
                'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]];

        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
         $spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray);
          $spreadsheet->getActiveSheet()->getStyle('A3:H3')->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('A4:H4')->applyFromArray($styleArray);
        //set auto size column
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getColumnIterator() as $column) {
                $worksheet
                    ->getColumnDimension($column->getColumnIndex())
                    ->setAutoSize(true);
            } 
        } 
        // Miscellaneous glyphs, UTF-8
        $no=1;
        $i=5;
        foreach($qreport as $de){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, DateView1($de->entrydate))
            ->setCellValue('B'.$i, $de->no_faktur)
            ->setCellValue('C'.$i, $de->sales)
            ->setCellValue('D'.$i, $de->real_stock)
            ->setCellValue('E'.$i, $de->hpp_ppn)
            ->setCellValue('F'.$i, '')
            ->setCellValue('G'.$i, '')
            ->setCellValue('H'.$i, $de->qty_stock)
            ;
            $x = $i+1;
            $q2 = $this->ModelTransaksi->getDetailBK($de->id_det_item);
            $jml = count($q2);
            foreach ($q2 as $bk){
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$x, DateView1($bk->date_invoice))
                ->setCellValue('B'.$x, $bk->no_invoice)
                ->setCellValue('C'.$x, $bk->name_cust)
                ->setCellValue('D'.$x, '')
                ->setCellValue('E'.$x, '')
                ->setCellValue('F'.$x, $bk->jumlah)
                ->setCellValue('G'.$x, $bk->hrg_jual)
                ->setCellValue('H'.$x, '')
                ;
            $x++;  
            $spreadsheet->getActiveSheet()->getStyle('A'.$x.':H'.$x.'')->applyFromArray($style_value);
            }
            $i = $i+1;
            $no++;
            $spreadsheet->getActiveSheet()->getStyle('A'.$i.':H'.$i.'')->applyFromArray($style_value);
        }    

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle($title);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
        
    }
    public function tes(){
        $q1 = $this->ModelBarang->getDetailItems("code", "TN19001");
        foreach ($q1 as $a){
            echo "BM.".DateView1($a->entrydate)." | ".$a->no_faktur." | ".$a->sales." | ".$a->hpp." | ".$a->qty_stock." <br/>";
            echo '<hr/>';
            $q2 = $this->ModelTransaksi->getDetailBK($a->id_det_item);
            foreach ($q2 as $b){
                echo "BK.".DateView1($b->date_invoice)." | ".$b->no_invoice." | ".$b->name_cust." | ".$b->hrg_jual." | ".$b->jumlah."<br/>";
            }
            echo '<hr/>';
        }
    }
}