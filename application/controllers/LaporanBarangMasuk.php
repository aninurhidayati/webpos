<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Load library phpspreadsheet
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// End load library phpspreadsheet

class LaporanBarangMasuk extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model("ModelBarang");
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_filterlaporan",
            'page_title' => "Laporan Barang Masuk",
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
            'titleform' => "Laporan Daftar Perusahaan",
            'list_item' => $qbarang->result()
        );
        $this->headload($data);
    }
    
    public function ExpExcelDataBM(){
        $barang = $this->input->post('nmbarang');
        $date_1 = TglPicker($this->input->post('tglawal'));
        $date_2 = TglPicker($this->input->post('tglakhir'));
        $status = $this->input->post('statusbyr');
            
        $qreport = $this->ModelBarang->exportReportBM($barang, $date_1, $date_2, $status);
       // $qreport = $this->ModelBarang->getDetailItems("","");
        $jml_qData = count($qreport);
        if($jml_qData < 1){
            $this->session->set_flashdata('msg_laporan', '<div class="alert alert-warning alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Belum Ada Data </div>');
            redirect('LaporanBarangMasuk');
        }
      
        $title = "LapBarangMasuk";
        $filename = "Lap".date("dmy")."-BarangMasuk";
         $spreadsheet = new Spreadsheet();
        // Set document properties
        $spreadsheet->getProperties()->setCreator($this->session->userdata('useradminlog'))
        ->setLastModifiedBy($this->session->userdata('useradminlog'))
        ->setTitle('Office 2007 XLSX Test Document')
        ->setSubject('Office 2007 XLSX Test Document')
        ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
        ->setKeywords('office 2007 openxml php')
        ->setCategory('Test result file');
        if(empty($barang)){
            // Add some data
            $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A1:N1')
                ->setCellValueByColumnAndRow(1, 1, "Laporan Barang Masuk ".DateView1($date_1)." s/d ".DateView1($date_2))
                ->setCellValue('A2', 'No. Faktur')
                ->setCellValue('B2', 'Tgl. Faktur')
                ->setCellValue('C2', 'Tgl. Jatuh Tempo')
                ->setCellValue('D2', 'Sales')
                ->setCellValue('E2', 'Kode Barang')
                ->setCellValue('F2', 'Nama Barang')
                ->setCellValue('G2', 'Jumlah')
                ->setCellValue('H2', 'Harga Satuan')    
                ->setCellValue('I2', 'HPP')
                ->setCellValue('J2', 'Total')
                ->setCellValue('K2', 'Subtotal')
                ->setCellValue('L2', 'PPN')            
                ->setCellValue('M2', 'Total Bayar')
                ->setCellValue('N2', 'Jumlah Bayar')
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

            $spreadsheet->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);
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
            $i=3; $lastfaktur = "";
            $sum_subtotal = 0; $sum_totalpay = 0; $sum_jmlbyr = 0;
            foreach($qreport as $de){
                $faktur = $de->no_faktur; $tglfaktur = DateView1($de->entrydate);
                $tgltempo = DateView1($de->tgl_jatuhtempo); $subtotal = $de->subtotal;
                $sales = $de->sales; $hpp = $de->hpp; $total= $de->total;
                $ppn = $de->ppn; $totalpay = $de->total_payment;
                $hpp_ppn = $de->hpp_ppn;
                $jml_bayar = $de->jml_bayar;
                if($lastfaktur == $faktur){
                    $faktur = ""; $tglfaktur = ""; $sales = "";
                    $tgltempo = ""; $subtotal = "";
                    $ppn = ""; $totalpay = ""; $jml_bayar = "";
                }else{
                    $sum_subtotal = $sum_subtotal + $de->subtotal;
                    $sum_totalpay = $sum_totalpay + $de->total_payment;
                    $sum_jmlbyr = $sum_jmlbyr + $de->jml_bayar;
                }
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $faktur)
                ->setCellValue('B'.$i, $tglfaktur)
                ->setCellValue('C'.$i, $tgltempo)
                ->setCellValue('D'.$i, $sales)
                ->setCellValue('E'.$i, $de->code_item)
                ->setCellValue('F'.$i, $de->name_item)
                ->setCellValue('G'.$i, $de->real_stock)
                ->setCellValue('H'.$i, $hpp)
                ->setCellValue('I'.$i, $hpp_ppn)
                ->setCellValue('J'.$i, $total)
                ->setCellValue('K'.$i, $subtotal) 
                ->setCellValue('L'.$i, $ppn)
                ->setCellValue('M'.$i, $totalpay)
                ->setCellValue('N'.$i, $jml_bayar)
                ;
                $lastfaktur = $de->no_faktur;
                $spreadsheet->getActiveSheet()->getStyle('A'.$i.':M'.$i.'')->applyFromArray($style_value);                
                $i++;
                $no++;            
            }  
                $last = $jml_qData + 3;
                $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A'.$last.':J'.$last.'')
                ->setCellValueByColumnAndRow(1, $last, "TOTAL AKHIR")
                ->setCellValue('K'.$last.'', $sum_subtotal)
                ->setCellValue('L'.$last.'', '')
                ->setCellValue('M'.$last.'', $sum_totalpay)
                ->setCellValue('N'.$last.'', $sum_jmlbyr)
                ;
                $spreadsheet->getActiveSheet()->getStyle('A'.$last.':N'.$last.'')->applyFromArray($styleArray);
        }else{
            // Add some data
            $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A1:L1')
                ->setCellValueByColumnAndRow(1, 1, "Laporan Barang Masuk ".DateView1($date_1)." s/d ".DateView1($date_2))
                ->setCellValue('A2', 'No. Faktur')
                ->setCellValue('B2', 'Tgl. Faktur')
                ->setCellValue('C2', 'Tgl. Jatuh Tempo')
                ->setCellValue('D2', 'Sales')
                ->setCellValue('E2', 'Kode Barang')
                ->setCellValue('F2', 'Nama Barang')
                ->setCellValue('G2', 'Jumlah Stok')
                ->setCellValue('H2', 'HPP')
                ->setCellValue('I2', 'Sisa Stok')
            ;
            $styleArray = [
                'font' => [
                    'bold' => true,
                    'size' => 12
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

            $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
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
            $i=3; $lastfaktur = "";
            foreach($qreport as $de){
                $faktur = $de->no_faktur; $tglfaktur = DateView1($de->entrydate);
                $tgltempo = DateView1($de->tgl_jatuhtempo); $subtotal = $de->subtotal;
                $sales = $de->sales; $hpp = $de->hpp_ppn; $total= $de->total;
                $ppn = $de->ppn; $totalpay = $de->total_payment;
                $jml_bayar = $de->jml_bayar;
                if($lastfaktur == $faktur){
                    $faktur = ""; $tglfaktur = ""; $sales = "";
                    $tgltempo = ""; $subtotal = "";
                    $ppn = ""; $totalpay = ""; $jml_bayar = "";
                }
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $faktur)
                ->setCellValue('B'.$i, $tglfaktur)
                ->setCellValue('C'.$i, $tgltempo)
                ->setCellValue('D'.$i, $sales)
                ->setCellValue('E'.$i, $de->code_item)
                ->setCellValue('F'.$i, $de->name_item)
                ->setCellValue('G'.$i, $de->real_stock)
                ->setCellValue('H'.$i, $hpp)
                ->setCellValue('I'.$i, $de->qty_stock)
                ;
                $lastfaktur = $de->no_faktur;
                $spreadsheet->getActiveSheet()->getStyle('A'.$i.':I'.$i.'')->applyFromArray($style_value);
                $i++;
                $no++;            
            }  
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
}