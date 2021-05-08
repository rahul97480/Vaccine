<?php
function callAPI($method, $url, $data){
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   
   return $result;
}

$result = callAPI('GET', 'https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByPin?pincode=711204&date='. date("d-m-Y"), false);
$json = json_decode($result, true);

for($i=0;$i<=10;$i++){
   if(array_key_exists($i,$json['centers'])){
      if($json['centers'][$i]['sessions'][0]['min_age_limit'] == 45){ //change to 18
         if($json['centers'][$i]['sessions'][0]['available_capacity'] == 0 ){ //change to greate than 0 
            echo "<h1><centre>Vacccine Available in Hospital " . $json['centers'][$i]['name'] . " at " . $json['centers'][$i]['address'] . " vaccine " .  $json['centers'][$i]['sessions'][0]['vaccine'] ;
            echo "<audio id='audioBox'>
            <source src='song.wav' type='audio/wav'/>
         </audio>";
         echo "<script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
         <script>
            setInterval(function(){
            load();
         },3000);
         function load(){
            jQuery.ajax({
               url:'get.php',
               success:function(result){
                  var data=jQuery.parseJSON(result);
                  if(data.sound=='yes'){
                     jQuery('#audioBox')[0].play();
                  }
               }
            });
         }</script>";
         }
      }
   }
}


?>
