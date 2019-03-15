<?php
$data = get_data();  
$min_periode = min($PERIODE);
$max_periode = max($PERIODE);

function get_arr_next($next_periode, $min_periode, $max_periode){
    $arr = array();
    if($next_periode < $min_periode){
        for($a = $next_periode; $a < $min_periode; $a++){
            $arr[] = $a;
        }
    } else if($next_periode > $max_periode){
        for($a = $max_periode + 1; $a <= $next_periode; $a++){
            $arr[] = $a;
        }
    } else {
        $arr[] = $next_periode;
    }
    return $arr;
}
$arr_next = get_arr_next($next_periode, $min_periode, $max_periode);

$analisa = get_analisa($data);
$x = get_x();
$xy = get_xy($analisa, $x);
$x_kuarat = get_x_kuadrat($x);
$total_populasi = get_total_populasi($analisa);
$total_xy = get_total_xy($xy);
$total_x_kuadrat = array_sum($x_kuarat); 
$nilai_a = get_a($total_populasi);
$nilai_b = get_b($total_xy, $total_x_kuadrat);
$next_x = $next_periode - $max_periode + max($x);

function get_arr_next_hasil($arr_next, $nilai_a, $nilai_b, $max_periode, $max_x){
    $arr = array();    
    foreach($nilai_a as $key => $val){
        foreach($arr_next as $k){
            $a = $nilai_a[$key];
            $b = $nilai_b[$key];
            $x = $k - $max_periode + $max_x;            
            $arr[$key][$k] = array(
                'a' => $a,
                'b' => $b,
                'x' => $x,                
                'next' => $a + $b * $x,
            );
        }
    }
    //echo '<pre>' . print_r($arr, 1) . '</pre>';
    return $arr;
}
$arr_next_hasil = get_arr_next_hasil($arr_next, $nilai_a, $nilai_b, $max_periode, max($x));

function get_selisih($arr_next_hasil,$data){
    
    $arr = array();
    foreach($arr_next_hasil as $key => $val){
        foreach($val as $k => $v){
            if(isset($data[$k][$key])){
                $arr[$key][$k] = array(
                    'asli' => $data[$k][$key],
                    'selisih' => abs($data[$k][$key] - $v['next']),
                );
            }
        }
    }
    //echo '<pre>' . print_r($arr, 1) . '</pre>';
    return $arr;
}
$arr_selisih = get_selisih($arr_next_hasil, $data);
//echo '<pre>' . print_r($arr_next, 1) . '</pre>';
 
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" href="#c1" aria-expanded="true" aria-controls="c1">
                Data
            </a>
        </h4>
    </div>
    <div class="table-responsive collapse" id="c1"> 
        <table class="table table-bordered table-striped table-hover nw">
        <thead><tr>
            <th></th>
            <?php foreach($data[key($data)] as $key => $val):?>
            <th><?=$JENIS[$key]?></th>           
            <?php endforeach?>
        </tr></thead>
        <?php foreach($data as $key => $val):?>
        <tr>
            <th><?=$key?></th>
            <?php foreach($val as $k => $v):?>
                <td><?=number_format($v)?></td>
            <?php endforeach?>
        </tr>   
        <?php endforeach?> 
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" href="#c2" aria-expanded="false" aria-controls="c2">
                Dicari
            </a>
        </h4>
    </div>
    <div class="table-responsive collapse" id="c2"> 
        <table class="table table-bordered table-striped table-hover nw">
        <thead><tr>
            <th></th>
            <?php 
            reset($data);
            foreach($data[key($data)] as $key => $val):?>
            <th><?=$JENIS[$key]?></th>           
            <?php endforeach?>
        </tr></thead> 
        <?php foreach($arr_next as $key => $val):?>
        <tr>
            <th><?=$val?></th>
            <?php foreach($JENIS as $k => $v):?>
            <td>?</td>
            <?php endforeach?>
        </tr>    
        <?php endforeach?>
        </table>
    </div>
</div>
<?php 




//echo $next_x;

foreach($JENIS as $kode_jenis => $nama_jenis):?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" href="#c3_<?=$kode_jenis?>" aria-expanded="false" aria-controls="c3">
                <?=$nama_jenis?>
            </a>
        </h4>
    </div>
    <div class="panel-body collapse" id="c3_<?=$kode_jenis?>">
    
    
    <div class="table-responsive"> 
        <table class="table table-bordered table-striped table-hover">
        <thead><tr>
            <th>No</th>
            <th>Periode</th>
            <th>Populasi (Y)</th>
            <th>X</th>
            <th>XY</th>
            <th>X ^ Y</th>
        </tr></thead>
        <?php 
        $no = 1;
        foreach($analisa[$kode_jenis] as $key => $val):?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$key?></td>  
            <td><?=number_format($val)?></td>
            <th><?=$x[$key]?></th>           
            <th><?=number_format($xy[$kode_jenis][$key])?></th>   
            <th><?=$x_kuarat[$key]?></th>                   
        </tr>    
        <?php endforeach?>
        <tr>
            <td colspan="2">Total</td>
            <td><?=number_format($total_populasi[$kode_jenis])?></td>
            <td></td>
            <td><?=number_format($total_xy[$kode_jenis])?></td>
            <td><?=$total_x_kuadrat?></td>
        </tr>
        </table>
    </div>
    <p>
    Persamaan: y = <?=round($nilai_a[$kode_jenis])?> + <?=round($nilai_b[$kode_jenis])?>x <br />
    <!--Dengan x = <?=$next_periode?>, maka y = <?=round($nilai_a[$kode_jenis])?> + <?=round($nilai_b[$kode_jenis])?> * <?=$next_x?> = <strong><?=number_format($arr_next_hasil[$kode_jenis][$next_periode]['next'])?></strong>-->
    </p> 
    <table class="table table-bordered table-striped table-hover">
        <thead><tr>
            <th>No</th>
            <th>Periode</th>
            <th>X</th>
            <th>Hasil</th>
            <th>Asli</th>
            <th>Selisih</th>
        </tr></thead>
        <?php 
        $no = 1;
        foreach($arr_next_hasil[$kode_jenis] as $key => $val):?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$key?></td>
            <td><?=$val['x']?></td>
            <td><?=number_format($val['next'])?></td>
            <td><?=number_format($arr_selisih[$kode_jenis][$key]['asli'])?></td>
            <td><?=number_format($arr_selisih[$kode_jenis][$key]['selisih'])?></td>
        </tr>
        <?php endforeach?>
    </table> 
    </div>    
</div>
<?php endforeach?>
