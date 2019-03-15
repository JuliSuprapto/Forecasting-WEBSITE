<?php

error_reporting(~E_NOTICE & ~E_DEPRECATED);
session_start();
include 'config.php';
include'includes/ez_sql_core.php';
include'includes/ez_sql_mysqli.php';
$db = new ezSQL_mysqli($config[username], $config[password], $config[database_name], $config[server]);
include'includes/general.php';    
    
$mod = $_GET[m];
$act = $_GET[act]; 

function br_to_enter($text){
    return str_replace("\r\n", '<br />', $text);
}

function kode_oto($field, $table, $prefix, $length){
    global $db;
    $var = $db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");    
    if($var){
        return $prefix . substr( str_repeat('0', $length) . (substr($var, - $length) + 1), - $length );
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}


function set_value($key = null, $default = null){
    global $_POST;
    if(isset($_POST[$key]))
        return $_POST[$key];
        
    if(isset($_GET[$key]))
        return $_GET[$key];
    
    return $default;
}

$rows = $db->get_results("SELECT kode_periode, nama_periode FROM tb_periode ORDER BY kode_periode");
foreach($rows as $row){
    $PERIODE[$row->kode_periode] = $row->nama_periode;
}

$rows = $db->get_results("SELECT * FROM tb_jenis ORDER BY kode_jenis");
foreach($rows as $row){
    $JENIS[$row->kode_jenis] = $row->nama_jenis;
}

function get_jenis_option($SELECTed = 0){
    global $JENIS;  
    //print_r($JENIS);
    foreach($JENIS as $key => $value){
        if($key==$SELECTed)
            $a.="<option value='$key' SELECTed>$value->nama_jenis</option>";
        else
            $a.="<option value='$key'>$value->nama_jenis</option>";
    }
    return $a;
}

function get_bobot_normal($bobot){
    $arr = array();
    foreach($bobot as $key => $val){
        $arr[$key] = $val / array_sum($bobot);
    }
    return $arr;
}

function get_rank($array){
    $data = $array;
    arsort($data);
    $no=1;
    $new = array();
    foreach($data as $key => $value){
        $new[$key] = $no++;
    }
    return $new;
}

function get_analisa($data){
    $arr = array();
    foreach($data as $key => $val){
        foreach($val as $k => $v){
            $arr[$k][$key] = $v;
        }
    }
    return $arr;
}

function get_data(){
    global $db, $PERIODE;
    
    $rows = $db->get_results("SELECT * 
    FROM tb_relasi r 
    ORDER BY kode_periode, kode_jenis");
    
    $data = array();
    foreach($rows as $row){
        $data[$PERIODE[$row->kode_periode]][$row->kode_jenis] = $row->nilai;
    }    
    return $data;
}

function get_xy($analisa, $x){
    $arr = array();
    foreach($analisa as $key => $val){
        foreach($val as $k => $v){
            $arr[$key][$k] = $v * $x[$k];
        }
    }
    return $arr;
}

function get_x(){
    global $PERIODE;
    $total = count($PERIODE);
    $min = floor($total / 2) * -1;
    
    $a = $min;
    $arr = array();
    
    $genap = ($total % 2 ==0);
    foreach($PERIODE as $key){
        if($genap && $a==0)
            $a++;
        $arr[$key] = $a++;
    }
    return $arr;
}

function get_total_populasi($analisa){
    $arr = array();
    foreach($analisa as $key => $val){
        $arr[$key] = array_sum($val);
    }
    return $arr;
}


function get_total_xy($xy){
    $arr = array();
    foreach($xy as $key => $val){
        $arr[$key] = array_sum($val);
    }
    return $arr;
}

function get_x_kuadrat($x){
    $arr = array();
    foreach($x as $key => $val){
        $arr[$key] = $val * $val;
    }
    return $arr;
}

function get_a($total_populasi){
    global $PERIODE;
    
    $arr = array();
    foreach($total_populasi as $key => $val){
        $arr[$key] = $val / count($PERIODE);
    }
    return $arr;
}

function get_b($total_xy, $total_x_kuadrat){
    global $PERIODE;
    
    $arr = array();
    foreach($total_xy as $key => $val){
        $arr[$key] = $val / $total_x_kuadrat;
    }
    return $arr;
}
