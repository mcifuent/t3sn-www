<?php

echo $_SERVER['DOCUMENT_ROOT'] . '/k1/fullPage/phppdf/my2.pdf';
$myurl =  'my2.pdf';
$image = new Imagick($_SERVER['DOCUMENT_ROOT'] . '/k1/fullPage/phppdf/my2.pdf');
$image->setResolution( 300, 300 );
$image->setImageFormat( "png" );
$image->writeImage('newfilename.png');


?>