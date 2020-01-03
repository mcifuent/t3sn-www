<?php
 
require './fragments/lib.php';
 
$object = new CRUD_json();
 
 $script="";
 if (isset($_GET['timer'])) {
 $script='<script> /*alert(\' Die Seite wird alle '.$_GET['timer'].' Millisekunden neu geladen.\') ;*/ window.setInterval(function() {window.location.href=window.location.href },'.$_GET['timer'].' * 1000 );</script>';
 
 
 }
 

 if (isset($_GET['code'])) {
	 
	  $rows = $object->getPoints($_GET['code']); 

 }
 
 $data = '{"data":[';
if (count($rows) > 0) {

    foreach ($rows as $row) {
          
	$data .='{"id":'.$row["id"]. ','.'"timestamp":"'.$row["timestamp"]. '","session":"'.$row["session"]. '","token":"'.$row["token"].'","points":"'.$row["points"].'","comment":"'.str_replace('"','\"',$row["comment"]).'","text":"'.preg_replace("#[\r\n\t]#",' ',str_replace('"','\"',$row["text"])).'"}';
	
	if($row != $rows[count($rows)-1]) {$data .=',';}
    }
$data .="]}";
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}

 echo '<!DOCTYPE html>
<html lang="de"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.$script.'</head><body><table>';
echo '<thead><tr><td class="noprint">ID</td><td class="noprint">TIMESTAMP</td><td class="noprint">SESSION</td><td >TOKEN</td><td>TEXT</td><td>POINTS</td><td>COMMENT</td></tr></thead>';

$myObject = json_decode($data);

if ($myObject){
echo '<tbody>';

foreach ($myObject->data as &$value) {
if ($mytoken!=$value->token) {
echo('<tr><td class="noprint"></td><td class="noprint"></td><td ></td><td></td><td>Gesamtpunkte</td><td>'.$myPoints.'</td></tr>');
echo('<tr class="pagebreak"></tr>');
$myPoints = 0;
}
	echo ('<tr>');
    echo ('<td class="noprint">'.$value->id.'</td><td class="noprint">'.$value->timestamp.'</td><td class="noprint">'.$value->session.'</td><td >'.$value->token.'</td><td>'.$value->text.'</td><td>'.$value->points.'</td><td>'.$value->comment.'</td>');
	
	echo ('</tr>');

$mytoken=$value->token;
$myPoints = $myPoints + $value->points;

}
} else {
	echo '<tr ><td>Keine Antworten für "'.$_GET['code'].'" vorhanden.</td></tr><tr id="pagebreak"></tr>';
}

echo('<tr><td class="noprint"></td><td class="noprint"></td><td></td><td>Gesamtpunkte</td><td>'.$myPoints.'</td></tr>');
echo('<tr class="pagebreak"></tr>');


 echo '</tbody>';
 echo '</table></body></html>';
//var_dump( $myObject->data[0]->id); 

?>
