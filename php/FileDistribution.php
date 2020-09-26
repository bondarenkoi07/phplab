<?php

include 'IShopPage.php';

class FileDistribution{
    private $User;
    public $flag;
    public function __construct()
    {
        session_start();
        $this->User = new AuthPage();
    }
    public function payload()
    {

            $msg = '';
        $path = '/home/ilya/phplab/userfiles';
            $this->flag = false;
        if ($this->User->authed()) {

            if (!is_dir($path . "/" . $this->User->username)) {
                if (!mkdir($path . "/" . $this->User->username, 0775, true)) {
                    $msg .= 'trouble with rights';
                    $this->flag = true;
                } else {
                    $msg .= 'dir add error';
                    $this->flag = false;
                }
            }

            if (isset($_FILES['files']['error']) && is_array($_FILES['files']['error'])) {
                foreach ($_FILES['files']['error'] as $key => $error) {

                    if ($error == UPLOAD_ERR_OK) {

                        if ($_FILES["files"]["type"][$key] !== "image/png") {

                            echo 'hello \n';
                            $msg .= 'your pic' . htmlspecialchars($_FILES['files']['name'][$key]) . ' isn\'t a PNG';
                            $this->flag = true;
                        }
                        else {

                            $Name = htmlspecialchars($_FILES['files']['name'][$key]);
                            $TmpName = $_FILES['files']['tmp_name'][$key];
                            if (move_uploaded_file($TmpName, $path . "/" . $this->User->username . '/' . $Name)) {
                                $this->flag = false;

                            }

                        }
                    } else {
                        $msg .= $error;
                        $this->flag = true;
                    }
                }

            }
            else{
                $msg .= 'something is wrong.';
                $this->flag = true;
            }
        }
            setcookie('warnings',$msg,time()+3600);

        if($this->flag){
            header("refresh:0;url='http://localhost/php/fileupload.php'");
        }else
            header("refresh:0;url='http://localhost/php/users_cab.php'");
    }
}

$PageController = new FileDistribution();
$PageController->payload();
unset($PageController);
