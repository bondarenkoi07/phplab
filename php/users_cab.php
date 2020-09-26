<?php
        include 'IShopPage.php';
        include  'FileManagement.php';
        class CabPage extends ShopPage{
            private $user;
            private $FM;
            public function __construct(string $title='')
            {
                session_start();
                $this->user = new AuthPage();
                $this->create_title($title);
                $this->start_db_connection();
                $this->FM = new FileManagement($this->dbp,$this->user);

            }

            public function payload()
            {
                echo  '<h3 class="anaglyph" >Парсинг uri</h3>';
               $this->uri_parse();
               echo '            </div>
            <div class="position">
                                    <h3 class="anaglyph" >Файлы</h3>';
                $this->FM->GetFilenames();
               $this->FM->GetPayload();
            }

            public function uri_parse()
            {
                if($this->user->authed()){
                    $uri_mask="/(?<scheme>http[s]?|ftp):\/\/(?<domain>[\w\.-]+)\.(?<zone>[\w]+)\/?(?<path>[^?$]+)?(?<query>[^#$]+)?[#]?(?<fragment>[^$]+)?/";
                    $query = $this->dbp->query("SELECT site FROM user_lab5 where email='".$_SESSION['user']."'");
                    $row=$query->fetch();
                    if(isset($row['site'])&&!empty($row['site'])) {
                        preg_match($uri_mask, $row['site'], $match);
                        if (isset($match['scheme']))
                            echo "<br> <a class='pos'>Протокол:" . $match['scheme'] . "</a> </br>";
                        if (isset($match['domain']))
                            echo "<br><a class='pos'>Домен:" . $match['domain'] . "</a> </br>";
                        if (isset($match['zone']))
                            echo "<br><a class='pos'>Зона:" . $match['zone'] . "</a> </br>";
                        if (isset($match['path']))
                            echo "<br><a class='pos'>Текущий каталог:" . str_replace('/', '', strchr($match['path'], '/', false)) . "</a> </br>";
                        if (isset($match['query']))
                            echo "<br><a class='pos'>GET-запрoс:" . str_replace('?', '', $match['query']) . "</a> </br>";
                    }
                    echo ' <form action="auth_db.php" method="POST">';
                    echo "<input type='submit' name='exit' value='Выход'>";
                    echo   ' </form> ';
                }
                else{
                   header( "refresh:0;url='http://localhost/php/auth_db.php' ");
                }
            }



            public function ChangeData(){
                $query = $this->dbp->query("SELECT * FROM user_lab5 where email='".$_SESSION['user']."'");
                $row=$query->fetch();
                echo '<input type="text" id ="site" name="'.$row['email'].'" value="'.$row['site'].'">';
                echo '<input type="button" id ="done" value="изменить">';
            }
            public function CheckDeletes(){
                if($this->user->authed()){
                    if(isset($_GET)&&!empty($_GET)){
                        if(isset($_GET['delete'])&&!empty($_GET['delete']))
                        foreach ($_GET['delete'] as $key=>$value){
                                $this->FM->RemoveFile($value);
                        }
                    }
                }
                return '';
            }
        }

?>
<!DOCTYPE html>
<html lang="ru">
<?php
$PageController = new CabPage('Личный кабинет');
$PageController->create_body();
echo $PageController->CheckDeletes();
?>
<article>
<div class="title">
            <h2 class="font-effect-anaglyphic">Личный кабинет</h2>
        </div>
        <div class="catalog">
            <div class="position">
                <?php
                $PageController->payload();
                ?>
            </div>
      </div>

</article>
<?php
    $PageController->end_body();
    unset($PageController);
?>
</html>
