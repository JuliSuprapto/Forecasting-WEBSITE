<?php
require_once 'functions.php';

    /** LOGIN */ 
    if ($mod=='login'){
        $user = esc_field($_POST['user']);
        $pass = esc_field($_POST['pass']);
        
        $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");    
        if($row){
            $_SESSION['login'] = $row->user;
            redirect_js("index.php");
        } else{
            print_msg("Salah kombinasi username dan password.");
        }          
    } elseif($act=='logout'){
        unset($_SESSION['login']);
        header("location:index.php?m=login");
    } else if ($mod=='password'){
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        $pass3 = $_POST['pass3'];
        
        $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");        
        
        if($pass1=='' || $pass2=='' || $pass3=='')
            print_msg('Field bertanda * harus diisi.');
        elseif(!$row)
            print_msg('Password lama salah.');
        elseif( $pass2 != $pass3 )
            print_msg('Password baru dan konfirmasi password baru tidak sama.');
        else{        
            $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");                    
            print_msg('Password berhasil diubah.', 'success');
        }
    } 
    
    /** bantuan */    
    if($mod=='bantuan_tambah'){
        $kode_bantuan = $_POST['kode_bantuan'];
        $nama_bantuan = $_POST['nama_bantuan'];
        $keterangan = $_POST['keterangan'];
        
        if($kode_bantuan=='' || $nama_bantuan=='' || $keterangan=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif($db->get_row("SELECT * FROM tb_bantuan WHERE kode_bantuan ='$kode_bantuan'"))
            print_msg("Kode sudah ada!");
        else{
            $db->query("INSERT INTO tb_bantuan (kode_bantuan, nama_bantuan, keterangan) 
                VALUES ('$kode_bantuan', '$nama_bantuan', '$keterangan')");                                    
            redirect_js("index.php?m=bantuan");
        }                    
    } else if($mod=='bantuan_ubah'){
        $kode_bantuan = $_POST['kode_bantuan'];
        $nama_bantuan = $_POST['nama_bantuan'];
        $keterangan = $_POST['keterangan'];
        
        if($kode_bantuan=='' || $nama_bantuan=='' || $keterangan=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif($db->get_row("SELECT * FROM tb_bantuan WHERE kode_bantuan ='$kode_bantuan' AND kode_bantuan<>'$_GET[ID]'"))
            print_msg("Kode sudah ada!");
        else{
            $db->query("UPDATE tb_bantuan SET kode_bantuan='$kode_bantuan', nama_bantuan='$nama_bantuan', keterangan='$keterangan' WHERE kode_bantuan='$_GET[ID]'");
            redirect_js("index.php?m=bantuan");
        }    
    } else if ($act=='bantuan_hapus'){
        $db->query("DELETE FROM tb_bantuan WHERE kode_bantuan='$_GET[ID]'");    
        header("location:index.php?m=bantuan");           
    } else if($mod=='profil'){
        $nama_lengkap = $_POST['nama_lengkap'];
        $foto = $_FILES['foto'];
        $tentang = $_POST['tentang'];
        
        if($nama_lengkap=='' || $tentang=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else {
            if($foto['tmp_name']!=''){
                $sql_foto = ", foto='$foto[name]'";
                move_uploaded_file($foto['tmp_name'], 'assets/' . $foto['name']);
            }
            $db->query("UPDATE tb_admin SET nama_lengkap='$nama_lengkap' $sql_foto, tentang='$tentang' WHERE user='$_SESSION[login]'");
            print_msg('Profil tersimpan!', 'success');
        }    
    }
    
    /** ALTERNATIF */
    elseif($mod=='periode_tambah'){
        $nama = $_POST['nama'];
        $kode_periode = $_GET['ID'] * 1;
        if( $nama=='')
            print_msg("Field yang bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_periode WHERE nama_periode='$nama' AND kode_periode<>$kode_periode"))
            print_msg("Periode sudah ada!");
        else{
            $db->query("INSERT INTO tb_periode (nama_periode) VALUES ('$nama')");
            $kode_periode = $db->insert_id * 1;
            foreach($_POST[nilai] as $key => $val){
                $db->query("INSERT INTO tb_relasi(kode_periode, kode_jenis, nilai) VALUES ($kode_periode, '$key', '$val')");            
            }                           
            redirect_js("index.php?m=periode");
        }
    } else if($mod=='periode_ubah'){
        $kode_periode = $_GET['ID'] * 1;
        $nama = $_POST['nama'];
        //echo "SELECT * FROM tb_periode WHERE nama_periode='$nama' AND kode_periode<>$kode_periode";
        if( $nama=='')
            print_msg("Field yang bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_periode WHERE nama_periode='$nama' AND kode_periode<>$kode_periode"))
            print_msg("Periode sudah ada!");
        else{
            $db->query("UPDATE tb_periode SET nama_periode='$nama' WHERE kode_periode=$kode_periode");
            foreach($_POST['nilai'] as $key => $val){
                $db->query("UPDATE tb_relasi SET nilai=$val WHERE id=$key");    
                //echo "UPDATE tb_relasi SET nilai=$val WHERE id=$key";        
            } 
            redirect_js("index.php?m=periode");
        }
    } else if ($act=='periode_hapus'){
        $kode_periode = $_GET['ID'] * 1;
        $db->query("DELETE FROM tb_periode WHERE kode_periode=$kode_periode");
        $db->query("DELETE FROM tb_relasi WHERE kode_periode=$kode_periode");
        header("location:index.php?m=periode");
    } 
    
    /** KRITERIA */    
    if($mod=='jenis_tambah'){
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
                
        if($kode=='' || $nama=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_jenis WHERE kode_jenis='$kode'"))
            print_msg("Kode sudah ada!");
        else{
            $db->query("INSERT INTO tb_jenis (kode_jenis, nama_jenis) VALUES ('$kode', '$nama')");               
            $db->query("INSERT INTO tb_relasi(kode_periode, kode_jenis, nilai) SELECT kode_periode, '$kode', -1  FROM tb_periode");           
            redirect_js("index.php?m=jenis");
        }                    
    } else if($mod=='jenis_ubah'){
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        
        
        if($kode=='' || $nama=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{
            $db->query("UPDATE tb_jenis SET nama_jenis='$nama' WHERE kode_jenis='$_GET[ID]'");
            redirect_js("index.php?m=jenis");
        }    
    } else if ($act=='jenis_hapus'){
        $db->query("DELETE FROM tb_jenis WHERE kode_jenis='$_GET[ID]'");
        $db->query("DELETE FROM tb_relasi WHERE kode_jenis='$_GET[ID]'");
        header("location:index.php?m=jenis");
    } 