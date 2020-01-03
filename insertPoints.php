<?php
if (isset($_POST['code']) ) {
    require("./fragments/lib.php");
 
    $code = $_POST['code'];
	
    $text = $_POST['text'];
    $session = $_POST['session'];
    $token = $_POST['token'];
$points = $_POST['points'];
$comment = $_POST['comment'];



 
    $object = new CRUD_json();
	$object->InsertPoints($session, $code, $token, $text, $points, $comment);
 
   
}

?>