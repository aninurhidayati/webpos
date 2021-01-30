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
                                        <th class="colw20">Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th class="colw15">Kontak/Telepon</th>
                                        <th class="colw15">CP</th>                                        
                                        <th class="colw7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no=1;
                                    foreach ($list_item as $rw) {
                                    echo '
                                    <tr>
                                        <td>'.$no.'</td>
                                        <td>'.$rw->name_cust.'</td>
                                        <td>'.$rw->addr_cust.'</td>
                                        <td>'.$rw->no_telp.'</td>
                                        <td>'.$rw->cp_cust.'</td>
                                        <td>
                                           <a href="'. base_url('DataPelanggan/edit/'.$rw->id_customer.'').'" class="btn btn-xs btn-custon-four btn-default" title="Ubah Data"><i class="fa fa-pencil"></i></a>
                                           <a href="'. base_url('DataPelanggan/delete/'.$rw->id_customer.'').'" class="btn btn-xs btn-custon-four btn-default" title="Hapus Data"><i class="fa fa-times"></i></a>
                                           <!--<a href="" class="btn btn-xs btn-custon-four btn-default" title="Detail Data"><i class="fa fa-list"></i> Detail</a>-->
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
                        <form action="<?php echo base_url('DataPelanggan/save'); ?>" method="POST">
                            <div class="row form-group">
                                <label class="col-md-2">Nama Pelanggan</label>
                                <div class="col-md-4">
                                    <input type="hidden" name="idcust" type="text" value="<?php  echo $idcust; ?>" />
                                    <input type="text" name="nama_p" class="form-control input-sm"
                                       oninvalid="this.setCustomValidity('Nama Pelanggan harus diisi!')"
                                       oninput="setCustomValidity('')" required="true"
                                        value="<?php echo $nama_p; ?>"   />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-2">Alamat Pelanggan</label>
                                <div class="col-md-6">
                                    <input type="text" name="alamat_p" class="form-control input-sm"
                                        oninvalid="this.setCustomValidity('Alamat pelanggan harus diisi!')"
                                        oninput="setCustomValidity('')" required="true"  value="<?php echo $alamat; ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-2">Kontak Pelanggan</label>
                                <div class="col-md-3">
                                    <input type="text" name="kontak_p" class="form-control input-sm" 
                                           value="<?php echo $cp_cust; ?>" placeholder="Nama Kontak"  />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="telp_p" class="form-control input-sm"
                                       oninvalid="this.setCustomValidity('No.Telepon harus diisi!')"
                                       oninput="setCustomValidity('')" required="false" placeholder="Nomor Telepon"
                                        value="<?php echo $telp; ?>"   />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-2">Email Pelanggan</label>
                                <div class="col-md-4">
                                    <input type="text" name="email_p" class="form-control input-sm" 
                                        value="<?php echo $email_p; ?>"   />
                                </div>
                            </div>
                            <div class="row form-footer"> 
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                                    <a href="<?php echo base_url("DataPelanggan"); ?>" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Batal</a>
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