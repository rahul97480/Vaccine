<head><meta content='10' http-equiv='refresh'/></head>
<?php
function callAPI($method, $url){
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   
   return $result;
}


function startSound($json){
   $size = sizeof($json['centers']);
   for($i=0;$i<$size;$i++){
      $size_session = sizeof($json['centers'][$i]['sessions']);
      for($j=0;$j<$size_session;$j++){
          if($json['centers'][$i]['sessions'][$j]['min_age_limit'] == 18){
            if($json['centers'][$i]['sessions'][$j]['available_capacity_dose1'] > 0 ){
               echo "<center><h3>Vacccine Available in Hospital " . $json['centers'][$i]['name'] . " at " . $json['centers'][$i]['address'] . " vaccine " .  $json['centers'][$i]['sessions'][$j]['vaccine'] . "  DATE  ". $json['centers'][$i]['sessions'][$j]['date'] ."</h3></center>" ;

               $con=mysqli_connect('localhost','root','','Vaccine');

               $center_name =  $json['centers'][$i]['name'];
               $address =  $json['centers'][$i]['address'];
               $vaccine =  $json['centers'][$i]['sessions'][$j]['vaccine'];
               $age = $json['centers'][$i]['sessions'][$j]['min_age_limit'];
               $vaccine_date = $json['centers'][$i]['sessions'][$j]['date'];
               date_default_timezone_set("Asia/Kolkata");
               $date = date("Y-m-d h:i:sa");

               $con=mysqli_connect('localhost','root','','Vaccine');

               $sql = "INSERT INTO info (center_name, address, vaccine, age, vaccine_date, exact_time) VALUES ('$center_name', '$address', '$vaccine', '$age', '$vaccine_date','$date')";
               $res=mysqli_query($con,$sql);
               


               echo "<audio id='audioBox'><source src='song.wav' type='audio/wav'/></audio>";
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
}

$result1 = callAPI('GET', 'https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByDistrict?district_id=721&date='.date("d-m-y"));
$json = json_decode($result1, true);
// echo "<pre>";
// print_r($json);
startSound($json);

?>