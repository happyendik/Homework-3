<?php
require 'header.php';

if (!file_exists('photos')) {
    mkdir('photos', 0700);
    echo 'Создана папка photos.<br>';
}

function addProfileImage()
{
    global $login;
    if ($_FILES) {

        switch ($_FILES['photo']['type']) {
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/gif':
                $ext = 'gif';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            default:
                $ext = '';
                break;
        }

        if ($ext) {
            $photo = "$login.$ext";
            $saveTo = "photos/$photo";
            move_uploaded_file($_FILES['photo']['tmp_name'], $saveTo);
            switch ($ext) {
                case 'jpg': $src = imagecreatefromjpeg($saveTo); break;
                case 'gif': $src = imagecreatefromgif($saveTo); break;
                case 'png': $src = imagecreatefrompng($saveTo); break;
            }

            list($w, $h) = getimagesize($saveTo);
            $max = 200;
            $tw = $w;
            $th = $h;

            if ($w > $h && $max < $h) {
                $th = $max / $w * $h;
                $tw = $max;
            } elseif ($h > $w && $max < $h) {
                $tw = $max / $h * $w;
                $th = $max;
            } elseif ($max < $w) {
                $tw = $th = $max;
            }

            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imagejpeg($tmp, $saveTo);
            imagedestroy($tmp);
            imagedestroy($src);
 //stop
            return $photo;
        } else {
            echo "Неприемлемый файл изображения";
        }
    } else {
        echo "Загрузки фотграфии профиля не произошло";
    }
}


if ($_POST['name']) {
    if ($_POST['name'] == '' ||
        $_POST['age'] == '' ||
        $_POST['desc'] == '') {
        echo 'Введите все данные';

    } elseif (!preg_match('/[0-9]+/', $_POST['age'])) {
        echo 'Возраст должен принимать числовое значениею У вас - '.$_POST['age'];
    }else {
        $name = sanitizeString($_POST['name']);
        $age = sanitizeString($_POST['age']);
        $desc = sanitizeString($_POST['desc']);
        $login = $_SESSION['login'];

        $result = queryMysql("SELECT * FROM member_info WHERE member_login = '$login'");
        if ($result->num_rows) {
            $photo = addProfileImage();
            queryMysql("UPDATE member_info SET name = '$name', age = '$age', description = '$desc', photo = '$photo' WHERE member_login = '$login'");
        } else {
            $photo = addProfileImage();
            queryMysql("INSERT INTO member_info VALUES ('$login', '$name', '$age', '$desc', '$photo')");
        }
        header('Location: profile.php');
        exit();
    }
}


if ($loggedin) {
    echo '<br>Данные пользователя:';
    $result = queryMysql("SELECT * FROM member_info WHERE member_login='$login'");
    $row = $result->fetch_assoc();

    echo "
 <table class=\"table table-bordered\">
    <tr>
          <td>{$row['name']}</td>
          <td>{$row['age']}</td>
          <td>{$row['description']}</td>
          <td><img src=\"photos/{$row['photo']}\" alt=\"\"></td>
    </tr>
    </table>
 ";

    echo '
 <div class="container">

      <div class="form-container">
        <form class="form-horizontal" action="profile.php" method="post" enctype=\'multipart/form-data\'>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Имя</label>
            <div class="col-sm-10">
              <input name="name" type="text" class="form-control" id="inputEmail3" placeholder="Имя">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Возраст</label>
            <div class="col-sm-10">
              <input name="age" type="text" class="form-control" id="inputEmail3" placeholder="Возраст">
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">О себе</label>
            <div class="col-sm-10">
              <input name="desc" type="text" class="form-control" id="inputEmail3" placeholder="О себе">
            </div>
          </div>

<!--
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Фото</label>
            <div class="col-sm-10">
              <input name="photo" type="text" class="form-control" id="inputEmail3" placeholder="Фото">
            </div>
          </div>
-->
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Фото</label>
            <div class="col-sm-10">
              <input name="photo" type="file" class="form-control" id="inputEmail3" placeholder="Фото">
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Сохранить</button>
              <br><br>

            </div>
          </div>
        </form>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
    ';
} else {
    echo 'Вам закрыт доступ к этой странице';
    exit();
}



