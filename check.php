<?php
if (isset($_GET['code'])) {
    require("./fragments/lib.php");
 
    $code = $_GET['code'];
	
 //   $text = $_POST['text'];

 
    $object = new CRUD_json();
 
    echo '{result:'. $object->Check( $code).'}';
}
?>