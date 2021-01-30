<?php if(empty($action)){ ?>
<div class="data-table-area mg-b-15" style="margin-top: 0px!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd"><h1>Data User Pegawai </h1></div>
                        <?php
                            if (!empty($this->session->flashdata('msg_saveuser'))){
                                echo '<div class="alert-icon shadow-inner wrap-alert-b"> ';
                                echo $this->session->flashdata('msg_saveuser').'</div>';
                            }
                        ?>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <a href="<?php echo base_url("DataUser/input"); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                            </div>

                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" 
                                   data-show-columns="false" data-show-pagination-switch="false"
                                   data-show-refresh="true" data-key-events="true" data-show-toggle="false" 
                                   data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" 
                                   data-show-export="false" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th class="colw3">#</th>
                                        <th class="colw25">Nama Lengkap</th> 
                                        <th class="colw15">Username</th>
                                        <th class="colw10">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($listdatauser as $rw){
                                        echo '<tr>'
                                        . '<td>'.$no.'</td>'
                                        . '<td>'.$rw->fullname.'</td>'
                                        . '<td>'.$rw->username.'</td>'
                                        . '<td class="center-block"><a title="Lihat Detail " href="'.base_url("DataUser/detail/".base64_encode($rw->iduser."")).'" class="btn btn-xs btn-default" title="Detail Hak Akses">'
                                        . '<i class="fa fa-list"></i></a> &nbsp'
                                        . '<a title="Hapus Hak Akses" href="'. base_url("DataUser/delete/".base64_encode($rw->iduser."")).'" class="btn btn-xs btn-default" title="Detail Hak Akses">'
                                        . '<i class="fa fa-trash"></i></a></td></tr>';
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 
//form input/edit
if(!empty($action) && ($action === "input" || $action === "detail" )){  
    if($action === "detail"){ $dis = ' readonly="true" '; } else{ $dis = ''; }
?>
<div class="container-fluid padbot40">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-sm-12 col-xs-12 padbot40">
            <div class="sparkline12-list responsive-mg-b-30">
                
                <div class="sparkline12-graph">
                    <div class="basic-login-form-ad">
                        <div class="all-form-element-inner">
                         <?php
                            if (!empty($this->session->flashdata('msg_saveuser'))){
                                echo '<div class="alert-icon shadow-inner wrap-alert-b"> ';
                                echo $this->session->flashdata('msg_saveuser').'</div>';
                            }
                        ?>
                            <form name="akses" action="<?php echo base_url("".$modul."/save"); ?>"  method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
                                        <div class="form-group">
                                            <input type="hidden" name="idkey" value="<?php echo $iduser; ?>" />
                                            <div class="row">
                                                <label class="control-label col-md-2 col-sm-2 col-sm-2 col-xs-12" for="nmlengkap">Nama Lengkap </label>                                                    
                                                <div class="col-md-4 col-sm-4 col-sm-4 col-xs-12">
                                                    <input id="nmlengkap" name="nmlengkap" required="true" type="text" class="form-control" 
                                                           oninvalid="this.setCustomValidity('Nama Lengkap harus di isi')"
                                                           oninput="setCustomValidity('')" value="<?php echo $nama; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="login2 col-md-2 col-sm-2 col-sm-2 col-xs-12 control-label" for="username">Username </label>                                                    
                                                <div class="col-md-4 col-sm-4 col-sm-4 col-xs-12">
                                                    <input id="username" name="username" required="true" type="text" class="form-control" 
                                                           oninvalid="this.setCustomValidity('Nama Lengkap harus di isi')"
                                                           oninput="setCustomValidity('')" value="<?php echo $username; ?>" <?php echo $dis; ?> />
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="control-label col-md-2 col-sm-2 col-sm-2 col-xs-12" for="password">Password </label>                                                    
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <input id="pass_newus" name="pass_newus" required="true" type="password" class="form-control" 
                                                           oninvalid="this.setCustomValidity('Password harus di isi')"
                                                           oninput="setCustomValidity('')" value="<?php echo $username; ?>"/>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                    <input id="repass_newus" name="repass_newus" required="true" type="password" class="form-control" 
                                                           oninvalid="this.setCustomValidity('Ulangi password')" placeholder="Ulangi Password"
                                                           oninput="setCustomValidity('')" value="<?php echo $username; ?>"/>
                                                </div>              
                                                <br/><div class="helper fonthelps text-danger" style="display: none;" id="alert_passu">Password tidak sesuai</div>
                                            </div>
                                            
                                        </div>
                                        <hr />
                                        <div class="form-group-inner">
                                            <div class="login-btn-inner">
                                                <div class="row">
                                                    <div class="col-lg-3"></div>
                                                    <div class="col-lg-9">
                                                        <div class="login-horizontal"> 
                                                            <a href="<?php echo base_url($modul)?>" class="btn btn-md btn-default"><i class="fa fa-times"></i> Batal</a>
                                                            <button class="btn btn-md btn-success" type="submit"><i class="fa fa-save"></i> Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 
