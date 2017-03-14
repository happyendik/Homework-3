<?php
require_once 'header.php';

if ($_POST['login']) {
    $login = sanitizeString($_POST['login']);
    $password1 = sanitizeString($_POST['password1']);
    $password2 = sanitizeString($_POST['password2']);

    if ($login == '' || $password1 == '' || $password2 == '') {
        $_SESSION['error'] = 'Данные введены не во все поля. Попробуйте еще раз.<br><br>';
        header('Location: reg.php');  // перенаправление на нужную страницу
        exit();
    } elseif ($password1 !== $password2) {
        $_SESSION['error'] = 'Вы ввели разные пароли. Попробуйте еще раз.<br><br>';
    } else {
        $result = queryMysql("SELECT * FROM members WHERE login='$login'");
        if ($result->num_rows) {
            $_SESSION['error'] = 'Данный пользователь уже существует.<br><br>';
            header('Location: reg.php');  // перенаправление на нужную страницу
            exit();
        } else {
            $password = hash('ripemd128', "$password1");
            queryMysql("INSERT INTO members VALUES(0, '$login', '$password');");
            $_SESSION['login'] = $login;

            echo "<h4>Аккаунт успешно создан. Пожалуйста, заполните информацию о себе.</h4><br><br>";
            echo "
 <div class=\"container\">

      <div class=\"form-container\">
        <form class=\"form-horizontal\" action=\"regfinish.php\" method=\"post\" enctype='multipart/form-data'>

          <div class=\"form-group\">
            <label for=\"inputEmail3\" class=\"col-sm-2 control-label\">Имя</label>
            <div class=\"col-sm-10\">
              <input name=\"name\" type=\"text\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"Имя\">
            </div>
          </div>

          <div class=\"form-group\">
            <label for=\"inputEmail3\" class=\"col-sm-2 control-label\">Возраст</label>
            <div class=\"col-sm-10\">
              <input name=\"age\" type=\"text\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"Возраст\">
            </div>
          </div>

          <div class=\"form-group\">
            <label for=\"inputEmail3\" class=\"col-sm-2 control-label\">О себе</label>
            <div class=\"col-sm-10\">
              <input name=\"desc\" type=\"text\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"О себе\">
            </div>
          </div>
<!--
          <div class=\"form-group\">
            <label for=\"inputEmail3\" class=\"col-sm-2 control-label\">Фото</label>
            <div class=\"col-sm-10\">
              <input name=\"photo\" type=\"text\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"Фото\">
            </div>
          </div>
-->
          <div class=\"form-group\">
            <label for=\"inputEmail3\" class=\"col-sm-2 control-label\">Фото</label>
            <div class=\"col-sm-10\">
             <input name=\"photo\" type=\"file\" class=\"form-control\" id=\"inputEmail3\" placeholder=\"Фото\">
            </div>
          </div>

          <div class=\"form-group\">
            <div class=\"col-sm-offset-2 col-sm-10\">
              <button type=\"submit\" class=\"btn btn-default\">Сохранить</button>
              <br><br>

            </div>
          </div>
        </form>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
    <script src=\"js/main.js\"></script>
    <script src=\"js/bootstrap.min.js\"></script>

  </body>
</html>
            ";

        }
    }
}

if ($_POST['name']) {
    $name = sanitizeString($_POST['name']);
    $age = sanitizeString($_POST['age']);
    $desc = sanitizeString($_POST['desc']);
    $login = $_SESSION['login'];

    if ($_FILES) {
        switch($_FILES['photo']['type']){
            case 'image/jpeg': $ext = 'jpg'; break;
            case 'image/gif':  $ext = 'gif'; break;
            case 'image/png':  $ext = 'png'; break;
            default: $ext = ''; break;
        }
        if ($ext) {
            $photo = "$login.$ext";
            $saveto = "photos/$photo";
            move_uploaded_file($_FILES['photo']['tmp_name'], $saveto);
        } else {
            echo "Неприемлемый файл изображения";
        }
    } else {
        echo "Загрузки не произошло";
    }

    queryMysql("INSERT INTO member_info VALUES ('$login', '$name', '$age', '$desc', '$photo' )");
    header('Location: profile.php');
    exit();
}

