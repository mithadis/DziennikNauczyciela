<?php

function table($resultData){
	
	$table = '<table>';
	
	$row = mysql_fetch_array($resultData);
	
	$columnNames = array_keys($row);
	$thead = '<thead>';
	for($i = 1 ; $i < sizeof($columnNames); $i+=2){
		$thead.='<td>';
		$thead.=$columnNames[$i];
		$thead.='</td>';
	}
	$thead.='</thead>';
	
	$table .= $thead;
	$i = 1;
	while($row != ''){
	
		$table .= '<tr class="'.oddEven($i).'">';
		for($j = 0; $j < sizeof($row)/2; $j++){
			$table .= '<td>';
			$table .= $row[$j];
			$table .= '</td>';
		}
		$table .= '</tr>'; 
		
		$row = mysql_fetch_array($resultData);
	}
	$table .= '</table>';
	
	
	return $table;
}


function oddEven(&$i){

	$toRet = '';
	if($i%2 == 0){
		$toRet = 'odd';
	}else{
		$toRet = 'even';
	}
	$i++;
	return $toRet;
}