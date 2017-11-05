<?php
if (isset($_POST['code']) && isset($_POST['text']) ) {
    require("./fragments/lib.php");
 
    $code = $_POST['code'];
	
    $text = $_POST['text'];
	$session = $_POST['session'];
	$token = $_POST['token'];

 
    $object = new CRUD_json();
 
    $object->InsertAnswer($session , $token, $code, $text);
}