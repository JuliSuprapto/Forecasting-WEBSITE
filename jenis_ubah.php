<?php
    $id = stripslashes(strip_tags(htmlspecialchars($_GET['ID'],ENT_QUOTES)));
    $row = $db->get_row("SELECT * FROM tb_jenis WHERE kode_jenis='".$id."'"); 
?>
<div class="page-header">
    <h1>Ubah Jenis</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include 'aksi.php' ?>
        <form method="post" action="?m=jenis_ubah&ID=<?=$row->kode_jenis?>">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" readonly="readonly" value="<?=$row->kode_jenis?>"/>
            </div>
            <div class="form-group">
                <label>Nama Jenis <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?=$row->nama_jenis?>"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=jenis"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>