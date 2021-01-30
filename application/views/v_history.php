<?php if(empty($action)){ ?>
<div class="data-table-area mg-b-15" style="margin-top: 0px!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <div class="main-sparkline13-hd"><h1><?php echo $page_title; ?></h1></div>
                            </div>

                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" 
                                   data-show-columns="false" data-show-pagination-switch="false"
                                   data-show-refresh="true" data-key-events="true" data-show-toggle="false" 
                                   data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" 
                                   data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th class="colw5">#</th>
                                        <th class="colw15">Tanggal Akses</th> 
                                        <th class="colw10">User</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($list_akses as $rw){
                                        echo '
                                        <tr>
                                            <td>'.$no.'</td>
                                            <td>'. DateView3($rw->tgl).'</td> 
                                            <td>'.$rw->user.'</td>
                                            <td>'.$rw->deskripsi.'</td>
                                        </tr>';
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