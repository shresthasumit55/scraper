<?php
require_once 'login.php';

function tokenizer($input)
{
	$input=strtolower($input);
	$input=strip_tags($input);
	$input=preg_replace('/\s+/',' ',$input);
	$input=preg_replace('/[^-A_Za-z0-9\s]/','',$input);
	return explode(' ',$input);

}


$search = $_GET [ 'search' ]; 

   if( strlen( $search )< 1 ) 
   	echo "No query!"; 
   else 
   	{

   	
   	 echo "You searched for <b> $search </b> <hr size='1' > </ br > "; 
   	 mysql_connect ( $servername, $username, $password) ;
	    mysql_select_db ($dbname);

	$tokens=tokenizer($search);
	
	$count=0;
	$result = "";
	foreach($tokens as $token_each)
	{
	$count++;
		
	if($count==1)
		$result .= "`title` LIKE '%$token_each%'";
	else
		$result .= " AND `title` LIKE '%$token_each%'";
	}
	
	
	
	$result= "SELECT `title`, `price` ,`id` FROM `Products_kaymu` WHERE $result";
				 
   
   
   $run=mysql_query($result);
   
   $num_rows=mysql_num_rows($run);
   
   
   if ($num_rows == 0)
   	echo "Sorry no result found";	
   	
   else
   	{

   	for($j=0;$j < $num_rows; ++$j)
   	{
   		$row=mysql_fetch_row($run);

   		echo "<a href="."display.php?id='$row[2]'".">$row[0]</a>";
   		echo "<br><br>";
   	}
    		

   }
}



?>
