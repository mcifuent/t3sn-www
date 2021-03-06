<?php

require './fragments/lib.php';
$myClassAvg;
$myClassAvg["gut"]=0;
$myClassAvg["mangelhaft"]=0;
$myClassAvg["ungenügend"]=0;
$myClassAvg["sehr gut"]=0;
$myClassAvg["befriedigend"]=0;
$myClassAvg["ausreichend"]=0;
$myClassAvg["points"]=0;
$myClassAvg["maxpoints"]=0;
$myClassAvg["null"]=0;

function createSubHeader($code, $token) {
	
	return $code. ' '.$token;
}

function createTableHeader($code,$token){
	
	return '<thead><tr><td  colspan="10">'.$code.' '. $token.' </td><tr><tr><td class="noprint">ID</td><td class="noprint">TIMESTAMP</td><td class="noprint">SESSION</td><td class="noprint">TOKEN</td><td>Aufgabe</td><td>Pkte</td><td>Kommentar</td></tr></thead>';
}


function getGrade($myPoints, $myMaxPoints) {
	 $myReturn="null";
	if ($myMaxPoints > 0) {  
	$Quotient = round($myPoints/$myMaxPoints * 100,2);
	$myReturn="ungenügend";
	if ($Quotient >= 30)  $myReturn="mangelhaft";
	if ($Quotient >= 50)  $myReturn="ausreichend";
	if ($Quotient >= 67)  $myReturn="befriedigend";
	if ($Quotient >= 81)  $myReturn="gut";
	if ($Quotient >= 92)  $myReturn="sehr gut";
	}
	return  $myReturn;
}

function createSumRow($myPoints,$myMaxPoints) {
	global $myClassAvg;
	$myClassAvg[getGrade($myPoints,$myMaxPoints)] = $myClassAvg[getGrade($myPoints,$myMaxPoints)] + 1;
	$myClassAvg["points"] = $myClassAvg["points"] + $myPoints;
	$myClassAvg["maxpoints"] = $myClassAvg["maxpoints"] + $myMaxPoints;

		return '<tr><td class="noprint"></td><td class="noprint"></td><td class="noprint"></td><td class="noprint"></td><td><b>Gesamtpunkte</b></td><td><b>'.$myPoints.'/'.$myMaxPoints.'</b></td><td><b>'.getGrade($myPoints,$myMaxPoints).'</b></td>  </tr>';
}



$object = new CRUD_json();
 
 $script="";
 if (isset($_GET['timer'])) {
	$script='<script> /*alert(\' Die Seite wird alle '.$_GET['timer'].' Millisekunden neu geladen.\') ;*/ window.setInterval(function() {window.location.href=window.location.href },'.$_GET['timer'].' * 1000 );</script>';
 
 
 }
 

 if (isset($_GET['code'])) {
	 
	  $rows = $object->getPoints($_GET['code']); 

 }
//print_r $rows;
 $data = '{"data":[';
if (count($rows) > 0) {

    foreach ($rows as $row) {
	//	echo '{"id":'.$row["id"]. ','.'"timestamp":"'.$row["timestamp"]. '","session":"'.$row["session"]. '","token":"'.$row["token"].'","points":"'.$row["points"].'","comment":"'.str_replace('"','\"',$row["comment"]).'","text":"'.preg_replace("#[\r\n\t]#",' ',str_replace('"','\"',$row["text"])).'"}';
	//echo '<hr>';
          
	$data .='{"id":'.$row["id"]. ','.'"timestamp":"'.$row["timestamp"]. '","session":"'.$row["session"]. '","token":"'.$row["token"].'","points":"'.$row["points"].'","comment":"'.$row["comment"].'","text":"'.$row["text"].'"}';
	
	if($row != $rows[count($rows)-1]) {$data .=',';}
    }
$data .="]}";
} else {
    // records not found
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}
/**echo '------------------------';
echo '<hr>';
echo $data;
echo '<hr>';
//echo '------------------------'; **/

 echo '<!DOCTYPE html>
<html lang="de"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'.$script.'</head><body>';

//echo $data;

$myObject = json_decode($data);

$myPoints = 0;
$myMaxPoints = 0;
$isFirst = true;
$myClassAvg;



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
	//	echo createSubHeader();
		echo '<table>';
		echo createTableHeader($_GET['code'],$value->token);	
		echo '<tbody>';	
		$isFirst = false;
	}
	
		echo ('<tr>');
		echo ('<td class="noprint">'.$value->id.'</td><td class="noprint">'.$value->timestamp.'</td><td class="noprint">'.$value->session.'</td><td class="noprint">'.$value->token.'</td><td>'.preg_replace('/#.*/','',$value->text).'</td><td>'.$value->points.'/'. preg_replace('/.*#/','',$value->text).'</td><td>'.$value->comment.'</td>');
		
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
echo('</tbody></table><br/>');

echo '<h1>Notenspiegel '.$_GET['code'].' </h1>';
echo  '(1) sehr gut: '. $myClassAvg["sehr gut"].'<hr/>';
echo  '(2) gut: '. $myClassAvg["gut"].'<hr/>';
echo  '(3) befriedigend: '. $myClassAvg["befriedigend"].'<hr/>';
echo  '(4) ausreichend: '. $myClassAvg["ausreichend"].'<hr/>';
echo  '(5) mangelhaft: '. $myClassAvg["mangelhaft"].'<hr/>';
echo  '(6) ungenügend: '. $myClassAvg["ungenügend"].'<hr/>';
echo 'Schnitt: <b>'. getGrade($myClassAvg["points"],$myClassAvg["maxpoints"]).'</b>';

 echo '</body></html>';
//var_dump( $myObject->data[0]->id); 

?>
