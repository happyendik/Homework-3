<?php
require_once 'header.php';

if ($_GET['delete']) {
    $delete = $_GET['delete'];
    queryMysql("DELETE FROM member_info WHERE member_login='$delete'");
    queryMysql("DELETE FROM members WHERE login='$delete'");
    header('Location: list.php');
}

echo "
     <div class=\"container\">
    <h1>Запретная зона, доступ только авторизированному пользователю</h1>
      <h2>Информация выводится из базы данных</h2>

            <table class=\"table table-bordered\">
        <tr>
          <th>Пользователь(логин)</th>
          <th>Имя</th>
          <th>возраст</th>
          <th>описание</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
";

if ($loggedin) {
    $member_login = $_SESSION['login'];
    $result = queryMysql("SELECT * FROM member_info");
    while ($row = $result->fetch_assoc()) {
        //print_r($row);
        $login = $row['member_login'];
        $name = $row['name'];
        $age = $row['age'];
        $desc = $row['description'];
        $photo = $row['photo'];

        echo "


        <tr>
          <td>$login</td>
          <td>$name</td>
          <td>$age</td>
          <td>$desc</td>
          <td><img src='photos/$photo' alt=\"\"></td>
          <td>
            <a href=\"list.php?delete=$login\">Удалить пользователя</a>
          </td>
        </tr>



";

   }
    echo "
      </table>
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

} else {
    echo 'Вам закрыт доступ к данной странице';
}
