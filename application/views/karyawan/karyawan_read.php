<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Mahasiswa Read</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>NPM</td>
                            <td><?php echo $id_karyawan; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Mahasiswa</td>
                            <td><?php echo $nama_karyawan; ?></td>
                        </tr>
                        <tr>
                            <td>Program Kuliah</td>
                            <td><?php echo $nama_jabatan; ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td><?php echo $alamat; ?></td>
                        </tr>
                        <!-- <tr>
                            <td>Ruangan</td>
                            <td><?php echo $nama_gedung; ?></td>
                        </tr> -->
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('karyawan') ?>" class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->