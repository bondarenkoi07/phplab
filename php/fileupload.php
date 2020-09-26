<?php
    include 'IShopPage.php';
    class FileUploadPage extends ShopPage{
        private $user;
        function __construct(string $title = '')
        {
            $this->user = new AuthPage();
            $this->create_title($title);
            $this->start_db_connection();
            session_start();

        }
        public function payload()
        {
            if(isset($_COOKIE['warnings']))
                echo $_COOKIE['warnings'];
            if ($this->user->authed()) {
                echo '  
                  <form enctype="multipart/form-data" id="FileForm" action="FileDistribution.php" method="post" >
                  <input type="hidden" name="MAX_FILE_SIZE"  value="1048576">
                  <p><input type="file" name="files[]"  /></p>  
                  </form> 
                  <p><input type="submit" value="Отправить" form="FileForm" /></p>
                  <button onclick="AddFiles()">+</button>';
            }
            else{
                header( "refresh:0;url='http://localhost/php/auth_db.php' ");
            }
        }
    }

    ?>
<html lang="ru">
    <?php
    $PageController = new FileUploadPage('Загрузка файлов');
    $PageController->create_body();
    ?>
<script src="/script/files.js"></script>
    <article>
        <div id="catalog">
            <?php $PageController->payload();
            ?>
        </div>
    </article>
    <?php

    $PageController->end_body();
    unset($PageController);
    ?>
</html>