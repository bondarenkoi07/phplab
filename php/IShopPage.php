<?php


interface IShopPage
{
    public function   __construct(string $title='');
    public function create_body();
    public function create_title(string $title);
    public function start_db_connection();
    public function end_body();
}
abstract class ShopPage implements IShopPage
{
     protected  $dbp;
     function create_title(string $title =''){
         echo ' <head>
        <title>'.$title. '</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/static/css/reset.css">
        <link rel="shortcut icon" href="/static/favicon.ico" type="image/x-icon">
        <link href="http://allfont.ru/allfont.css?fonts=dejavu-sans-mono&effects=anaglyphic" rel="stylesheet" type="text/css" />
        <link rel = "stylesheet" href="/static/css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <meta name="viewport" content=" initial-scale=1">
    </head>';

}
    public function create_body()
    {
        echo '    <body>
        <div class="menu">
            <div class="logo"><a class ="font-effect-anaglyphic" href="/">SHOP</a></div>
        </div>
        <nav>
            <p> <a href="/static/input.shtml"><img class="lnk" src="/image/input.jpg"  height="50" width="50" alt="Отправка вакансии"></a></p>
            <p><a href="/php/goods.php"><img class="lnk" src="/image/premium_catalog.jpg" height="50" width="50" alt="Премиум каталог"></a></p>
            <p><a href="/php/cart.php"><img  class="lnk" src="/image/cart.jpg" height="50" width="50" alt="Премиум каталог"></a></p>
            <p><a href="/php/auth_db.php"><img  class="lnk" src="/image/valacas.jpg" height="50" width="50" alt="Авторизация"></a></p>
            <p><a href="/php/show.php"><img  class="lnk" src="/image/krol.jpg" height="50" width="50" alt="Список товаров"></a></p>
            <p><a href="/php/regexp.php"><img  class="lnk" src="/image/input.jpg" height="50" width="50" alt="Регистрация"></a></p>
            <p><a href="/php/users_cab.php"><img  class="lnk" src="/image/cab.jpeg" height="50" width="50" alt="Личный кабинет"></a></p>
            <p><a href="/php/fileupload.php"><img  class="lnk" src="/image/cab.jpeg" height="50" width="50" alt="Личный кабинет"></a></p>
        </nav>';
    }
    public function start_db_connection()
    {
        $host    = "localhost";
        $port = '5432';
        $db_name = "vacance";
        $user    = "vacance";
        $pass    = "fghfghfgh1337";
        $dsn = "pgsql:host=$host;port=$port;dbname=$db_name;";


        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC );
        try {
            $this->dbp = new PDO($dsn, $user, $pass,$opt);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return 1;
        }
        return 0;
    }

    public function end_body(){
         echo '
                <footer>
                    Бондаренко И. А. Номер телефона:88005553535 © '.date('Y').'
                </footer>
                </body>';
    }
    abstract function payload();
    public function __destruct()
    {
        $dbp = null;
    }
}

class AuthPage  {
    protected $dbp;
    public $username;
    public function __construct()
    {
        $this->start_db_connection();
        if($this->authed())
            $this->username = $_SESSION['user'];
    }
    private function start_db_connection(){
        $host    = "localhost";
        $port = '5432';
        $db_name = "vacance";
        $user    = "vacance";
        $pass    = "fghfghfgh1337";
        $dsn = "pgsql:host=$host;port=$port;dbname=$db_name;";


        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC );
        try {
            $this->dbp = new PDO($dsn, $user, $pass,$opt);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return 1;
        }
        return 0;
    }
    public function auth(string $login,string $password){
        $query = $this->dbp->prepare('SELECT user_lab5.password,users.rigths from user_lab5 LEFT JOIN users on user_lab5.email = users.login where email =  (?)');
        $query->bindParam(1, $login);
        $login = htmlspecialchars($login);
        $statement = $query->execute();
        $row = $query->fetch();
        if(!$statement){
            echo 'invalid login';
        }
        elseif(md5($password) == $row['password'] ){
            $_SESSION['user']=$login;
            $_SESSION['rigths']=$row['rigths'];
            echo ' <form action="" method="POST">';
            echo "<input type='submit' name='exit' value='Выход'>";
            echo   ' </form> ';
            header( "refresh:0;url='http://localhost/php/show.php' ");
            $_SESSION['cart'] = $_COOKIE['cart'] ??'';
            $this->username = $_SESSION['user'];
        }
        else{
            echo 'invalid password';
        }
        $this->dbp=null;
    }
    function permission(string $right,string $str){
        if(isset($_SESSION['user'])&& !empty($_SESSION['user'])){
            if($_SESSION['rigths']==$right){
                return $str;
            }
            else
                return '';
        }
        else
            return '';
    }
    public function authed(){
        return isset($_SESSION['user'])&&!empty($_SESSION['user']);
    }
    public function  deauth(){
        if(isset($_SESSION['user']))
            unset($_SESSION['user']);
        if(isset($_SESSION['cart']))
            unset($_SESSION['cart']);
        if(isset($_SESSION['rights']))
            unset($_SESSION['rights']);
        session_destroy();
    }
}

