<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php if(empty($action)){ ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <?php
                            if (!empty($this->session->flashdata('msg_saveitem'))){
                                echo $this->session->flashdata('msg_saveitem');
                            }
                        ?>
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <a href="<?php echo base_url(''.$modul.'/input'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
<!--                                <select class="form-control dt-tb">
                                    <option value="">Export Basic</option>
                                    <option value="all">Export All</option>
                                    <option value="selected">Export Selected</option>
                                </select>-->
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="false" data-show-pagination-switch="false"
                                   data-show-refresh="true" data-key-events="true" data-show-toggle="false" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead  style="margin: 1px!important;">
                                    <tr>
                                        <th class="colw3" style="padding: 5px!important; line-height: normal!important;">#</th>
                                        <th class="colw10">No.Faktur</th>
                                        <th class="colw10">Tgl.Masuk</th>                                        
                                        <th>Sales</th>
                                        <th class="colw10">Tgl.Jatuh Tempo</th>
                                        <th class="colw15">Total Faktur</th>
                                        <th class="colw15">Jumlah Bayar</th>
                                        <th class="colw15">Status bayar</th>
                                        <th class="colw7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($list_item as $rw) {
                                        if(($rw->total_payment) == ($rw->jml_bayar)){
                                            $status = "Lunas";
                                        } else { $status = "Belum Lunas"; }
                                        echo '
                                        <tr>
                                            <td>'.$no.'</td>
                                            <td>'.$rw->no_faktur.'</td>
                                            <td>'. DateView1($rw->entrydate).'</td>
                                            <td>'.$rw->sales.'</td>
                                            <td>'.DateView1($rw->tgl_jatuhtempo).'</td>
                                            <td><span class="pull-right">'.rupiah($rw->total_payment).'</span></td>
                                            <td><span class="pull-right">'.rupiah($rw->jml_bayar).'</span></td>
                                            <td class="text-center">'.$status.'</td>
                                            <td>
                                               <a href="'. base_url('DataBarangMasuk/detailFaktur/'.base64_encode($rw->idhead).'').'" class="btn btn-xs btn-custon-four btn-default" title="Detail Data"><i class="fa fa-list"></i></a>
                                               <a href="'. base_url('DataBarangMasuk/delete/'.base64_encode($rw->idhead).'').'" class="btn btn-xs btn-custon-four btn-default" title="Hapus Data"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>';   
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } else 
                if(!empty($action) && ($action === "input")){    
                ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <form action="<?php echo base_url('DataBarangMasuk/save'); ?>" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label"><b>No. Faktur</b></label>
                                <input type="text" id="nofaktur_bm" name="nofaktur_bm" class="form-control input-sm"
                                       oninvalid="this.setCustomValidity('No Faktur harus diisi!')"
                                       oninput="setCustomValidity('')" required="true"/>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group data-custon-pick" id="data_1">
                                    <label class="control-label"><b>Tanggal Masuk</b></label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" id="tgl_masuk" name="tgl_masuk" class="form-control" 
                                               oninvalid="this.setCustomValidity('Tanggal Masuk harus diisi!')"
                                               oninput="setCustomValidity('')" required="true"
                                               value="<?php echo date('d/m/Y');?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label"><b>Sales/Toko</b></label>
                                <input type="text" name="sales" class="form-control input-sm" 
                                       oninvalid="this.setCustomValidity('Sales harus diisi!')"
                                       oninput="setCustomValidity('')" required="true" />
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <div class="form-group data-custon-pick" id="data_1">
                                    <label class="control-label"><b>Tgl.Jatuh Tempo</b></label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" id="tgl_masuk" name="tgl_tempo" class="form-control" 
                                               oninvalid="this.setCustomValidity('Tgl.Jatuh Tempo harus diisi!')"
                                               oninput="setCustomValidity('')" required="true"
                                               value="<?php echo date('d/m/Y');?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">                                
                            <div class="col-md-5">
                                <label class="control-label"><b>Pilih Barang</b></label>
                                <div class="input-knob-dial-wrap">
                                    <div class="chosen-select-single mg-b-20">
                                        <select name="barang" data-placeholder="Pilih Barang" id="cariDataBarang"
                                            class="form-control chosen-select" tabindex="-1">
                                            <option value="">Cari Data Barang</option>
                                            <?php 
                                            foreach ($list_item as $rw) {
                                                echo '<option value="'.$rw->code_item.'-'.$rw->name_item.'">'.$rw->name_item.'</option>';
                                            }
                                            ?>                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label class="control-label">Jumlah</label>
                                <input type="text" id="jml_stok" name="jml_stok" class="form-control input-sm" />                                        
                            </div>
                            <div class="col-md-1" style="display: none;">
                                <label class="control-label">Satuan</label>
                                <input type="text" class="form-control input-sm" id="satuan" value="<?php echo $satuan ?>" />
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">Harga Satuan</label>
                                <input type="text" id="hpp" name="hpp" class="form-control input-sm" />
                            </div> 
                            <div class="col-md-1">
                                <label class="control-label">PPN(%)</label>
                                <input type="text" class="form-control input-sm" name="ppn" id="ppn" value="10" />
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-success" id="btnTambahBarang" style="margin-top: 23px!important;">
                                    <i class="fa fa-plus-circle"></i> Tambah Barang</button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-11"> 
                                <hr style="margin-bottom: 0px!important;"/>
                                <div class="static-table-list">
                                <table class="table" id="detailtabelbarang">
                                    <thead>
                                        <tr>
                                            <th class="colw3">#</th>
                                            <th class="colw15">Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th class="colw10">Jumlah</th>
                                            <th class="colw15">Harga Satuan</th> 
                                            <th class="colw15">HPP</th>                                            
                                            <th class="colw15 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                    </tbody>
                                    <tfoot>
                                        <tr class="border-pdt-ct"><td colspan="6" style="padding: 0px!important;"></td></tr>
                                        <tr>
                                            <td colspan="4"><span style="font-size: 12px!important;"></span>
                                            </td>
                                            <td colspan="2" class="text-right">SubTotal</td>
                                            <td>
                                                <input type="text" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>" readonly="true" class="text-right inputku">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><span style="font-size: 12px!important;"></span></td>
                                            <td  class="text-right">PPN</td>
                                            <td>
                                                <input type="text" name="txt_ppn" id="txt_ppn" value="0" readonly="true" class="inputku text-right">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><span style="font-size: 12px!important;"></span></td>
                                            <td colspan="2" class="text-right">Total Pembayaran</td>
                                            <td>
                                                <input type="text" name="totalbayar" id="totalbayar" value="0" class="inputku text-right">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><span style="font-size: 12px!important;"></span></td>
                                            <td colspan="2" class="text-right">Jumlah Bayar</td>
                                            <td>
                                                <input type="text" name="jmlbayar" id="jmlbayar" value="0"  class="inputku text-right">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr style="margin-top: 0px!important;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row form-footer"> 
                            <div class="col-md-3"></div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                <a href="<?php echo base_url("DataBarangMasuk"); ?>" class="btn btn-sm btn-default">
                                    <i class="fa fa-times"></i> Batal</a>
                            </div>
                        </div>  
                        </form>
                    </div>
                </div>
                <?php } else if(!empty ($action) && $action == "detailFaktur") { ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">                        
                        <form action="<?php echo base_url('DataBarangMasuk/updatebayar'); ?>" method="POST">
                            <div class="row">
                                <label class="col-md-2 control-label"><b>No. Faktur</b></label>
                                <div class="col-md-3">: <?php echo $dtitem[0]->no_faktur; ?></div>
                                <label class="col-md-2 control-label"><b>Sales</b></label>
                                <div class="col-md-4">: <?php echo $dtitem[0]->sales; ?></div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 control-label"><b>Tanggal Faktur</b></label>
                                <div class="col-md-3">: <?php echo DateView1($dtitem[0]->entrydate); ?></div>
                                <label class="col-md-2 control-label"><b>Tgl. Jatuh Tempo</b></label>
                                <div class="col-md-4">: <?php echo DateView1($dtitem[0]->tgl_jatuhtempo); ?></div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-10"> 
                                    <hr style="margin-bottom: 0px!important;"/>
                                    <div class="static-table-list">
                                    <table class="table" id="tbl_barangkeluar">
                                        <thead>
                                            <tr>
                                                <th class="colw3">No</th>
                                                <th>Nama Barang</th>
                                                <th class="colw10">Jumlah</th>
                                                <th class="colw15">HPP</th>
                                                <th class="colw15 text-center" >Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no=1;
                                            foreach ($dtitem as $rw) {
                                                echo '
                                                <tr>
                                                    <td>'.$no.'</td>
                                                    <td>'.$rw->name_item.'</td>
                                                    <td>'.$rw->qty_stock.' '.$rw->satuan.'</td>
                                                    <td>'.rupiah($rw->hpp).'</td>
                                                    <td><span class="pull-right">'.rupiah($rw->total).'</span></td>
                                                </tr>';   
                                                $no++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot class="ftebal5">
                                            <tr class="border-pdt-ct"><td colspan="5" style="padding: 0px!important;"></td></tr>
                                            <tr >
                                                <td colspan="2"><span style="font-size: 12px!important;"></span>
                                                </td>
                                                <td colspan="2" class="text-right">SubTotal</td>
                                                <td class="text-right"><?php echo rupiah($dtitem[0]->subtotal); ?></td>                                                   
                                            </tr>
                                            <tr>
                                                <td colspan="2"><span style="font-size: 12px!important;"></span>
                                                </td>
                                                <td colspan="2" class="text-right">PPN</td>
                                                <td class="text-right"><?php echo rupiah($dtitem[0]->ppn); ?></td>                                                   
                                            </tr>
                                            <tr>
                                                <td colspan="2">Terbilang: <span id="terbilang_fakturbm" 
                                                 style="text-transform: capitalize; font-style: italic; font-size: 13px!important;"></span></td>
                                                 <td colspan="2" class="text-right">Total Pembayaran</td>
                                                <td class="text-right">
                                                    <input type="hidden" id="totalpayment_bm" value="<?php echo ($dtitem[0]->total_payment); ?>" />
                                                    <?php echo rupiah($dtitem[0]->total_payment); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="font-size: 17px!important;">                                                    
                                                    <?php
                                                    if(($dtitem[0]->total_payment) == ($dtitem[0]->jml_bayar)){
                                                        echo '<label class="label label-danger">LUNAS</label>';
                                                    } else {
                                                        echo '<label class="label label-danger">BELUM LUNAS</label>';
                                                    }
                                                    ?>
                                                </td>
                                                <td colspan="2" class="text-right">Jumlah Bayar</td>
                                                <td class="text-right"><?php echo rupiah($dtitem[0]->jml_bayar); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    </div>  
                                </div>           
                            </div>
                            <hr class="garis"/>
                            <?php if(($dtitem[0]->total_payment) != ($dtitem[0]->jml_bayar)){ ?>
                            <div class="row">
                                <label class="control-label col-md-3">Pelunasan Pembayaran</label>
                                <div class="col-md-2">
                                    <input type="hidden" name="id" class="form-control input-sm" value="<?php echo base64_decode($this->uri->segment(3)); ?>" />   
                                    <input type="text" name="jml_bayar" class="form-control input-sm" placeholder="jumlah bayar" />  
                                    <input type="hidden" name="total" class="form-control input-sm" value="<?php echo $dtitem[0]->total_payment; ?>" />  
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan Pembayaran</button>
                                </div>
                            </div>
                            <hr class="garis"/>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-10 text-left">
                                    <a href="<?php echo base_url("DataBarangMasuk"); ?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                <?php } else 
                if(!empty($action) && ($action === "edit")){    
                ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <form action="<?php echo base_url('DataBarangMasuk/update'); ?>" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="hidden" name="iddetail" value="<?php echo $iddetail; ?>" />
                                <div class="form-group data-custon-pick" id="data_1">
                                    <label class="control-label"><b>Tanggal Masuk</b></label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" id="tgl_masuk" name="tgl_masuk" class="form-control" 
                                               value="<?php echo DateView1($dtitem->entrydate); ?>">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">                                
                            <div class="col-md-8">
                                <label class="control-label"><b>Pilih Barang</b></label>
                                <div class="input-knob-dial-wrap">
                                    <div class="chosen-select-single mg-b-20">
                                        <input type="hidden" value="<?php echo $dtitem->code_item; ?>" name="exkodebarang" />
                                        <select name="barang" data-placeholder="Pilih Barang" id="cariDataBarang"
                                            class="form-control chosen-select" tabindex="-1">
                                            <option value="">Cari Data Barang</option>
                                            <?php 
                                            $brg = $dtitem->code_item;
                                            foreach ($list_item as $rw) {
                                                if($brg === $rw->code_item){ $sel="selected"; } else{ $sel=""; }
                                                echo '<option value="'.$rw->code_item.'" '.$sel.'>'.$rw->name_item.'</option>';
                                            }
                                            ?>                                            
                                        </select>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">HPP</label>
                                <input type="text" id="hpp" name="hpp" class="form-control input-sm" value="<?php echo $dtitem->hpp; ?>" />
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">Jumlah Stok</label>
                                <input type="hidden" id="jml_stok1" name="stoklama" value="<?php echo $dtitem->qty_stock; ?>" class="form-control input-sm" />              
                                <input type="text" id="jml_stok" name="jml_stok" value="<?php echo $dtitem->qty_stock; ?>" class="form-control input-sm" />                                        
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">Satuan</label>
                                <select name="satuan" class="form-control input-sm" id="satuan">
                                    <option value="0">Pilih Satuan</option>
                                    <?php 
                                    $stn = $dtitem->satuan;
                                    foreach ($listsatuan->result() as $rw) {
                                        if($stn === $rw->value){ $sel="selected"; } else{ $sel=""; }
                                        echo '<option value="'.$rw->value.'" '.$sel.'>'.$rw->value.'</option>';
                                    }
                                    ?>  
                                </select>                                        
                            </div>                            
                        </div>
                        <div class="row form-footer">
                            <div class="col-md-6">
                                <hr style="margin-bottom: 0px!important;" />
                                <button type="submit" class="btn btn-sm btn-success" id="btnUbahBarang" style="margin-top: 23px!important;">
                                    <i class="fa fa-save"></i> Simpan Ubah Data</button>
                                <a href="<?php echo base_url('DataBarangMasuk'); ?>" class="btn btn-sm btn-default"  style="margin-top: 23px!important;">
                                    <i class="fa fa-times"></i> Batal</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <?php } else
                    if(!empty($action) && ($action === "detail")){ 
                ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <?php
                            if (!empty($this->session->flashdata('msg_saveitem'))){
                                echo $this->session->flashdata('msg_saveitem');
                            }
                        ?>
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <a href="<?php echo base_url(''.$modul.'/input'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
<!--                                <select class="form-control dt-tb">
                                    <option value="">Export Basic</option>
                                    <option value="all">Export All</option>
                                    <option value="selected">Export Selected</option>
                                </select>-->
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="false" data-show-pagination-switch="false"
                                   data-show-refresh="true" data-key-events="true" data-show-toggle="false" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead  style="margin: 1px!important;">
                                    <tr>
                                        <th class="colw3" style="padding: 5px!important; line-height: normal!important;">#</th>
                                        <th class="colw10">Tgl.Faktur</th>
                                        <th class="colw10">No.Faktur</th>
                                        <th>Nama Barang</th>
                                        <th class="colw15">HPP</th>
                                        <th class="colw10 ">Jumlah Stok</th>                                        
                                        <th class="colw5">Sisa Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($list_item as $rw) {
                                        echo '
                                        <tr>
                                            <td>'.$no.'</td>
                                            <td>'. DateView1($rw->entrydate).'</td>
                                            <td>'.$rw->no_faktur.'</td>
                                            <td>'.$rw->name_item.'</td>
                                            <td><span class="pull-right">'.rupiah($rw->hpp_ppn).'</span></td>
                                            <td class="text-center">'.$rw->real_stock.'</td>
                                            <td class="text-center">'.$rw->qty_stock.'</td>
                                        </tr>';   
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-10 text-left">
                                <br/>
                                <a href="<?php echo base_url("DataBarang"); ?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>