<div class="page-header">
    <h1>Ubah profil</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php 
            if($_POST) include'aksi.php';        
            $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]'");             
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>User <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="user" value="<?=set_value('user', $row->user)?>" readonly=""/>
            </div>
            <div class="form-group">
                <label>Nama lengkap <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_lengkap" value="<?=set_value('nama_lengkap', $row->nama_lengkap)?>"/>
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input class="form-control" type="file" name="foto"/>
                <p class="help-block">Kosongkan jika tidak ingin mengubah foto</p>
                <img src="assets/<?=$row->foto?>" class="thumbnail" height="75" />
            </div>
            <div class="form-group">
                <label>Tentang <span class="text-danger">*</span></label>
                <textarea class="form-control" name="tentang" rows="5"><?=set_value('keterangan', $row->tentang)?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=bantuan"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>