<?php
        include 'IShopPage.php';
        class CabPage extends ShopPage{
            private $user;
            public function __construct(string $title='')
            {

                $this->user = new AuthPage();
                $this->create_title($title);
                $this->start_db_connection();
                session_start();
            }
            public function payload()
            {
                if($this->user->authed()){
                    $uri_mask="/(?<scheme>http[s]?|ftp):\/\/(?<domain>[\w\.-]+)\.(?<zone>[\w]+)\/?(?<path>[^?$]+)?(?<query>[^#$]+)?[#]?(?<fragment>[^$]+)?/";
                    $query = $this->dbp->query("SELECT site FROM user_lab5 where email='".$_SESSION['user']."'");
                    $row=$query->fetch();
                    if(isset($row['site'])&&!empty($row['site'])) {
                        preg_match($uri_mask, $row['site'], $match);
                        if (isset($match['scheme']))
                            echo "<br> Протокол:" . $match['scheme'] . "</br>";
                        if (isset($match['domain']))
                            echo "<br>Домен:" . $match['domain'] . "</br>";
                        if (isset($match['zone']))
                            echo "<br>Зона:" . $match['zone'] . "</br>";
                        if (isset($match['path']))
                            echo "<br>Текущий:" . str_replace('/', '', strchr($match['path'], '/', false)) . "</br>";
                        if (isset($match['query']))
                            echo "<br>GET-запрoс:" . str_replace('?', '', $match['query']) . "</br>";
                    }
                    echo ' <form action="auth_db.php" method="POST">';
                    echo "<input type='submit' name='exit' value='Выход'>";
                    echo   ' </form> ';
                }
                else{
                   header( "refresh:0;url='http://db1.mati.su/php/auth_db.php' ");
                }
            }
            public function ChangeData(){
                $query = $this->dbp->query("SELECT * FROM user_lab5 where email='".$_SESSION['user']."'");
                $row=$query->fetch();
                echo '<input type="text" id ="site" name="'.$row['email'].'" value="'.$row['site'].'">';
                echo '<input type="button" id ="done" value="изменить">';
            }
        }
?>
<!DOCTYPE html>
<html lang="ru">
<?php
$PageController = new CabPage('Личный кабинет');
$PageController->create_body()
?>
<article>
<div class="title">
            <h2 class="font-effect-anaglyphic">Личный кабинет</h2>
        </div>
        <div class="catalog">
            <?php
                 $PageController->payload();
                 $PageController->ChangeData();
            ?>
            <script src="/script/ajax.js"></script>
            <p id="load" style="cursor: pointer;">Hello!</p>
            <div id="info"><img id="wait" src="/image/classic1.gif" alt="Ожидание" style="display: none;" height="17px" width="17px"/></div>
        </div>

</article>
<?php
    $PageController->end_body();
    unset($PageController);
?>