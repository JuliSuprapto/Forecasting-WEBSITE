<div class="page-header">
    <h1>Tentang</h1>
</div>
<?php
$row = $db->get_row("SELECT * FROM tb_admin LIMIT 1");
?>
<img src="assets/<?=$row->foto?>" class="thumbnail" height="400" />
<h3><?=$row->nama_lengkap?></h3>
<div>
<?=$row->tentang?>
</div>