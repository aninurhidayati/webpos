<!DOCTYPE html>
<html>
<base href="<?php echo base_url();?>">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Disnaker Situbondo</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>

  <style>

    @page { margin: 5px; }

    .page_break { page-break-before: always; }

    .page-number:after { content: counter(page); }

    #table-data{
      font-size: 10pt;
      margin-top: 10px;
      border: 1px solid #555;
    }
    #table-data th{
      border: 1px solid #aaa;
      border-collapse: collapse;
      border-bottom: 3px solid #ccc;
      background: #fff;
      padding: 8px 15px;
      font-size: 15pt;
    }

    #table-data td{
      border: 1px solid #ccc;
      vertical-align: top;
    }

    #table-data td.currency{
      text-align: right;
      padding-right: 5px;
    }

    #table-data td.no-border{
      border: 0px;
    }

    #table-data td.total.not-same{
     color: red !important;
     -webkit-print-color-adjust: exact;
   }

   #table-data-inside{
    font-size: 9pt;
    margin-top: 5px;
  }

  #table-data-inside td{
    padding: 5px 15px;
    border: 0px solid #333;
  }

  #table-data-inside td.lv1{
    padding: 5px 10px;
  }

  #table-data-inside td.lv2{
    padding: 5px 10px;
  }

  #table-data-inside td.lv3{
    padding: 5px 10px;
    font-style: italic;
  }

  #table-data-inside td.money{
    text-align: right;
    padding: 5px 10px;
    font-weight: bold;
  }

  #table-data-inside td.total{
    border-top: 2px solid #777; ;
  }

  #navigation ul{
    float: right;
    padding-right: 110px;
  }

  #navigation ul li{
    color: #fff;
    font-size: 15pt;
    list-style-type: none;
    display: inline-block;
    margin-left: 40px;
  }

  #form-table{
    font-size: 15pt;
  }

  #form-table td{
    padding: 5px 0px;
  }

  #form-table .form-control{
    height: 30px;
    width: 90%;
    font-size: 15pt;
  }

  .table-kartu{
    font-size: 12px;
    /*width: 100%;*/
  }

  .table-kartu td{
    /*border: 1px solid #000;*/
    background: #fff;
    padding: 5px;
    font-size: 13px;
    
  }

  .bingkai {
    border: 1px solid #000000;
    width: 100%;
    /*height: 10.75cm;*/
    padding: 5px;
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

  .width-30{
    width: 30%;
  }

  .width-32{
    width: 32%;
  }

  .box{
    width: 20px;
    height: 20px;
    display: inline-block;
    border: 1px solid !important;
  }

  .box-disabled{
    width: 20px;
    height: 20px;
    display: inline-block;
  }

  .page {
    width: 210mm;
    min-height: 297mm;
    padding: 20mm;
    margin: 10mm auto;
    border: 1px #D3D3D3;
    border-radius: 5px;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }

</style>

<style type="text/css" media="print">
  @page { size: landscape; }
  html, body{
    width: 36cm;
    height: 11cm;
  }
  #navigation{
    display: none;
  }

  .page-break { display: block; page-break-before: always; }
</style>
</head>
<body style="background: #555;">
  <div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
    <div class="row">
      <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
        Disnaker Situbondo
      </div>
      <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
        <ul>
          <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-12" style="background: white; padding: 10px 10px; margin-top: 80px;">
    <div class="bingkai">
        <table class="table-kartu"></table>
    </div>
  </div>
</body>
</html>