<?php 
	
	 

   			    
         	   $dataFromTheForm = $_GET['address'];	  
             // echo  $dataFromTheForm ;      	                    
         	   $address_string = explode(',', $dataFromTheForm);              
         	   $form_address = '';         	    
         	   for($i=0;$i<1;$i++) 
         	   {
         	   	 $form_address .= trim($address_string[$i])." ";
         	   }         	    
               $rCount = 1;
               $aField = $_GET['field'];
               $asc = $_GET['sort'];
         
               $client = new SoapClient('http://caf.digimap.je/API2/Service.asmx?wsdl');
               // echo $form_address;
               $response = $client->Search(array(
                     'apiKey' => 'aich2Quahnei',
                     'addressField' => 'GlobalSearch',
                     'searchText' => $form_address,
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

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Location Viwer</title>
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
    </style>
  </head>
  <body>
    <div id="map"></div>
    <input type="hidden" name="latitude" id="latitude" value="<?php echo $latitude; ?>">
    <input type="hidden" name="longitude" id="longitude" value="<?php echo $longitude;  ?>" >
    <input type="hidden" name="full_address" id="full_address" value="<?php echo $full_address;  ?>" >
    <script>
    var latitude = document.getElementById('latitude').value ;
    var longitude = document.getElementById('longitude').value;
    var full_address = document.getElementById('full_address').value;
    // alert(latitude + "    " +longitude);

      function initMap() {
        var myLatLng = {lat: parseFloat(latitude), lng: parseFloat(longitude) };

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: full_address
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf7EQf078t_wh9AzGCrMHZXVj2aIZPJ-8&callback=initMap">
    </script>
  </body>
</html>