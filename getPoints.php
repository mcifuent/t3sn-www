<?php
 
require './fragments/lib.php';

function createSubHeader($code, $token) {
	
	return $code. ' '.$token;
}

function createTableHeader(){
	
	return '<thead><tr><td class="noprint">ID</td><td class="noprint">TIMESTAMP</td><td class="noprint">SESSION</td><td class="noprint">TOKEN</td><td>Aufgabe</td><td>Pkte</td><td>Kommentar</td></tr></thead>';
}


function getGrade($myPoints, $myMaxPoints) {
	$Quotient = round($myPoints/$myMaxPoints * 100,2);
	$myReturn="ungenügend";
	if ($Quotient >= 30)  $myReturn="mangelhaft";
	if ($Quotient >= 50)  $myReturn="ausreichend";
	if ($Quotient >= 67)  $myReturn="befriedigend";
	if ($Quotient >= 81)  $myReturn="gut";
	if ($Quotient >= 92)  $myReturn="sehr gut";
	return  $myReturn;
}

function createSumRow($myPoints,$myMaxPoints) {
	
		return '<tr><td class="noprint"></td><td class="noprint"></td><td class="noprint"></td><td class="noprint"></td><td>Gesamtpunkte</td><td>'.$myPoints.'/'.$myMaxPoints.'</td><td>'.getGrade($myPoints,$myMaxPoints).'</td>  </tr>';
}


 
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
<html lang="de"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.$script.'</head><body>';



$myObject = json_decode($data);

$myPoints = 0;
$myMaxPoints = 0;
$isFirst = true;


if ($myObject){
	

	foreach ($myObject->data as &$value) {
		
	if (isset ($mytoken) && $mytoken!=$value->token) {
		echo createSumRow($myPoints,$myMaxPoints);
	
		echo('</tbody></table><br/>');
		$myPoints = 0;
		$myMaxPoints = 0;
		$isFirst = true;
	} 	
		
	if($isFirst == true){
		echo createSubHeader($_GET['code'],$value->token);
		echo '<table>';
		echo createTableHeader();	
		echo '<tbody>';	
		$isFirst = false;
	}
	
		echo ('<tr>');
		echo ('<td class="noprint">'.$value->id.'</td><td class="noprint">'.$value->timestamp.'</td><td class="noprint">'.$value->session.'</td><td class="noprint">'.$value->token.'</td><td>'.$value->text.'</td><td>'.$value->points.'</td><td>'.$value->comment.'</td>');
		
		echo ('</tr>');
		$myMaxPoints = $myMaxPoints + preg_replace('/.*#/','',$value->text);

	
		
	
	
		$mytoken=$value->token;
		$myPoints = $myPoints + $value->points;	
		
	


}
	} else 
		{
		echo '<tr ><td>Keine Antworten für "'.$_GET['code'].'" vorhanden.</td></tr><tr id="pagebreak"></tr>';
		}

echo createSumRow($myPoints,$myMaxPoints);
echo('</tbody></table>');



 echo '</body></html>';
//var_dump( $myObject->data[0]->id); 

?>
