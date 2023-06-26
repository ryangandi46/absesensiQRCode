<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box box-<?=$box;?>'>
                <div class='box-header  with-border'>
                    <h3 class='box-title'>FORM DOSEN</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="myForm" data-toggle="validator" action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="nama_dosen" class="control-label">Nama Dosen</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nama_dosen" id="nama_dosen" data-error="Nama Dosen harus diisi" placeholder="Nama Dosen" value="<?php echo $nama_dosen; ?>" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" class="control-label">Jenis Kelamin</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" data-error="Jenis Kelamin harus diisi" placeholder="Nama Dosen" value="<?php echo $jenis_kelamin; ?>" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="control-label">Alamat</label>
                            <div class="input-group">
                                <input type="text"class="form-control" name="alamat" id="alamat" data-error="Alamat harus diisi" placeholder="Alamat" value="<?php echo $alamat; ?>" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="no_tlp" class="control-label">Nomor Telepon</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="no_tlp" id="no_tlp" data-error="Nomor Telepon harus diisi" placeholder="Nomor Telepon" value="<?php echo $no_tlp; ?>" required />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="matkul" class="control-label">Mata Kuliah<?php echo form_error('matkul') ?></label>
                            <div class="input-group">
                                <?php echo cmb_dinamis('matkul', 'matkul', 'matkul', 'nama_matkul', 'id_matkul', $id_matkul) ?>
                                <span class="input-group-addon">
                                    <span class="fas fa-briefcase"></span>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg btn3d"><?php echo $button ?></button>
                            <a href="<?php echo site_url('dosen') ?>" class="btn btn-default btn-lg btn3d">Cancel</a>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->