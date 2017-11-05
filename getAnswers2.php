<?php
 
require './fragments/lib.php';
 
$object = new CRUD_json();
 

 
 
$rows = $object->getAnswers($_GET['code']);
 $data = '{"data":[';
if (count($rows) > 0) {

    foreach ($rows as $row) {
	$data .='{"id":'.$row["id"]. ','.'"timestamp":"'.$row["timestamp"]. '","session":"'.$row["session"].'","row":'.$row["text"].'}';
	
	if($row != $rows[count($rows)-1]) {$data .=',';}
    }
$data .="]}";
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}
 

echo $data; 

?>
