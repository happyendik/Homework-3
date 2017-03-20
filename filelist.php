<?php
require_once 'header.php';


if ($_GET['delete']) {
    $delete = $_GET['delete'];
    queryMysql("UPDATE member_info SET photo = NULL WHERE photo='$delete'");
    header('Location: filelist.php');
}

echo "
    <div class=\"container\">
    <h1>Запретная зона, доступ только авторизированному пользователю</h1>
      <h2>Информация выводится из списка файлов</h2>

            <table class=\"table table-bordered\">
        <tr>
          <th>Название файла</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
";

if ($loggedin) {
    $member_login = $_SESSION['login'];
    $result = queryMysql("SELECT * FROM member_info");
    while ($row = $result->fetch_assoc()) {
        $photo = $row['photo'];
        $login = $row['member_login'];

        echo "


        <tr>
          <td>$photo</td>
          <td><img src=\"photos/$photo\" alt=\"\"></td>
          <td>
            <a href=\"filelist.php?delete=$photo\">Удалить аватарку пользователя</a>
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
