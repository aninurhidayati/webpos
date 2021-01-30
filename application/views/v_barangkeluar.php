<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php if(empty($action)){ ?>
                <?php
                    if (!empty($this->session->flashdata('msg_saveitemout'))){
                        echo $this->session->flashdata('msg_saveitemout');
                    }
                ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <a href="<?php echo base_url('DataBarangKeluar/input'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
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
                                        <th>Nama Pembeli</th>
                                        <th class="colw15">Subtotal</th>
                                        <th class="colw15">Total Bayar</th>  
                                        <th class="colw10">Status Bayar</th>
                                        <th class="colw7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($list_bk as $rw) {
                                        echo '
                                        <tr>
                                            <td>'.$no.'</td>
                                            <td>'.DateView1($rw->date_invoice).'</td>
                                            <td>'.$rw->no_invoice.'</td>
                                            <td>'.$rw->name_cust.'</td>
                                            <td><span class="pull-right">'.rupiah($rw->subtotal).'</span></td>
                                            <td><span class="pull-right">'.rupiah($rw->total_payment).'</span></td>
                                            <td class="text-center">'.$rw->status_payment.'</td>
                                            <td>
                                               <a href="'. base_url('DataBarangKeluar/detail/'.base64_encode($rw->id_invoice).'').'" class="btn btn-xs btn-custon-four btn-default" title="Detail Data"><i class="fa fa-list"></i></a>
                                                   <a href="'.base_url('DataBarangKeluar/cetakInvoiceBK/'.base64_encode($rw->id_invoice).'').'" class="btn btn-xs btn-custon-four btn-default"><i class="fa fa-print"></i></a>
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
                if(!empty($action) && ($action === "input" || $action === "edit" )){    
                ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">             
                        <?php
                            if (!empty($this->session->flashdata('msg_saveitemout'))){
                                echo $this->session->flashdata('msg_saveitemout');
                            }
                        ?>
                        <form action="<?php echo base_url('DataBarangKeluar/save'); ?>" method="POST">
                            <div class="row">        
                                <div class="col-md-2">
                                    <label class="control-label"><b>No. Faktur</b></label>
                                    <input type="text" name="nofaktur_bk" id="nofaktur_bk" class="form-control"
                                        oninvalid="this.setCustomValidity('Nomor Faktur harus diisi!')"
                                        oninput="setCustomValidity('')" required="true">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group data-custon-pick" id="data_1">
                                        <label class="control-label"><b>Tanggal Faktur</b></label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" name="tgl_faktur" class="form-control" 
                                                oninvalid="this.setCustomValidity('Tanggal Faktur harus diisi!')"
                                                oninput="setCustomValidity('')" required="true"
                                                value="<?php echo date("d/m/Y")?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-knob-dial-wrap">
                                        <div class="chosen-select-single mg-b-20">
                                            <label class="control-label"><b>Customer</b></label>
                                            <select name="nmcustomer" data-placeholder="Pilih Pembeli" 
                                                oninvalid="this.setCustomValidity('Pembeli belum dipilih!')"
                                                oninput="setCustomValidity('')" required="true"
                                                class="form-control chosen-select" tabindex="-1">
                                                <option value="">Pilih Pembeli</option>
                                                <?php 
                                                foreach ($list_cust as $rw) {
                                                    echo '<option value="'.$rw->id_customer.'">'.$rw->name_cust.'</option>';
                                                }
                                                ?>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-knob-dial-wrap">
                                        <div class="chosen-select-single mg-b-20">
                                            <label class="control-label"><b>Nama Barang</b></label>
                                            <select name="brg_keluar" id="brg_keluar" data-placeholder="Pilih Barang" class="form-control chosen-select" tabindex="-1">
                                                <option value="" style="font-weight: bold;">
                                                Tgl.Masuk | Nama Barang | HPP </option>
                                                <?php 
                                                foreach ($list_item as $rw) {
                                                    echo '<option value="'.$rw->id_det_item.'/'.$rw->code_item.'/'.$rw->name_item.'/'.$rw->hpp_ppn.'/'.$rw->qty_stock.'">'
                                                            . ''.DateView2($rw->entrydate).' | '.$rw->name_item.' | Rp.'.$rw->hpp_ppn.'</option>';
                                                }
                                                ?>    
                                            </select>
                                            <input type="hidden" id="bm_stok" value="" />
                                            <input type="hidden" id="bm_hpp" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label class="control-label">Jumlah</label>                                    
                                    <input type="text" id="jml_beli" name="jml_beli" class="form-control input-sm" />                                        
                                </div>
                                <div class="col-md-2">                                    
                                    <label class="control-label">Harga Jual</label>
                                    <input type="text" name="harga" id="harga" class="form-control input-sm"  />                                            
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-success" id="btn_tmb_brg" style="margin-top: 23px!important;">
                                        <i class="fa fa-plus-circle"></i> Tambah Barang</button>
                                </div>
                            </div>
                            <label style="display: none; font-size: 13px;" class="label label-danger" id="warning_add"><i class="fa fa-warning"></i> </label>
                            <div class="row">
                                <div class="col-md-10"> 
                                    <hr style="margin-bottom: 0px!important;"/>
                                    <div class="static-table-list">
                                    <table class="table" id="tbl_barangkeluar">
                                        <thead>
                                            <tr>
                                                <th class="colw3">#</th>
                                                <th class="colw5">No</th>
                                                <th>Nama Barang</th>
                                                <th class="colw10">Jumlah</th>
                                                <th class="colw15">Harga Jual</th>
                                                <th class="colw15 text-center" >Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot class="ftebal5">
                                            <tr class="border-pdt-ct"><td colspan="5" style="padding: 0px!important;"></td></tr>
                                            <tr>
                                                <td colspan="3"><span style="font-size: 12px!important;"></span>
                                                </td>
                                                <td colspan="2" class="text-right">SubTotal</td>
                                                <td>
                                                    <input type="text" name="subtotalbk" id="subtotalbk" value="0" readonly="true" class="inputku text-right">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span style="font-size: 12px!important;"></span></td>
                                                <td colspan="2" class="text-right">Total Pembayaran</td>
                                                <td>
                                                    <input type="text" name="totalbayarbk" id="totalbayarbk" value="0" class="inputku text-right">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    </div>  
                                </div>           
                            </div>
                            <div class="row form-footer"> 
                                <div class="col-md-3"></div>
                                <div class="col-md-4 text-center">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                    <a href="<?php echo base_url('DataBarangKeluar'); ?>"  class="btn btn-sm btn-default"><i class="fa fa-times"></i> Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                
                <?php } else if(!empty ($action) && $action == "detail") { ?>
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">                        
                        <form action="<?php echo base_url("DataBarangKeluar/updateBayar"); ?>" method="POST">
                            <div class="row">
                                <label class="col-md-2 control-label"><b>No. Faktur</b></label>
                                <div class="col-md-3">: <?php echo $item->no_invoice; ?></div>
                                <label class="col-md-2 control-label"><b>Nama Pembeli</b></label>
                                <div class="col-md-4">: <?php echo $item->name_cust; ?></div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 control-label"><b>Tanggal Faktur</b></label>
                                <div class="col-md-4">: <?php echo DateView1($item->date_invoice); ?></div>
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
                                                    <td>'.$rw->jumlah.'</td>
                                                    <td>'.rupiah($rw->hrg_jual).'</td>
                                                    <td><span class="pull-right">'.rupiah($rw->total).'</span></td>
                                                </tr>';   
                                                $no++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="border-pdt-ct"><td colspan="5" style="padding: 0px!important;"></td></tr>
                                            <tr>
                                                <td colspan="2">Terbilang: <span id="terbilang_fakturbk" 
                                                 style="text-transform: capitalize; font-style: italic; font-size: 13px!important;"></span></td>
                                                <td colspan="2" class="text-right">SubTotal</td>
                                                <td class="text-right"><?php echo rupiah($item->subtotal); ?>
                                                    <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $item->subtotal; ?>" readonly="true" class="inputku text-right">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><span style="font-size: 17px!important;">
                                                        <b class="label label-danger"><?php echo $item->status_payment; ?></b></span></td>
                                                <td colspan="2" class="text-right">Total Pembayaran</td>
                                                <td class="text-right"><?php echo rupiah($item->total_payment); ?>
                                                    <input type="hidden" name="totalbayar" id="totalbayar" value="<?php echo rupiah($item->total_payment); ?>" readonly="true"  class="inputku text-right">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    </div>  
                                </div>           
                            </div>
                            <?php //echo base64_decode($this->uri->segment(3));
                            if(($item->total_payment) != ($item->subtotal)){                                
                                ?>
                            <hr />
                            <div class="row">
                                <label class="control-label col-md-3">Pelunasan Pembayaran</label>
                                <div class="col-md-2">
                                    <input type="hidden" name="id" class="form-control input-sm" value="<?php echo base64_decode($this->uri->segment(3)); ?>" />   
                                    <input type="text" name="jml_bayar_utang" class="form-control input-sm" placeholder="jumlah bayar" />
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan Pembayaran</button>
                                </div>
                            </div>
                            <hr class="garis"/>
                            <?php } ?>
                        </form>
                        <hr />
                            <div class="row">
                                <div class="col-md-8 text-left">                                    
                                    <a href="<?php echo base_url("DataBarangKeluar"); ?>" class="btn btn-sm btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                                    <a href="<?php echo base_url('DataBarangKeluar/cetakInvoiceBK/'.$this->uri->segment(3).''); ?>" class="btn btn-sm btn-success"><i class="fa fa-print"></i> Cetak Invoice</a>
                                </div>
                                <div class="col-md-2">
                                    <a href="<?php echo base_url("DataBarangKeluar/delete/".base64_decode($this->uri->segment(3)).""); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>