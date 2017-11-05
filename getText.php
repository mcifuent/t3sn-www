<?php
 
require './fragments/lib.php';
 
$object = new CRUD_json();
 

 
 
$rows = $object->getText($_GET['code']);
 $data = "";
if (count($rows) > 0) {
if (count($rows) > 1) {
	
	$data = '[';
}
    foreach ($rows as $row) {
        $data .= $row["text"];
   
   if ($rows[count($rows) - 1] != $row) {
	
	$data .= ',';
		}	

   }
if (count($rows) > 1) {
	
	$data .= ']';
}	
	
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}
 

 
echo $data ;
 
?>