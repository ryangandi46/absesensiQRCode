<!-- Main content -->
<section class='content'>
    <div class='row'>
        <div class='col-xs-12'>
            <div class="box box-success">
                <div class='box-header with-border'>
                    <h3 class='box-title'>Dosen Read</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>NIDN</td>
                            <td><?php echo $id_dosen; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Dosen</td>
                            <td><?php echo $nama_dosen; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td><?php echo $jenis_kelamin; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><?php echo $alamat; ?></td>
                        </tr>
                        <tr>
                            <td>Nomor Telepon</td>
                            <td><?php echo $no_tlp; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Matkul</td>
                            <td><?php echo $nama_matkul; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;"><a href="<?php echo site_url('dosen') ?>" class="btn-xs btn btn-primary">Kembali</a></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->
</section><!-- /.content -->