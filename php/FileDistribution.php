<?php

include 'IShopPage.php';

class FileDistribution{
    private $User;
    public $flag;
    public function __construct()
    {
        session_start();
        $this->User = new AuthPage();
        $dir=opendir('C:/www/phplab/static/fonts/');//directory with fonts

        if($dir)

            while($f=readdir($dir)){

                if(preg_match('/.ttf$/',$f)){

                    $font=explode('.',$f);

                    define($font[0],realpath('C:/www/phplab/static/fonts/'.$f));

                }

            }

        if($dir)
            closedir($dir);
        putenv('GDFONTPATH=' . realpath('C:\\www\\phplab\\static\\fonts\\'));

    }
    public function payload()
    {

            $msg = '';
        $path = 'C:\\www\\phplab\\userfiles';
            $this->flag = false;
        if ($this->User->authed()) {
            if (isset($_POST['captcha']) && !empty($_POST['captcha']) && (int)$_POST['captcha'] === $_SESSION['captcha']) {
                if (!is_dir($path . "\\" . $this->User->username)) {
                    if (!mkdir($path . "\\" . $this->User->username, 0775, true)) {
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

                            if ($_FILES["files"]["type"][$key] !== "image/png" || !$image = imagecreatefrompng($_FILES['files']['tmp_name'][$key])) {

                                echo 'hello \n';
                                $msg .= 'your pic' . htmlspecialchars($_FILES['files']['name'][$key]) . ' isn\'t a PNG';
                                $this->flag = true;
                            } else {

                                $Name = htmlspecialchars($_FILES['files']['name'][$key]);
                                $color = imagecolorallocatealpha($image, 0x80, 0x80, 0x80, 25);
                                $text = "watermark";

                                if (imagettftext($image, 20, -45, 21, 21, $color, someth, $text)) {
                                    $this->flag = false;
                                    if (imagepng($image, $path . "\\" . $this->User->username . '\\' . $Name)) {
                                        $this->flag = false;
                                    } else {
                                        $this->flag = true;
                                    }
                                } else {
                                    $this->flag = true;
                                }

                            }
                        } else {
                            $msg .= $error;
                            $this->flag = true;
                        }
                    }

                } else {
                    $msg .= 'something is wrong.';
                    $this->flag = true;
                }
            }else{
                $msg .= 'invalid captcha:'.$_POST['captcha']. '!=' .$_SESSION['captcha'];
                $this->flag = true;
            }
            setcookie('warnings', $msg, time() + 3600);

            if ($this->flag) {
                header("refresh:0;url='http://localhost:8080/php/fileupload.php'");
            } else
                header("refresh:0;url='http://localhost:8080/php/users_cab.php'");
        }
    }
}

$PageController = new FileDistribution();
$PageController->payload();
unset($PageController);
