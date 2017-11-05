<?php
if (isset($_POST['code']) && isset($_POST['text']) ) {
    require("./fragments/lib.php");
 
    $code = $_POST['code'];
	
    $text = $_POST['text'];

 
    $object = new CRUD_json();
 
    $object->Create( $code, $text);
}
?>