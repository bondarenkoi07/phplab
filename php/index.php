<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>ЛР1. Ввод</title>
    <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/static/css/reset.css">
    <link rel="shortcut icon" href="../static/favicon.ico" type="image/x-icon">
    <link href="http://allfont.ru/allfont.css?fonts=dejavu-sans-mono&effects=anaglyphic" rel="stylesheet" type="text/css" />
    <link rel = "stylesheet" href="/static/css/style.css">
    <meta name="viewport" content=" initial-scale=1">
</head>
<body>
    <article>
        <div class="title">
            <h2 class="font-effect-anaglyphic">ЛР1. </h2>
        </div>
        <div class="catalog">

           <?php
           if(isset($_GET)&&!empty($_GET)){
               if (isset($_GET['admin'])&&!empty($_GET['admin'])&&$_GET['admin']== 'fghfghfgh'){
                   echo 'Hello!';
               }
               else{
                   echo 'bye!';
               }
           }
           else{
               echo 'bye!';
           }
           ?>

        </div>
    </article>
</body>
</html>