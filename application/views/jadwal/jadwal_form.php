<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORM JADWAL</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        
                        <div class="form-group">
                            <label for="id_user" class="control-label">Nama Dosen<?php echo form_error('users') ?></label>
                            <div class="input-group">
                                <?php echo cmb_dinamis('id_user', 'id_user', 'users', 'first_name', 'id', $id_user) ?>
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_gedung" class="control-label">Kelass<?php echo form_error('gedung') ?></label>
                            <div class="input-group">
                                <?php echo cmb_dinamis('gedung_id', 'gedung_id', 'gedung', 'alamat', 'gedung_id', $id_gedung) ?>
                                <span class="input-group-addon">
                                    <span class="fas fa-location-arrow"></span>
                                </span>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="id_matkul" class="control-label">Matakuliah<?php echo form_error('matkul') ?></label>
                            <div class="input-group">
                                <?php echo cmb_dinamis('id_matkul', 'id_matkul', 'matkul', 'nama_matkul', 'id_matkul', $id_matkul) ?>
                                <span class="input-group-addon">
                                    <span class="fas fa-location-arrow"></span>
                                </span>
                            </div>
                        </div> 
                        <!-- <div class="form-group">
                            <label for="gedung_id" class="control-label">Kelas<?php echo form_error('gedung') ?></label>
                            <div class="input-group">
                                <?php echo cmb_dinamis('gedung_id', 'gedung_id', 'gedung', 'alamat', 'gedung_id', $gedung_id) ?>
                                <span class="input-group-addon">
                                    <span class="fas fa-retweet"></span>
                                </span>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="hari" class="control-label">Hari</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="hari" id="hari" data-error="Hari harus diisi" placeholder="Hari" value="<?php echo $hari; ?>" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('jadwal') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->