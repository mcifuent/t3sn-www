<?php
 
require './fragments/lib.php';
 
$object = new CRUD_json();
 
 $script="";
 if (isset($_GET['timer'])) {
 $script='<script> /*alert(\' Die Seite wird alle '.$_GET['timer'].' Millisekunden neu geladen.\') ;*/ window.setInterval(function() {window.location.href=window.location.href },'.$_GET['timer'].' * 1000 );</script>';
 
 
 }
 
 if (isset($_GET['token'])) {
	 
	  $rows = $object->getAnswersByToken($_GET['code'],$_GET['token']); 
 }
 else {
 $rows = $object->getAnswers($_GET['code']); 
 }
 $data = '{"data":[';
if (count($rows) > 0) {

    foreach ($rows as $row) {
	$data .='{"id":'.$row["id"]. ','.'"timestamp":"'.$row["timestamp"]. '","session":"'.$row["session"]. '","token":"'.$row["token"].'","row":'.$row["text"].'}';
	
	if($row != $rows[count($rows)-1]) {$data .=',';}
    }
$data .="]}";
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}
 
 echo '<!DOCTYPE html>
<html lang="de"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.$script.'</head><body><table>';
echo '<thead><tr><td>ID</td><td>TIMESTAMP</td><td>SESSION</td><td>TOKEN</td><td>STATUS</td><td>TYPE</td><td>THEME</td><td>QUESTION</td><td>ANSWER</td></tr></thead>';

$myObject = json_decode($data);
if ($myObject){
echo '<tbody>';

foreach ($myObject->data as &$value) {
	echo ('<tr>');
    echo ('<td>'.$value->id.'</td><td>'.$value->timestamp.'</td><td>'.$value->session.'</td></td><td>'.$value->token.'</td>');
	foreach ($value->row as &$value1) {
		echo '<td>'.$value1.'</td>';
		
	}
	
	echo ('</tr>');
}
} else {
	echo '<tr><td>Keine Antworten für "'.$_GET['code'].'" vorhanden.</td></tr>';
}
 echo '</tbody>';
 echo '</table></body></html>';
//var_dump( $myObject->data[0]->id); 

?>
