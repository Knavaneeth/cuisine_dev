<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
      <meta charset="utf-8">
      <title>Cuisine -- Directions for Delivery Drivers</title>
      <style>
         /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
         #map {
         height: 100%;
         }
         /* Optional: Makes the sample page fill the window. */
         html, body {
         height: 100%;
         margin: 0;
         padding: 0;
         }
         #floating-panel {
         position: absolute;
         top: 10px;
         left: 25%;
         z-index: 5;
         background-color: #fff;
         padding: 5px;
         border: 1px solid #999;
         text-align: center;
         font-family: 'Roboto','sans-serif';
         line-height: 30px;
         padding-left: 10px;
         }
         #warnings-panel {
         width: 100%;
         height:10%;
         text-align: center;
         }
         #order_details {
         box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.07);
         font-family: Roboto;
         font-size: 14px;
         padding: 10px;
         }
         .ahref_button {
         display: inline-block;
         width: 115px;
         height: 20px;
         background: #009688;
         padding: 10px;
         text-align: center;
         border-radius: 5px;
         color: white;
         font-weight: bold;
         text-decoration:  none;
         }
         .center_content {
         margin: auto;
         width: 60%;
         /* border: 3px solid #73AD21; */
         padding: 10px;
         }
      </style>
   </head>
   <body>
      <?php 
         if(isset($_GET['id'])&&!empty($_GET['id'])&&is_numeric($_GET['id']))
         {
            $order_id = $_GET['id'];
         }
         $db_ext=new DbExt;
         $stmt = "SELECT oda.`location_name`,oda.`street`,oda.`city`,oda.`state`,oda.`country` , (SELECT `option_value` FROM `mt_option` WHERE `option_name` LIKE '%merchant_latitude%' AND `merchant_id` = mt_order.	merchant_id) as merchant_latitude, (SELECT `option_value` FROM `mt_option` WHERE `option_name` LIKE '%merchant_longtitude%' AND `merchant_id` = mt_order.	merchant_id) as merchant_longtitude , mt_merchant.street as merchant_street,mt_merchant.city as merchant_city,mt_merchant.state as merchant_state,mt_merchant.parish as merchant_parish ,mt_merchant.post_code as merchant_postcode
			 FROM  `mt_order_delivery_address` as oda
			 LEFT JOIN mt_order ON mt_order.order_id = oda.order_id
			 LEFT JOIN mt_merchant ON mt_merchant.merchant_id = mt_order.merchant_id
			 WHERE  oda.`order_id` = ".$order_id;
        

         if($res=$db_ext->rst($stmt))
         {      
            /*  echo "<pre>";
              print_r($res[0]);
              echo "</pre>";  */
         	   $dataFromTheForm = $res[0]['street'];		             
         	   if(isset($res[0]['location_name'])&&!empty($res[0]['location_name']))
         	   {
         	   		$dataFromTheForm = $res[0]['location_name'];	
         	   }                 
              
               $rCount = 1;
               $aField = $_GET['field'];
               $asc = $_GET['sort'];
         
               $client = new SoapClient('http://caf.digimap.je/API2/Service.asmx?wsdl');
               $response = $client->Search(array(
                     'apiKey' => 'aich2Quahnei',
                     'addressField' => 'GlobalSearch',
                     'searchText' => $dataFromTheForm,
                     'includeHistoric' => 'false',
                     'includeInactive' => 'false',
                     'useMetaphone' => 'false',
                     'sortBy' => 'AddressToString',
                     'sortDescending' => 'true',
                     'classifications' => 'string',
                     'fromIndex' => '0',
                     'maxResults' => $rCount
                 ));                  
                 if(isset($response->SearchResult->AddressList->Address))
                   {
                     $longitude = $response->SearchResult->AddressList->Address->Lon;
                     $latitude  = $response->SearchResult->AddressList->Address->Lat; 
         
                     $door_no = $response->SearchResult->AddressList->Address->SubElementDesc;
                     $BuildingName = $response->SearchResult->AddressList->Address->BuildingName;
                     $RoadName = $response->SearchResult->AddressList->Address->RoadName;
                     $Parish = $response->SearchResult->AddressList->Address->Parish;
                     $Island = $response->SearchResult->AddressList->Address->Island;
                     $PostCode = $response->SearchResult->AddressList->Address->PostCode; 
                     $full_address = $door_no." , ".$BuildingName." , ".$RoadName." , ".$Parish." , ".$Island." , ".$PostCode ;
                     $to_address = $latitude." , ".$longitude ;
                   }
                   else
                   {
                       $dataFromTheForm = $res[0]['street'];  
                       $rCount = 1;
                       $aField = $_GET['field'];
                       $asc = $_GET['sort'];
                 
                       $client = new SoapClient('http://caf.digimap.je/API2/Service.asmx?wsdl');
                       $response = $client->Search(array(
                             'apiKey' => 'aich2Quahnei',
                             'addressField' => 'GlobalSearch',
                             'searchText' => $dataFromTheForm,
                             'includeHistoric' => 'false',
                             'includeInactive' => 'false',
                             'useMetaphone' => 'false',
                             'sortBy' => 'AddressToString',
                             'sortDescending' => 'true',
                             'classifications' => 'string',
                             'fromIndex' => '0',
                             'maxResults' => $rCount
                         ));                  
                         if(isset($response->SearchResult->AddressList->Address))
                           {
                             $longitude = $response->SearchResult->AddressList->Address->Lon;
                             $latitude  = $response->SearchResult->AddressList->Address->Lat; 
                 
                             $door_no = $response->SearchResult->AddressList->Address->SubElementDesc;
                             $BuildingName = $response->SearchResult->AddressList->Address->BuildingName;
                             $RoadName = $response->SearchResult->AddressList->Address->RoadName;
                             $Parish = $response->SearchResult->AddressList->Address->Parish;
                             $Island = $response->SearchResult->AddressList->Address->Island;
                             $PostCode = $response->SearchResult->AddressList->Address->PostCode; 
                             $full_address = $res[0]['location_name'].",".$res[0]['street'].",". $res[0]['city'].",".$res[0]['state'].",".$res[0]['country'] ;
                             $to_address = $latitude." , ".$longitude ;
                           }
                   }   
         			
         			$merchant_latitude   = $res[0]['merchant_latitude'];		
         			$merchant_longtitude = $res[0]['merchant_longtitude'];

              $from_address = $merchant_latitude." , ".$merchant_longitude ;
               
         			if($merchant_latitude||$merchant_longtitude=='')
         			{


         		       $dataFromTheForm = $res[0]['merchant_street'];		             
                   // echo $dataFromTheForm;
			         	   if(!isset($res[0]['merchant_city'])||empty($res[0]['merchant_city']))
			         	   {
			         	   		$dataFromTheForm = $res[0]['merchant_city'];	
			         	   }                 
			               $rCount = 1;
			               $aField = $_GET['field'];
			               $asc = $_GET['sort'];
			         
			               $client = new SoapClient('http://caf.digimap.je/API2/Service.asmx?wsdl');
			               $response = $client->Search(array(
			                     'apiKey' => 'aich2Quahnei',
			                     'addressField' => 'GlobalSearch',
			                     'searchText' => $dataFromTheForm,
			                     'includeHistoric' => 'false',
			                     'includeInactive' => 'false',
			                     'useMetaphone' => 'false',
			                     'sortBy' => 'AddressToString',
			                     'sortDescending' => 'true',
			                     'classifications' => 'string',
			                     'fromIndex' => '0',
			                     'maxResults' => $rCount
			                 ));  
			                 if(isset($response->SearchResult->AddressList->Address))
			                   {
			                     $merchant_longitude = $response->SearchResult->AddressList->Address->Lon;
			                     $merchant_latitude  = $response->SearchResult->AddressList->Address->Lat; 
			         
			                     $merchant_door_no = $response->SearchResult->AddressList->Address->SubElementDesc;
			                     $merchant_BuildingName = $response->SearchResult->AddressList->Address->BuildingName;
			                     $merchant_RoadName = $response->SearchResult->AddressList->Address->RoadName;
			                     $merchant_Parish = $response->SearchResult->AddressList->Address->Parish;
			                     $merchant_Island = $response->SearchResult->AddressList->Address->Island;
			                     $merchant_PostCode = $response->SearchResult->AddressList->Address->PostCode; 
			                     $merchant_full_address = $merchant_door_no." , ".$merchant_BuildingName." , ".$merchant_RoadName." , ".$merchant_Parish." , ".$merchant_Island." , ".$merchant_PostCode ;
			                     $from_address = $merchant_latitude." , ".$merchant_longitude ;
			                   }   
         			}

         }
          ?>
      <div id="order_details" >
         Order id: #
         <b>
         <?php echo $order_id; ?>
         </b>
         <br />
         Name : 
         <b>
         <?php echo $client_name ?>
         </b>
         <br />
         Address : 
         <b>
         <?php echo $full_address; ?>
         </b>
         <br />
         <div id="contact_details"> Contact No : 
            <b>
            <?php echo $contact; ?>
            </b>
         </div>

         <div id="maps_ditance">
           
         </div>
         <div id="maps_duration">
           
         </div>
         <div class="center_content">
            <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo $from_address; ?>&destination=<?php echo $to_address; ?>&travelmode=DRIVING" target="_blank" class="ahref_button"> Start Navigation </a>
         </div>
      </div>
      <div id="floating-panel" style="display:none;">
         <b>Start: </b>
         <select id="start">
            <option value="<?php echo $from_address; ?>"> <?php echo $from_address; ?>
            </option>
         </select>
         <b>End: </b>
         <select id="end">
            <option value="<?php echo $to_address; ?>"> <?php echo $to_address; ?>
            </option>
         </select>
      </div>
      <div id="map"></div>
      &nbsp;
      <div id="warnings-panel"></div>
      <script>
         function initMap() {
           var markerArray = [];
         
           // Instantiate a directions service.
           var directionsService = new google.maps.DirectionsService;
         
           // Create a map and center it on JERSEY.
           var map = new google.maps.Map(document.getElementById('map'), {
             zoom: 13,
             center: {lat: 49.217231, lng: -2.140589}
           });
          



           //*********DISTANCE AND DURATION**********************//
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [document.getElementById('start').value],
                destinations: [document.getElementById('end').value],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.IMPERIAL,
                avoidHighways: false,
                avoidTolls: false
            }, function (response, status) {
                if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
                    var distance = response.rows[0].elements[0].distance.text;
                    var duration = response.rows[0].elements[0].duration.text;
                    var dvDistance = document.getElementById("dvDistance");
                  /*  dvDistance.innerHTML = "";
                    dvDistance.innerHTML += "Distance: " + distance + "<br />";
                    dvDistance.innerHTML += "Duration:" + duration; */                     
                    document.getElementById("maps_ditance").innerHTML = "Distance : " + distance;
                    document.getElementById("maps_duration").innerHTML = "Duration :" + duration;                                         
                } else {
                    alert("Unable to find the distance via road.");
                }
            });


           // Create a renderer for directions and bind it to the map.
           var directionsDisplay = new google.maps.DirectionsRenderer({map: map});
         
           // Instantiate an info window to hold step text.
           var stepDisplay = new google.maps.InfoWindow;
         
           // Display the route between the initial start and end selections.
           calculateAndDisplayRoute(
               directionsDisplay, directionsService, markerArray, stepDisplay, map);
           // Listen to change events from the start and end lists.
           var onChangeHandler = function() {
             calculateAndDisplayRoute(
                 directionsDisplay, directionsService, markerArray, stepDisplay, map);
           };
           document.getElementById('start').addEventListener('change', onChangeHandler);
           document.getElementById('end').addEventListener('change', onChangeHandler);
         }
         
         function calculateAndDisplayRoute(directionsDisplay, directionsService,
             markerArray, stepDisplay, map) {
           // First, remove any existing markers from the map.
           for (var i = 0; i < markerArray.length; i++) {
             markerArray[i].setMap(null);
           }
         	/* alert(document.getElementById('start').value);
         	alert(document.getElementById('end').value); */
           // Retrieve the start and end locations and create a DirectionsRequest using
           // WALKING directions.
           directionsService.route({
             origin: document.getElementById('start').value,
             destination: document.getElementById('end').value,
             travelMode: 'DRIVING'
           }, function(response, status) {
             // Route the directions and pass the response to a function to create
             // markers for each step.
             if (status === 'OK') {
               document.getElementById('warnings-panel').innerHTML ='<b>' + response.routes[0].warnings + '</b>';
               directionsDisplay.setDirections(response);
               showSteps(response, markerArray, stepDisplay, map);
             } else {
               window.alert('We are unable to locate on the map. Please call the customer or use other means to find the address.');
             }
           });
         }
         
         function showSteps(directionResult, markerArray, stepDisplay, map) {
           // For each step, place a marker, and add the text to the marker's infowindow.
           // Also attach the marker to an array so we can keep track of it and remove it
           // when calculating new routes.
           var myRoute = directionResult.routes[0].legs[0];
           for (var i = 0; i < myRoute.steps.length; i++) {
             var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
             marker.setMap(map);
             marker.setPosition(myRoute.steps[i].start_location);
             attachInstructionText(
                 stepDisplay, marker, myRoute.steps[i].instructions, map);
           }
         }
         
         function attachInstructionText(stepDisplay, marker, text, map) {
           google.maps.event.addListener(marker, 'click', function() {
             // Open an info window when the marker is clicked on, containing the text
             // of the step.
             stepDisplay.setContent(text);
             stepDisplay.open(map, marker);
           });
         }
         
         
         function viewTaskDirection() {
         merchant_latitude = getStorage("merchant_latitude");
         merchant_longtitude = getStorage("merchant_longtitude");
         
         navigator.geolocation.getCurrentPosition( function(position) {
         
             //var your_location = new plugin.google.maps.LatLng(parseFloat(position.coords.latitude) ,parseFloat(position.coords.longitude));
         var your_location=(position.coords.latitude+","+position.coords.longitude);
         
             //var yourLocation = new plugin.google.maps.LatLng(34.039413 , -118.25480649999997);
         
              //var destination_location = new plugin.google.maps.LatLng(parseFloat(merchant_latitude) ,parseFloat( merchant_longtitude));
             var destination_location=(merchant_latitude+","+merchant_longtitude);
         //from the new plugin for launching the navigation
         launchnavigator.navigate(destination_location, {
         start: your_location
         });
         
          // end position success
          }, function(error){
          
          // end position error
          },
          { timeout: 10000, enableHighAccuracy : getLocationAccuracy() }
         );
         
         }
         
                 
           
      </script>
      <script async defer
         src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAspbfu1o8_mGN_hWDah_YTqXdXiPg6DkE&callback=initMap"></script>
   </body>
</html>