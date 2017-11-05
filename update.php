<?php
if (isset($_POST['code']) && isset($_POST['text']) ) {
    require("./fragments/lib.php");
 
    $code = $_POST['code'];
	
    $text = $_POST['text'];
	
	$title = $_POST['title'];

 
    $object = new CRUD_json();
 
    echo '{result:'.$object->Update( $code, $title, $text).'}';
}
?>