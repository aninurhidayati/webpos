<?php if($modul == "LaporanBarangMasuk"){ ?>
<div class="data-table-area mg-b-15" style="margin-top: 0px!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list" id="fltDaftarPerusahaan">
                    <?php
                    if (!empty($this->session->flashdata('msg_laporan'))){
                        echo $this->session->flashdata('msg_laporan');
                    }
                    ?>
                    <form action="" method="POST" class="form-horizontal" id="LapDataBM">   
                        <div class="form-group padding10"  style="display: none;" id="alert_date">
                            <span class="alert alert-danger alert-mg-b"><i class="fa fa-warning"></i> 
                                **Form Tanggal Wajib diisi, dan Tanggal Akhir Harus Lebih Besar</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Nama Barang</label>
                            <div class="col-md-4">
                                <select name="nmbarang" data-placeholder="Pilih Barang" class="form-control chosen-select" tabindex="-1">
                                    <option value="">-- Semua Data Barang -- </option>
                                    <?php 
                                    foreach ($list_item as $rw) {
                                        echo '<option value="'.$rw->code_item.'">'.$rw->name_item.'</option>';
                                    }
                                    ?>                                            
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Tanggal Faktur</label>                            
                            <div class="col-md-4">
                                <div class="data-custon-pick data-custom-mg" id="data_5">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" id="tglawal" name="tglawal" value="" placeholder="Tanggal Awal" />
                                        <span class="input-group-addon"> s/d </span>
                                        <input type="text" class="form-control" id="tglakhir" name="tglakhir" value="" placeholder="Tanggal Akhir" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Status Pembayaran</label>   
                            <div class="col-md-2">
                                <select class="form-control input-sm chosen-select" name="statusbyr" id="statusbyr">
                                    <option value="">--Semua Status--</option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7">
                                <center>
                                    <hr class="batas1" />
                                    <button type="button" id="btn_excel_dataBM" class="btn btn-md btn-success"><i class="fa fa-file-excel-o"></i> Eksport Excel</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else if($modul == "LaporanBarangKeluar"){ ?>
<div class="data-table-area mg-b-15" style="margin-top: 0px!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list" id="fltDaftarPerusahaan">
                    <?php
                    if (!empty($this->session->flashdata('msg_laporan'))){
                        echo $this->session->flashdata('msg_laporan');
                    }
                    ?>
                    <form action="" method="POST" class="form-horizontal" id="LapDataBK">   
                        <div class="form-group padding10"  style="display: none;" id="alert_date">
                            <span class="alert alert-danger alert-mg-b"><i class="fa fa-warning"></i> 
                                **Form Tanggal Wajib diisi, dan Tanggal Akhir Harus Lebih Besar</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Tanggal Faktur</label>                            
                            <div class="col-md-4">
                                <div class="data-custon-pick data-custom-mg" id="data_5">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" id="tglawal" name="tglawal" value="" placeholder="Tanggal Awal" />
                                        <span class="input-group-addon"> s/d </span>
                                        <input type="text" class="form-control" id="tglakhir" name="tglakhir" value="" placeholder="Tanggal Akhir" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Status Pembayaran</label>   
                            <div class="col-md-2">
                                <select class="form-control input-sm chosen-select" name="statusbyrBK" id="statusbyr">
                                    <option value="">--Semua Status--</option>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Detail Barang 
                                <input type="checkbox" value="1" name="cekdetailBK" id="cekdetailBK" style="margin-top: 3px!important; "/> </label>   
                                <div class="col-md-4" id="namabarangBK" style="display: none;">
                                    <select name="nmbarang" data-placeholder="Pilih Barang" class="form-control chosen-select" tabindex="-1">
                                        <option value="">-- Semua Data Barang -- </option>
                                        <?php 
                                        foreach ($list_item as $rw) {
                                            echo '<option value="'.$rw->code_item.'">'.$rw->name_item.'</option>';
                                        }
                                        ?>                                            
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7">
                                <center>
                                    <hr class="batas1" />
                                    <button type="button" id="btn_excel_dataBK" class="btn btn-md btn-success"><i class="fa fa-file-excel-o"></i> Eksport Excel</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else if($modul == "KartuStock"){ ?>
<div class="data-table-area mg-b-15" style="margin-top: 0px!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list" id="fltDaftarPerusahaan">
                    <?php
                    if (!empty($this->session->flashdata('msg_laporan'))){
                        echo $this->session->flashdata('msg_laporan');
                    }
                    ?>
                    <form action="" method="POST" class="form-horizontal" id="LapKartuStock">   
                        <div class="form-group padding10"  style="display: none;" id="alert_date">
                            <span class="alert alert-danger alert-mg-b"><i class="fa fa-warning"></i> 
                                **Form Tanggal Wajib diisi, dan Tanggal Akhir Harus Lebih Besar</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Tanggal Faktur</label>                            
                            <div class="col-md-4">
                                <div class="data-custon-pick data-custom-mg" id="data_5">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control" id="tglawal" name="tglawal" value="" placeholder="Tanggal Awal" />
                                        <span class="input-group-addon"> s/d </span>
                                        <input type="text" class="form-control" id="tglakhir" name="tglakhir" value="" placeholder="Tanggal Akhir" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Detail Barang 
                                </label>   
                                <div class="col-md-4" id="namabarangBK">
                                    <select name="nmbarang" id="nmbarang" data-placeholder="Pilih Barang" class="form-control chosen-select" tabindex="-1">
                                        <option value="">-- Semua Data Barang -- </option>
                                        <?php 
                                        foreach ($list_item as $rw) {
                                            echo '<option value="'.$rw->code_item.'">'.$rw->name_item.'</option>';
                                        }
                                        ?>                                            
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7">
                                <center>
                                    <hr class="batas1" />
                                    <button type="button" id="btn_excel_kartustock" class="btn btn-md btn-success"><i class="fa fa-file-excel-o"></i> Eksport Excel</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }