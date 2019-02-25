<?php 

function calculate ($expression) {
  	if (is_array($expression)) {	
		if (is_array(array_validate($expression))) {
				$expression=array_validate($expression);
				print_r($expression);

	  			for ($i=0; $i < count($expression); $i++) { 				
	  				if(preg_match('/[\+\-\*\/]/', $expression[$i])){
						$expression[$i]=do_math($expression[$i-2],$expression[$i],$expression[$i-1]);					
						unset($expression[$i-1],$expression[$i-2]);
						$expression=array_values($expression);
						calculate($expression);	
						break;				
	  				}
				}			
  		}elseif(array_validate($expression)==TRUE){
			//check final output expression, should be sized as 1   
	  		if(count($expression)==1){
	  			$expression=implode("", $expression);
	  			echo (float)$expression;
	  			return (float)$expression;
	  		}	
	  		print_r($expression);
  			echo "Script ended with ". print_r($expression)." expression";
		  	exit;
			}
			
	}
	elseif(!is_array($expression)) {	
		if(!is_string($expression)){
			echo "failed expression";
			exit();
		}
		if(strlen($expression)<=1){
			echo "expression is too short";
			exit();
		}
		
		$expression=explode(" ", $expression);
		calculate($expression);
	}
	


}

function array_validate($raw_array){
	//handling character " " as multiplication
	for ($i=0; $i < count($raw_array); $i++) { 
		if (strlen($raw_array[$i])<=0){ $raw_array[$i]="*";}
	}
	//handling expression with no operators as multiplication
	if (count($raw_array)>=2 && !preg_match('/[\+\-\*\/]/', $raw_array[count($raw_array)-1])) {
		$raw_array[count($raw_array)]="*";
	}
	//handling incorrect expression
	if(!is_numeric($raw_array[0])||!is_numeric($raw_array[1])||count($raw_array)<2){
		return TRUE;
	}
	return $raw_array;	
}

function do_math($raw_operand_1,$raw_operator,$raw_operand_2){
switch ($raw_operator) {
    case '+':
        return (float)$raw_operand_1+(float)$raw_operand_2;
    case '-':
        return (float)$raw_operand_1-(float)$raw_operand_2;
    case '*':
        return (float)$raw_operand_1*(float)$raw_operand_2;
    case ' ':
        return (float)$raw_operand_1*(float)$raw_operand_2;
    case '/':
    	return (float)$raw_operand_1/(float)$raw_operand_2;
}
}

calculate ('5 1 2 + 4 * + 3 -');

 ?>