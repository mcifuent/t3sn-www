<?php
 
require './fragments/lib.php';
 
$object = new CRUD_json();
 

 
 
$rows = $object->getJSONbyClass($_GET['class']);
 $data = "{";
 $data .= "\"jsons\":\n[";
 $isfirst = true;
if (count($rows) > 0) {

    foreach ($rows as $row) {
		//if ($data != "{") $data .=",\n"; 
		if (!$isfirst) $data .=",";
		$data .= "{";
		$data .= "\"id\":\"".$row["id"]."\",\n";
        $data .= "\"code\":\"".$row["code"]."\",\n";
		$data .= "\"author\":\"".$row["author"]."\",\n";
		$data .= "\"title\":\"".$row["title"]."\"\n";
		
		$data .= "}\n";
		 $isfirst = false;
    }
	$data .= "]\n";
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}
 

 $data .= "}"; 
echo $data ;
 
?>