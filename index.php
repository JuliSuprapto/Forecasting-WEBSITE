<?php

include 'functions.php';
//if(empty($_SESSION['login']))
  //  header("location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "./views/style.php" ?>       
  </head>
  <body>
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?">Forecasting</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php if($_SESSION['login']):?>
            <li><a href="?m=jenis"><span class="glyphicon glyphicon-th-large"></span> Jenis</a></li>          
            <li><a href="?m=periode"><span class="glyphicon glyphicon-user"></span> Periode</a></li>
            <li><a href="?m=hitung"><span class="glyphicon glyphicon-book"></span> Perhitungan</a></li>  
            <li><a href="?m=bantuan"><span class="glyphicon glyphicon-question-sign"></span> Bantuan</a></li>   
            <li><a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a></li>
            <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            <?php else:?>
            <li><a href="?m=hitung"><span class="glyphicon glyphicon-book"></span> Perhitungan</a></li>   
            <li><a href="?m=bantuan_list"><span class="glyphicon glyphicon-question-sign"></span> Bantuan</a></li>  
            <li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php endif?>                     
          </ul>          
        </div>
    </nav>

    <div class="container">
    <?php
        if(!$_SESSION['login'] && !in_array($mod, array('', 'home', 'hitung', 'login', 'bantuan_list', 'tentang')))
            $mod = 'login';
            
        if(file_exists($mod.'.php'))
            include $mod.'.php';
        else
            include 'home.php';
    ?>
    </div>

    <?php include "./views/footer.php" ?>

</html>