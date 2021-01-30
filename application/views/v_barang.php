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
                                        <th class="colw5" style="padding: 5px!important; line-height: normal!important;">#</th>
                                        <th class="colw15">Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th class="colw10">Total Stok</th>
                                        <th class="colw15">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($list_item as $rw) {
                                    echo '
                                    <tr>
                                        <td>'.$no.'</td>
                                        <td>'.$rw->code_item.'</td>
                                        <td>'.$rw->name_item.'</td>
                                        <td>'.$rw->totalstock.'</td>
                                        <td>
                                           <a href="'. base_url('DataBarang/edit/'.$rw->code_item.'').'" class="btn btn-xs btn-custon-four btn-default" title="Ubah Data"><i class="fa fa-pencil"></i></a>
                                           <a href="'. base_url('DataBarang/delete/'.$rw->code_item.'').'" class="btn btn-xs btn-custon-four btn-default" title="Hapus Data"><i class="fa fa-times"></i></a>
                                           <a href="'. base_url('DataBarangMasuk/detail/'.$rw->code_item.'').'" class="btn btn-xs btn-custon-four btn-default" title="Detail Data"><i class="fa fa-list"></i> Detail</a>
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
                        <form action="<?php echo base_url('DataBarang/save'); ?>" method="POST">
                            <?php if($action === "input"){ ?>
                            <div class="row form-group">
                                <label class="col-md-2">Jenis Barang</label>
                                <div class="col-md-2">
                                    <select class="form-control input-sm" id="jenisbarang">
                                        <option value="">--Pilih Jenis--</option>
                                        <?php 
                                        foreach ($listjenis->result() as $rw) {
                                            echo '<option value="'.$rw->value.'">'.$rw->value.' - '.$rw->details.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row form-group">
                                <label class="col-md-2">Kode Barang</label>
                                <div class="col-md-2">
                                    <input type="hidden" name="is_new" value="<?php  echo $is_new; ?>" />
                                    <input id="kodebarang" type="text" name="kodeb" class="form-control input-sm" style="text-transform: uppercase"
                                       oninvalid="this.setCustomValidity('Kode Barang harus diisi!')"
                                       oninput="setCustomValidity('')" required="true" readonly="true"
                                        value="<?php echo $kode_b; ?>"   />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-2">Nama Barang</label>
                                <div class="col-md-6">
                                    <input type="text" name="namab" class="form-control input-sm"
                                        oninvalid="this.setCustomValidity('Nama Barang harus diisi!')"
                                        oninput="setCustomValidity('')" required="true"  value="<?php echo $nama_b; ?>" />
                                </div>
                            </div>
                            <div class="row form-footer"> 
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                                    <a href="<?php echo base_url('DataBarang');?>" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>