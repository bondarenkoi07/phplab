<?php
header('Content-type: image/png');

try {
    $image = new Imagick('userfiles/bondar@yan.ru/workspace.png');
    // Если в качестве ширины или высоты передан 0,
// то сохраняется соотношение сторон
    $image->thumbnailImage(100, 0);

    echo $image;
} catch (ImagickException $e) {
    //echo $e.'blyat';
}
    ?>
