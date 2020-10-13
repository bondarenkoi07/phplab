<?php
class Image{
    function __construct()
    {
        date_default_timezone_set('Europe/Moscow');
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
    function getimgname(){
        $image = imagecreatetruecolor(51,20);
        $color = imagecolorallocate($image,80,31,100);
        imagefill($image,0,0,$color);
        $text = date("H:i");
        $font=someth;
        $grey =  imagecolorallocate($image,127,127,127);

        imagettftext($image,10,0,0,15,$grey,$font,$text);
        imagepng($image,"C:\\www\\phplab\\image\\clock.png");
        return 'C:\\www\\phplab\\image\\clock.png';
    }
}
?>

