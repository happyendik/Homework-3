<?php
require 'header.php';

if ($loggedin) {
    echo '
 <div class="container">

      <div class="form-container">
        <form class="form-horizontal" action="regfinish.php" method="post" enctype=\'multipart/form-data\'>

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
}
