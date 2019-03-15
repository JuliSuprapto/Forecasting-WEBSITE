<div class="page-header">
    <h1>Bantuan</h1>
</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
    $rows = $db->get_results("SELECT * FROM tb_bantuan ORDER BY kode_bantuan");
    $a = 0;
    foreach($rows as $row):?>
    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading<?=($row->kode_bantuan)?>">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=($row->kode_bantuan)?>" aria-expanded="<?=($a==0) ? 'true' : 'false'?>" aria-controls="collapse<?=($row->kode_bantuan)?>">
          <?=$row->nama_bantuan?>
        </a>
      </h4>
    </div>
    <div id="collapse<?=($row->kode_bantuan)?>" class="panel-collapse collapse <?=($a==0) ? 'in' : ''?>" role="tabpanel" aria-labelledby="heading<?=$row->kode_bantuan?>">
      <div class="panel-body">
        <?=br_to_enter($row->keterangan)?>
      </div>
    </div>
  </div>
    <?php $a++;endforeach?>
</div>