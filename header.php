<?php
session_start();
error_reporting(0);
echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
';
require_once 'functions.php';

if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $loggedin = TRUE;
} else {
    $loggedin = FALSE;
}

function router ()
{
$route = $_SERVER['REQUEST_URI'];
//echo $route;
$reg = '/\\/reg[.]php/';
$index = '/\\/index[.]php/';
$list = '/\\/list[.]php/';
$filelist = '/\\/filelist[.]php/';
$pages = [$reg, $index, $list, $filelist];
    global $insert0;
    global $insert1;
    global $insert2;
    global $insert3;
    $insert0 = '';
    $insert1 = '';
    $insert2 = '';
    $insert3 = '';

    if (preg_match("$pages[0]", $route)) {
        $insert0 = 'class="active"';
        return $insert0;
    } elseif (preg_match("$pages[1]", $route)) {
        $insert1 = 'class="active"';
        return $insert1;
    } elseif (preg_match("$pages[2]", $route)) {
        $insert2= 'class="active"';
        return $insert2;
    } elseif (preg_match("$pages[3]", $route)) {
        $insert3 = 'class="active"';
        return $insert3;
    }
}
router();

if ($loggedin) {
    echo <<<_END
        <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li $insert1><a href="index.php">Авторизация</a></li>
            <li $insert0><a href="reg.php">Регистрация</a></li>
            <li $insert2><a href="list.php">Список пользователей</a></li>
            <li $insert3><a href="filelist.php">Список файлов</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
_END;

} else {
    echo <<<_END
            <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li $inesrt1><a href="index.php">Авторизация</a></li>
            <li $insert0><a href="reg.php">Регистрация</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
_END;
}


