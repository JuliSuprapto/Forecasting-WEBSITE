<div class="page-header">
    <h1>Tambah bantuan</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label>Kode bantuan <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_bantuan" value="<?=set_value('kode_bantuan', kode_oto('kode_bantuan', 'tb_bantuan', 'B', 3))?>"/>
            </div>
            <div class="form-group">
                <label>Nama bantuan <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_bantuan" value="<?=set_value('nama_bantuan')?>"/>
            </div>
            <div class="form-group">
                <label>Keterangan <span class="text-danger">*</span></label>
                <textarea class="form-control" name="keterangan"><?=set_value('keterangan')?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=bantuan"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>