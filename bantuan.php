<div class="page-header">
    <h1>Bantuan</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="bantuan" />
            <div class="form-group">
                    <input class="form-control" type="text" name="q" value="<?=$_GET[q]?>" placeholder="Pencarian..." />
                </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=bantuan_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="nw">
                <th>Kode</th>
                <th>Nama bantuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT *
            FROM tb_bantuan WHERE nama_bantuan LIKE '%$q%'
            ORDER BY kode_bantuan");        
        foreach($rows as $row):?>
        <tr>
            <td><?=$row->kode_bantuan?></td>
            <td><?=$row->nama_bantuan?></td>
            <td class="nw">
                <a class="btn btn-xs btn-warning" href="?m=bantuan_ubah&ID=<?=$row->kode_bantuan?>"><span class="glyphicon glyphicon-edit"></span></a>
                <a class="btn btn-xs btn-danger" href="aksi.php?act=bantuan_hapus&ID=<?=$row->kode_bantuan?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
        <?php endforeach;
        ?>
        </table>
    </div>    
</div>