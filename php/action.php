<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>ЛР1. Вывод</title>
    <link rel="stylesheet" href="/reset.css">
    <link rel="shortcut icon" href="/image/favicon.ico" type="image/x-icon">
    <link href="http://allfont.ru/allfont.css?fonts=dejavu-sans-mono&effects=anaglyphic" rel="stylesheet" type="text/css" />
    <link rel = "stylesheet" href="/css/style.css">
    <meta name="viewport" content=" initial-scale=1">
</head>
<body>
    <!--#include file="/header.html"-->
    <nav>
        <p> <a href="/input.shtml"><img class="lnk" src="/image/input.jpg"  height="50" width="50" alt="Отправка вакансии"></a></p>
        <p><a href="/php/goods.php"><img class="lnk" src="/image/premium_catalog.jpg" height="50" width="50" alt="Премиум каталог"></a></p>
        <p><a href="/php/cart.php"><img  class="lnk" src="/image/cart.jpg" height="50" width="50" alt="Премиум каталог"></a></p>
        <p><a href="/php/auth_db.php"><img  class="lnk" src="/image/valacas.jpg" height="50" width="50" alt="Авторизация"></a></p>
        <p><a href="/php/show.php"><img  class="lnk" src="/image/krol.jpg" height="50" width="50" alt="Список товаров"></a></p>
        <p><a href="/php/regexp.php"><img  class="lnk" src="/image/input.jpg" height="50" width="50" alt="Регистрация"></a></p>
        <p><a href="/php/cab1.php"><img  class="lnk" src="/image/cab.jpeg" height="50" width="50" alt="Личный кабинет"></a></p>
    </nav>
<article>
<div class="title">
            <h2 class="font-effect-anaglyphic">Отправить вакансию</h2>
        </div>
        <div class="catalog">
<?php
$var=0;
if(isset($_GET['a1']))
foreach($_GET as $value){ 
    if(is_numeric($value)==TRUE)  {
    $var = (int)$_GET['a1']*((int)$_GET['b2']*(int)$_GET['c3']-(int)$_GET['b3']*(int)$_GET['c2'])-   
    (int)$_GET['b1']*((int)$_GET['a2']*(int)$_GET['c3']-(int)$_GET['a3']*(int)$_GET['c2'])+     
    (int)$_GET['c1']*((int)$_GET['a2']*(int)$_GET['b3']-(int)$_GET['a3']*(int)$_GET['b2']);
    }
    else 
        {
            echo " invalid data";
            exit();
        }
}
    echo "det = ".$var;
    echo "<br> Trainspotting: <br> ";
    if(isset($_GET['a1'])){
        echo (int)$_GET['a1']." ".(int)$_GET['a2']." ". (int)$_GET['a3']."<br> ";
        echo (int)$_GET['b1']." ".(int)$_GET['b2']." ". (int)$_GET['b3']."<br> ";
        echo (int)$_GET['c1']." ".(int)$_GET['c2']." ". (int)$_GET['c3'];
    }
?>
            </form> 
        </div>
</article>
    <!--#include file="/ads.html"-->
    <!--#include file="/footer.shtml"-->
    </body>
</html>