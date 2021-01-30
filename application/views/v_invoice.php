<!DOCTYPE html>
<html>
<base href="<?php echo base_url();?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Cetak Faktur Barang Keluar</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="assets/fungsi_terbilang.js"></script>
</head>
<style type="text/css">
	body {
		width: 100%;
		height: 100%;
		margin: 0;
		padding: 0;
		background: #555;
		font: 12pt "Tahoma";
	}

	* {
		box-sizing: border-box;
	}
        .table{
            border: #000000 solid thin;
        }
        .table tr th{
            border: #000000 solid thin;font-size: 15px;
            text-align: center;
        }
        .table tr td{
            border: #444 solid thin; font-size: 15px;
        }
	.table-kartu{
	  font-size: 13px;
	  /*width: 100%;*/
	}

	.table-kartu td{
	  /*border: 1px solid #000;*/
	  background: #fff;
	  padding: 1px;
	  font-size: 15px;
	  padding: 2px;
	}

	.bingkai {
	  border: 0px solid #000000;
	  width: 100%;
	  /*height: 10.75cm;*/
	  padding: 10px;
	}

	.text-underline{
	  text-decoration: underline;
	}

	.text-bold{
	  font-weight: bold;
	}

	.garis{
	  border: 1px solid #000000;
	  margin-top: 60px;
	}

	.width-1{
	  width: 1%;
	}

	.width-2{
	  width: 2%;
	}

	.width-3{
	  width: 3%;
	}

	.width-4{
	  width: 4%;
	}

	.width-5{
	  width: 5%;
	}

	.width-10{
	  width: 10%;
	}

	.width-16{
	  width: 16%;
	}

	.width-15{
	  width: 15%;
	}

	.width-25{
		width: 25%;
	}

	.width-30{
	  width: 30%;
	}

	.width-32{
	  width: 32%;
	}

	.box{
	  width: 15px;
	  height: 15px;
	  display: inline-block;
	  border: 1px solid !important;
	}

	.box-disabled{
	  width: 15px;
	  height: 15px;
	  display: inline-block;
	}

	.page {
		width: 215mm;
		min-height: 140mm;
		padding: 5mm;
		/*margin: 10mm auto;*/
		margin: 0mm auto;
		border: 1px #D3D3D3;
		border-radius: 1px;
		background: white;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
	}

	.subpage {
		padding: 1cm;
		border: 5px red solid;
		height: 257mm;
		outline: 2cm #FFEAEA solid;
	}

	@page {
		size: A5;
		margin: 0;
	}

	@media print {
		html, body {
			width: 215mm;
			height: 140mm;
		}

		.page {
			margin: 0;
			border: initial;
			border-radius: initial;
			width: initial;
			min-height: initial;
			box-shadow: initial;
			background: initial;
			page-break-after: always;
		}

		#navigation{
		  display: none;
		}
	}
</style>
<body>
    <div class="col-md-12" id="navigation" style="position: fixed;">
        <div class="row">
            <div class="col-md-2" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; padding: 15px 15px; color: #fff; text-align: center;">
                <a href="<?php echo base_url("DataBarangKeluar"); ?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
            </div>
            <div class="col-md-2 pull-right" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; padding: 10px 15px 5px 15px">
                <ul>
                  <li style="font-size: 12pt; color: #fff; width: 100%; cursor: pointer;" id="print"><i class="fa fa-print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i> Print</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="book">
       <div class="page">
           <div class="bingkai">
               <table class="table-kartu">
                   <tr>
                       <td><b></b></td>
                       <td class="width-25"> </td>
                       <td ><b style="padding-left: 190px!important;">Kepada Yth. </b></td>
                       <td>: <?php echo $item->name_cust; ?> </td>
                   </tr>
                   <tr>
                       <td><b>No. Faktur</b></td>
                       <td class="width-25">: <?php echo $item->no_invoice; ?></td>
                       <td style="padding-left: 30px!important;"></td>
                       <td></td>
                   </tr>
                   <tr>
                       <td><b>Tgl. Faktur</b></td>
                       <td class="width-25">: <?php echo DateView1($item->date_invoice); ?></td>
                       <td style="padding-left: 30px!important;"></td>
                       <td></td>
                   </tr>
                   <tr>
                       <td colspan="4">
                           
                       </td>
                   </tr>
               </table>
               <table class="table" style="border: #000000 solid thin;" id="tbl_barangkeluar">
                    <thead>
                        <tr>
                            <th class="colw3">No</th>
                            <th>Nama Barang</th>
                            <th class="colw10">Jumlah</th>
                            <th class="colw15">Harga</th>
                            <th class="colw20 text-center" >Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no=1;
                        foreach ($qdetail as $rw) {
                            echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$rw->nama_brg.'</td>
                                <td><center>'.$rw->jumlah.'</center></td>
                                <td><span class="pull-right">'.rupiah($rw->hrg_jual).'</span></td>
                                <td><span class="pull-right">'.rupiah($rw->total).'</span></td>
                            </tr>';   
                            $no++;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="border-pdt-ct"><td colspan="5" style="padding: 0px!important;"></td></tr>
                        <tr>
                            <td colspan="3">Terbilang: <span id="terbilang_fakturbk" 
                             style="text-transform: capitalize; font-style: italic; font-size: 13px!important;"></span></td>
                            <td  class="text-right">SubTotal</td>
                            <td class="text-right"><?php echo rupiah($item->subtotal); ?>
                                <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $item->subtotal; ?>" readonly="true" class="inputku text-right">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><span style="font-size: 17px!important;">
                                    <b class="label label-danger"><?php // echo $item->status_payment; ?></b></span></td>
                            <td colspan="1" class="text-right"></td>
                            <td class="text-right"><?php // echo rupiah($item->total_payment); ?>
                                <input type="hidden" name="totalbayar" id="totalbayar" value="<?php echo rupiah($item->total_payment); ?>" readonly="true"  class="inputku text-right">
                            </td>
                        </tr>
                    </tfoot>
                </table>
           </div>
       </div>
    </div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){

    $('#print').click(function(evt){
        evt.preventDefault();
        window.print();
    });
    
    var nilai_bm = $('#totalpayment_bm').val();
    var nilai_bk = $('#subtotal').val();
    if(nilai_bk){
        $('#terbilang_fakturbk').append(terbilang(nilai_bk));
    } else 
    if(nilai_bm){
        $('#terbilang_fakturbm').append(terbilang(nilai_bm));
    }
 });
</script>