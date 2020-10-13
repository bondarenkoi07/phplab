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
                  <input type="text" name="captcha" placeholder="Введите капчу" form="FileForm">
                  <p><input type="submit" value="Отправить" form="FileForm" /></p>
                  
                  <button onclick="AddFiles()">Добавить поле для файла</button>';
            }
            else{
                header( "refresh:0;url='http://localhost:8080/php/auth_db.php' ");
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
        <img src='captcha.php?a=<?php echo rand(1, 999);?>&b=<?php echo rand(1, 999);?>&op=<?php echo rand(1, 3);?>'  alt="hui" />
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