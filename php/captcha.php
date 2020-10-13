<?php
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

header('Content-type: image/png');
$k=0;
    if(isset($_GET['a'])&&!empty($_GET['a'])){
            $a = $_GET['a'];
            $b = $_GET['b'];
            $operation = $_GET['op'];
            switch ($operation){
                case '1':
                    $val = (int)$a*(int)$b;
                    $operation = '*';
                    break;
                case '2':
                    $val = (int)$a+(int)$b;
                    $operation = '+';
                    break;
                case '3':
                default:
                    $val = (int)$a-(int)$b;
                    $operation = '-';
                    break;
            }
            session_start();
            $_SESSION['captcha'] =(int)$val;

            $text = $a.$operation.$b.'=?';
            $image = imagecreatetruecolor((strlen($text)+1)*20,40);
            $color = imagecolorallocate($image,80,31,100);
            imagefill($image,0,0,$color);

            $font=someth;
            $grey =  imagecolorallocate($image,127,127,127);

            imagettftext($image,20,0,0,35,$grey,$font,$text);
            imagepng($image);
    }