<?php
    include 'IShopPage.php';
    class RegProcess extends ShopPage{
        private$email_mask;
        private$name_mask;
        private$password_mask;
        private$uri_mask;
        private$phone_number_mask;
        private$date_mask;
        private$ip_mask;
        private $Auth ;
        private $message="all is ok";
        public function __construct(string $title='')
        {
            $this->start_db_connection();
            $this->email_mask="|^([\w\d_.-]+)@([\w\d.-]+)\.(\w+)|is";
            $this->name_mask="|^([А-ЯЁ])([а-яё]{2,})|iu";
            $this->password_mask="|(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}|";
            $this->uri_mask="/(?<scheme>http[s]?|ftp):\/\/(?<domain>[\w\.-]+)\.(?<zone>[\w]+)\/?(?<path>[^?$]+)?(?<query>[^#$]+)?[#]?(?<fragment>[^$]+)?/";
            $this->phone_number_mask="/^(\+\d|\d)(\d{3,3})(\d{7,7})$/";
            $this->date_mask="/^(\d{1,4})-(\d{1,2})-(\d{1,2})/";
            $this->ip_mask="/^(\d{1,3}).(\d{1,3}).(\d{1,3}).(\d{1,3})$/";
            $this->Auth= new AuthPage();
            $this->dbp->beginTransaction();
            if(!isset($_SESSION['user'])||empty($_SESSION['user']))
                $this->payload();
            else{
                header( "refresh:0;url='http://db1.mati.su/php/goods.php' ");
            }
        }
        public function payload()
        {
            if(isset($_POST)){
                if(isset($_POST['name']) && isset($_POST['surname'])&& isset($_POST['email'])&& isset($_POST['password'])&&
                    !empty($_POST['name']) && !empty($_POST['surname'])&& !empty($_POST['email'])&& !empty($_POST['password'])) {
                    $this->registration();
                }
                else{
                    $this->message = "Вы пропустили основные данные";
                }
            }
        }
        private function registration(){
            $query = $this->dbp->query("SELECT * FROM user_lab5 ");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $error=true;
            while($row=$query->fetch()){
                if($row['email']==$_POST['email']){
                    $error = false;
                    break;
                }
                else
                    $error=true;
            }
            if(!$error){
                $this->message="Пользователь с такой почтой уже существует.";
            }
            else{
                $expression = preg_match($this->email_mask,$_POST['email'])&&
                    preg_match($this->name_mask,$_POST['name'])&&
                    preg_match($this->name_mask,$_POST['surname'])&&
                    preg_match($this->password_mask,$_POST['password']);

                if($expression){
                    $query = $this->dbp->prepare('INSERT INTO 
                    user_lab5 
                    (name,surname,password,email) 
                    VALUES 
                    (?,?,?,?)');
                    $name=htmlspecialchars($_POST['name']);
                    $surname=htmlspecialchars($_POST['surname']);
                    $email=htmlspecialchars($_POST['email']);
                    $password=htmlspecialchars(md5($_POST['password']));
                    $query->bindParam(1, $name);
                    $query->bindParam(2, $surname);
                    $query->bindParam(3, $password);
                    $query->bindParam(4, $email);
                    $query->execute();
                    if(preg_match($this->date_mask,$_POST['birthday']) && isset($_POST['birthday'])&&!empty($_POST['birthday']) ){
                        $query_bd=$this->dbp->prepare("UPDATE user_lab5
                        SET birthday= '".$_POST['birthday']."' WHERE email='".$email."'");
                        $query_bd->execute();
                    }
                    else if(!preg_match($this->date_mask,$_POST['birthday'])&&!empty($_POST['birthday'])){
                        $this->message="Некорректная дата рождения";
                    }
                    if(preg_match($this->uri_mask,$_POST['url'])&&isset($_POST['url'])&&!empty($_POST['url'])){
                        try{
                            $query_uri=$this->dbp->prepare("UPDATE user_lab5
                            SET site= '".$_POST['url']."' WHERE email='".$email."'");
                            $query_uri->execute();
                        }
                        catch(PDOException $e){
                            echo $e->getMessage();
                        }
                    }
                    else if(!preg_match($this->uri_mask,$_POST['url'])&&!empty($_POST['url'])){
                        $this->message="Некорректный uri.";
                    }
                    if(preg_match($this->ip_mask,$_POST['ip'])&&isset($_POST['ip'])&&!empty($_POST['ip'])){
                        $query_ip=$this->dbp->prepare("UPDATE user_lab5
                        SET ip_adress= '".$_POST['ip']."' WHERE email='".$email."'");
                        $query_ip->execute();
                    }
                    else if(!preg_match($this->ip_mask,$_POST['ip'])&&!empty($_POST['ip'])){
                        $this->message="Неверный ip.";
                    }
                    if(preg_match($this->phone_number_mask,$_POST['phone'])&&isset($_POST['phone'])&&!empty($_POST['phone']) ){
                        $query_pn=$this->dbp->prepare("UPDATE user_lab5
                        SET phone_number= '".$_POST['phone']."' WHERE email='".$email."'");
                        $query_pn->execute();

                    }
                    else if(!preg_match($this->date_mask,$_POST['phone'])&&!empty($_POST['phone'])){
                        $this->message="Некорректный номер телефона.";
                    }
                    if($this->message=="all is ok"){
                        session_start();
                        $_SESSION['user_lab5']=$email;
                        try{
                            $q=$this->dbp->prepare("insert into users (rigths,login,password) 
                                                        SELECT 'user',user_lab5.email,user_lab5.password as ps 
                                                        FROM user_lab5 left join users 
                                                        on user_lab5.email=users.login 
                                                        WHERE users.login is NULL");
                            $q->execute();
                            $this->dbp->commit();
                        }
                        catch(PDOException $e){
                            echo $e->getMessage();
                        }
                    }
                    else{
                        $this->dbp->rollBack();
                    }
                }
                else{
                    $this->message = "Данные введены не правильно.";
                }
            }
        }
        public function GetMsg(){
            return $this->message;
        }
    }
$PageController = new RegProcess('');
            if($PageController->GetMsg()=="all is ok"){
                header( "refresh:0;url='http://db1.mati.su/php/cab1.php' ");
            }
            else{
                setcookie("warning",$PageController->GetMsg());
                header( "refresh:0;url='http://db1.mati.su/php/regexp.php' ");
            }

?>