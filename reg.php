<?php
require_once('header.php');
/*
if (!empty($_SESSION['reg_error'])) {
    $reg_error = $_SESSION['reg_error'];
    echo "ВНИМАНИЕ! $reg_error";
}
*/
if ($_POST['login']) {
    $login = sanitizeString($_POST['login']);
    $password1 = sanitizeString($_POST['password1']);
    $password2 = sanitizeString($_POST['password2']);
    if ($login == '' || $password1 == '' || $password2 == '') {
        echo 'Данные введены не во все поля. Попробуйте еще раз.<br><br>';
    } elseif ($password1 !== $password2) {
        echo'Вы ввели разные пароли. Попробуйте еще раз.<br><br>';
    } else {
        $result = queryMysql("SELECT * FROM members WHERE login='$login'");
        if ($result->num_rows) {
            echo 'Данный пользователь уже существует.<br><br>';
        } else {
            $password = hash('ripemd128', "$password1");
            queryMysql("INSERT INTO members VALUES(0, '$login', '$password');");
            $_SESSION['login'] = $login;
            header('Location: profile.php');
            exit();
        }
    }
}

echo '
        <div class="container">

      <div class="form-container">
        <form class="form-horizontal" action="reg.php" method="post">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
              <input name="login" type="text" class="form-control" id="inputEmail3" placeholder="Логин">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
              <input name="password1" type="password" class="form-control" id="inputPassword3" placeholder="Пароль">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">Пароль (Повтор)</label>
            <div class="col-sm-10">
              <input name="password2" type="password" class="form-control" id="inputPassword4" placeholder="Пароль">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Зарегистрироваться</button>
              <br><br>
              Зарегистрированы? <a href="index.php">Авторизируйтесь</a>
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