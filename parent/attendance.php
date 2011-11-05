<?php

include '../inc/conf.php';

$childId = $_POST['childId'];

mysql_connect(DB_SERVER, DB_LOGIN, DB_PASS) or die('connect');
mysql_query('USE dn') or die('use');
 
$result = mysql_query('SELECT status, uspr, data, id_godziny FROM obecnosci WHERE id_ucznia = ' . $childId) or die ('select');


$table = '<table>';
$i = 1;
while(($row = mysql_fetch_array($result)) != ''){
	
	$table .= '<tr class="'.oddEven($i).'">';
	for($j = 0; $j < sizeof($row); $j++){
		$table .= '<td>';
		$table .= $row[$j];
		$table .= '</td>';
	}
	$table .= '</tr>';
}
$table .= '</table>';

echo $table;



function oddEven(&$i){
		if($i%2){
			return "odd";
		}else{
			return "even";
		}
		$i++;
	}

?>