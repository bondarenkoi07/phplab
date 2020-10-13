<?php
include 'IShopPage.php';
class Auth_Page extends ShopPage{
    private $AuthController;
    public function __construct(string $title='')
    {
        session_start();
        $this->AuthController = new AuthPage();
        $this->create_title($title);
        $this->create_body();
    }

    function payload()
    {
        if(isset($_POST['exit'])){
            $this->AuthController->deauth();
        }
        if(isset($_SESSION['user'])&& !empty($_SESSION['user'])){
            echo '<p>Hello,'.$_SESSION['user'].'</p>';
            echo ' <form action="" method="POST">';
            echo "<input type='submit' name='exit' value='Выход'>";
            echo   ' </form> ';
        }
        elseif(isset($_POST)&& !empty($_POST['login'])){
            $this->AuthController->auth($_POST['login'],$_POST['password']);
            header("refresh:0;url='".$_SERVER['HTTP_REFERER']."' ");
        }
        else{
            echo ' <form action="" method="POST">
            Логин: <input type="text" name="login" >
            <p>Пароль: <input type="password" name="password" ></p>
            <p><input type="submit" value="Авторизоваться"></p>
             </form> ';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<?php $PageController = new Auth_Page('Авторизация'); ?>
    <article>
        <div class="title">
            <h2 class="font-effect-anaglyphic">ЛР3</h2>
        </div>
        <div class="catalog">
        <?php
        $PageController->payload();
        ?>
    </article>
<?php $PageController->end_body(); ?>
</html>