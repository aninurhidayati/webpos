<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Load library phpspreadsheet
require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// End load library phpspreadsheet

class LaporanBarangKeluar extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->Model_Security->getSecurityAdmin();
        $this->load->model("ModelBarang");
        $this->load->model("ModelTransaksi");
    }
    
    private function headload($pushdata){
        $item = array(
            'page_content' => "v_filterlaporan",
            'page_title' => "Laporan Barang Keluar",
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
    
    public function ExpExcelDataBK(){
        $barang = $this->input->post('nmbarang');
        $date_1 = TglPicker($this->input->post('tglawal'));
        $date_2 = TglPicker($this->input->post('tglakhir'));
        $status = $this->input->post('statusbyr');
        $cekdetail = $this->input->post('cekdetailBK');
        if(!isset($cekdetail)){
            $cekdetails = 0;            
        }else{
            $cekdetails = 1;
        }
            
        $qreport = $this->ModelTransaksi->exportReportBK($barang, $date_1, $date_2, $status, $cekdetails);
       // $qreport = $this->ModelBarang->getDetailItems("","");
        $jml_qData = count($qreport);
        if($jml_qData < 1){
            $this->session->set_flashdata('msg_laporan', '<div class="alert alert-warning alert-mg-b alert-st-four" role="alert">
                    <i class="fa fa-times edu-danger-error admin-check-pro admin-check-pro-none" aria-hidden="true"></i>
                    Belum Ada Data </div>');
            redirect('LaporanBarangMasuk');
        }
       // echo "jumlah>>> ".$jml_qData;
        $title = "LapBarangKeluar";
        $filename = "Lap-BarangKeluar";
        $spreadsheet = new Spreadsheet();
        // Set document properties
        $spreadsheet->getProperties()->setCreator($this->session->userdata('useradminlog'))
        ->setLastModifiedBy($this->session->userdata('useradminlog'))
        ->setTitle('Office 2007 XLSX Test Document')
        ->setSubject('Office 2007 XLSX Test Document')
        ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
        ->setKeywords('office 2007 openxml php')
        ->setCategory('Test result file');
        
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
        
        if($cekdetails < 1){
                // Add some data
                $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A1:G1')
                ->setCellValueByColumnAndRow(1, 1, "Laporan Barang Keluar ".DateView1($date_1)." s/d ".DateView1($date_2))
                ->setCellValue('A2', 'No.')
                ->setCellValue('B2', 'No. Invoice')
                ->setCellValue('C2', 'Tgl. Invoice')
                ->setCellValue('D2', 'Nama Pembeli')
                ->setCellValue('E2', 'Subtotal')
                ->setCellValue('F2', 'Total Bayar')
                ->setCellValue('G2', 'Status')
                ;
                
                $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleArray);
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
                $i=3; 
                $sum_subtotal = 0; $sum_statuspay = 0;
                foreach($qreport as $de){
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $no)
                    ->setCellValue('B'.$i, $de->no_invoice)
                    ->setCellValue('C'.$i, DateView1($de->date_invoice))
                    ->setCellValue('D'.$i, $de->name_cust)
                    ->setCellValue('E'.$i, $de->subtotal)
                    ->setCellValue('F'.$i, $de->total_payment)
                    ->setCellValue('G'.$i, $de->status_payment)
                    ;
                    $spreadsheet->getActiveSheet()->getStyle('A'.$i.':G'.$i.'')->applyFromArray($style_value);
                    $i++;
                    $no++;
                    $sum_subtotal = $sum_subtotal + $de->subtotal;
                    $sum_statuspay = $sum_statuspay + $de->total_payment;
                    
                }     
                $last = $jml_qData + 3;
                $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A'.$last.':D'.$last.'')
                ->setCellValueByColumnAndRow(1, $last, "TOTAL AKHIR")
                ->setCellValue('E'.$last.'', $sum_subtotal)
                ->setCellValue('F'.$last.'', $sum_statuspay)
                ->setCellValue('G'.$last.'', "")
                ;
                $spreadsheet->getActiveSheet()->getStyle('A'.$last.':G'.$last.'')->applyFromArray($styleArray);
        }else{
                // detail barang keluar
                $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A1:L1')
                ->setCellValueByColumnAndRow(1, 1, "Laporan Barang Keluar ".DateView1($date_1)." s/d ".DateView1($date_2))
                ->setCellValue('A2', 'No.')
                ->setCellValue('B2', 'No. Invoice')
                ->setCellValue('C2', 'Tgl. Invoice')
                ->setCellValue('D2', 'Nama Pembeli')
                ->setCellValue('E2', 'Kode Barang')
                ->setCellValue('F2', 'Nama Barang')
                ->setCellValue('G2', 'Jumlah')
                ->setCellValue('H2', 'Harga')
                ->setCellValue('I2', 'Total')
                ->setCellValue('J2', 'Subtotal')
                ->setCellValue('K2', 'Total Bayar')
                ->setCellValue('L2', 'Status')
                ;

                $spreadsheet->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray);
                //set auto size column
                foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                    foreach ($worksheet->getColumnIterator() as $column) {
                        $worksheet
                            ->getColumnDimension($column->getColumnIndex())
                            ->setAutoSize(true);
                    } 
                } 
                // Miscellaneous glyphs, UTF-8
                $no=1; $i=3; $last_invoice = ""; $urut=1;
                $sum_subtotalx = 0; $sum_totalbyrx = 0;
                foreach($qreport as $de){
                    $noinvoice = $de->no_invoice; $tgl_inv = DateView1($de->date_invoice);
                    $nmcust = $de->name_cust; $subtotal = $de->subtotal;
                    $ttl_payment = $de->total_payment; $sts_payment = $de->status_payment;
                    if($last_invoice == $noinvoice){
                        $noinvoice = ""; $tgl_inv = ""; $nmcust = "";
                        $subtotal = ""; $ttl_payment = ""; $sts_payment = ""; $urut= "";
                    }else{  
                        $urut = $no++; 
                        $sum_subtotalx = $sum_subtotalx + $de->subtotal;
                        $sum_totalbyrx = $sum_totalbyrx + $de->total_payment;
                    }
                    
                    $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $urut)
                    ->setCellValue('B'.$i, $noinvoice)
                    ->setCellValue('C'.$i, $tgl_inv)
                    ->setCellValue('D'.$i, $nmcust)
                    ->setCellValue('E'.$i, $de->kode_brg)
                    ->setCellValue('F'.$i, $de->nama_brg)
                    ->setCellValue('G'.$i, $de->jumlah)                            
                    ->setCellValue('H'.$i, $de->hrg_jual)
                    ->setCellValue('I'.$i, $de->total)
                    ->setCellValue('J'.$i, $subtotal)
                    ->setCellValue('K'.$i, $ttl_payment)
                    ->setCellValue('L'.$i, $sts_payment)
                    ;
                    $last_invoice = $de->no_invoice;
                    $spreadsheet->getActiveSheet()->getStyle('A'.$i.':L'.$i.'')->applyFromArray($style_value);                    
                    $i++;                    
                }     
                $last = $jml_qData + 3;
                $spreadsheet->setActiveSheetIndex(0)
                ->mergeCells('A'.$last.':I'.$last.'')
                ->setCellValueByColumnAndRow(1, $last, "TOTAL AKHIR")
                ->setCellValue('J'.$last.'', $sum_subtotalx)
                ->setCellValue('K'.$last.'', $sum_totalbyrx)
                ->setCellValue('L'.$last.'', "")
                ;
                $spreadsheet->getActiveSheet()->getStyle('A'.$last.':L'.$last.'')->applyFromArray($styleArray);
                
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