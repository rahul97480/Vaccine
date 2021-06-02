

<?php

  $ch = curl_init('https://coderbyte.com/api/challenges/json/age-counting');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $data = curl_exec($ch);
  curl_close($ch);

  $json = (json_decode($data, true));
  //echo '<pre>';
  	$arr = explode(",",$json['data']);
  	$n = count($arr);
  	$flag = 0;
  	for($i=1;$i<=$n;$i+=2){
  		if(array_key_exists($i,$arr)){
  			$age_data = explode("=",$arr[$i]);
  			if($age_data[1]>50){
  				$flag++;	
  			};
  		}
  	}
  	echo $flag;

 	


?>
