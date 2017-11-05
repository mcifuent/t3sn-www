<?php
session_start(); 
require './fragments/lib.php';
 
$object = new CRUD_json();
 

 
 
$rows = $object->getText($_GET['code']);
 $data = "";
if (count($rows) > 0) {

    foreach ($rows as $row) {
        $data .= $row["text"];
    }
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}
 

 
echo $data ;
 
?>