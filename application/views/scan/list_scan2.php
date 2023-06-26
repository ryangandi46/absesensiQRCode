        <!-- Main content -->
        <section class='content'>
            <div class='row'>
                <div class='col-xs-12'>
                    <div class='box box-danger'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>SCAN QR-CODE
                        </div><!-- /.box-header -->
                        <div class='box-body'>
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="20px" style='text-align:center;'>No</th>                                        
                                        <th style='text-align:center;'>Matkul</th>
                                        <th style='text-align:center;'>Dosen</th>
                                        <th style='text-align:center;'>Kelas</th>
                                        <th style='text-align:center;'>Hari</th>
                                        <th width="10%" style='text-align:center;'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <td style='text-align:center;'><?php echo ++$start ?></td>                                        
                                        <td style='text-align:center;'><?php echo $first_name ?></td>
                                        <td style='text-align:center;'><?php echo $alamat ?></td>
                                        <td style='text-align:center;'><?php echo $nama_matkul ?></td>
                                        <td style='text-align:center;'><?php echo $hari ?></td>
                                        <td style="text-align:center" width="140px">
                                            <?php echo anchor(site_url('scan/cek_scan/' . $gedung_id), '<i class="fa fa-eye fa-lg"></i>&nbsp;&nbsp;Scan', array('title' => 'detail', 'class' => 'btn btn-mdb-color ')); ?>
                                        </td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                            <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
                            <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
                            <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#mytable").dataTable();
                                });
                            </script>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->