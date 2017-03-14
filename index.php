<?php
require_once 'header.php';

if ($_POST['login']) {
    $login = sanitizeString($_POST['login']);
    $password = sanitizeString($_POST['password']);
    $result = queryMysql("SELECT * FROM members WHERE login='$login'");
    if ($result->num_rows) {
        $password = hash('ripemd128', "$password");

        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['password'] === $password) {
            $_SESSION['login'] = $_POST['login'];
            header('Location: profile.php');
        }
    } else {
        echo "Нет такого пользователя";
    }
}

echo '
<div class="container">

      <div class="form-container">
        <form class="form-horizontal" action="index.php" method="post">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
              <input name="login" type="text" class="form-control" id="inputEmail3" placeholder="Логин">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
              <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Пароль">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Войти</button>
              <br><br>
              Нет аккаунта? <a href="reg.php">Зарегистрируйтесь</a>
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