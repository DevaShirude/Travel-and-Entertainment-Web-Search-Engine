<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html;
charset=ISO-8859-1">
 <head> <title hidden> Assignment 6 </title></head>

    <?php

    $keyword = $category = $user_entered_location = $here_location = $location_to_search_for = $search_result = $place_id="";
    $jsonObj2 = $search_result="";
    error_reporting(E_ALL & ~E_NOTICE);


    function getUserLocationFromGeoEncoding($user_entered_location, $here_location){

        $key = "AIzaSyCQW4VI0NUiYGGl1ALco25AZS0Z_iHRF6E";
        $key = urlencode($key);
        $user_entered_location = urlencode($user_entered_location);

        
        if($user_entered_location != "") {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$user_entered_location&key=$key";
            //echo $url;
            $jsonObj = file_get_contents($url);
            $jsonObj2 = json_decode($jsonObj);
            $lat = $jsonObj2->results[0]->geometry->location->lat;
            $lng = $jsonObj2->results[0]->geometry->location->lng;
            //$GLOBALS['place_id'] = $jsonObj2->results[0]->place_id;
            return $lat.",".$lng;
        }
        else {
            return $here_location;
        }
    }

    function LocationSearch($location_to_search_for, $distance, $category, $keyword){
        $key = "AIzaSyCQW4VI0NUiYGGl1ALco25AZS0Z_iHRF6E";
        $key = urlencode($key);
        if($distance==0) $distance=10 * 1609.34;
        //if ($_SERVER["REQUEST_METHOD"] == "POST") {$distance = $_POST['distance'] * 1609.34;}
        //$distance = urlencode($distance);
        /*if ($category="Movie Theatre") $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location_to_search_for&radius=$distance&type=".movie_theater."&keyword=$keyword&key=$key";
        else if ($category="Subway Station") $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location_to_search_for&radius=$distance&type=".subway_station."&keyword=$keyword&key=$key";  
         else if ($category="Bus Station") $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location_to_search_for&radius=$distance&type=".bus_station."&keyword=$keyword&key=$key";
         else if ($category="Train Station") $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location_to_search_for&radius=$distance&type=".train_station."&keyword=$keyword&key=$key"; 
         
            else*/
        $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location_to_search_for&radius=$distance&type=$category&keyword=$keyword&key=$key";
        //echo $url;
        $search_response = file_get_contents($url);
        //echo $search_response;
        $try = json_decode($search_response);

        return $search_response;
    }

        if (isset($_GET['place_id']))
        {
        // $jsonObj3 = json_decode($search_response);

        $key = "AIzaSyCQW4VI0NUiYGGl1ALco25AZS0Z_iHRF6E";
         $key = urlencode($key);
         if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $place_id = $_GET['place_id'];}
        // $placeid = $jsonObj3->results[0]->place_id;
    //echo $GLOBALS['place_id'];
        //call google api place_id for gettiong phto_refs for each photo_refs call api to fetch photos store on server
    $url2 = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$place_id&key= $key";
    $search_response2 = file_get_contents($url2);

    echo $search_response2;
    $search2 = json_decode($search_response2);
    $numphotos = sizeof($search2->results[0]->photos);
    if($numphotos>5) $numphotos=5;
    for($d = 0; $d <$numphotos; $d ++)
    {
    $photo_ref = $search2->results[0]->photos[$d]->photo_reference;

    $url3 = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference=$photo_ref&key=$key";
      $photoname = "image".$photo_ref.".png";
      file_put_contents($photoname, file_get_contents($url3));
    }
    //$search_response3 = file_put_contents(filename, data);
    echo $search_response2;
    die();
}
    

    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $keyword = $_POST['keyword']; 
        $here_location = $_POST['hidden_here_locale'];
        $user_entered_location = $_POST['user_entered_location'];
        $category = $_POST['category'];
        $distance = $_POST['distance'] * 1609.34;
        $location_to_search_for = getUserLocationFromGeoEncoding($user_entered_location, $here_location);
        $search_result = LocationSearch($location_to_search_for, $distance, $category, $keyword);
        //$search_result2 = DisplayPR($search_response);
    }

    ?>

    <script type="text/javascript">

        
        

        function getTable(search_result){
            if(search_result == "")
                return;
            var icon = "", vicinity = "", name = "";
            var json_object = JSON.parse(search_result);
            var json_results = json_object["results"];

            if(json_results.length<1)
            {
                myTable = "";
            myTable += '<table border ="1 solid black"  width = "100%"><tr><th>No Records have been found!</th></tr></table>';

            document.getElementById("displayTable").innerHTML = myTable;
            }

            else
            {
            var myTable = "<table border = '1 solid black' ><tr><th>Category</th><th>Name</th><th>Address</th></tr>";
            for (var i = 0; i < json_results.length; i++) {
                myTable += "<tr><td> <img  src=" + json_results[i]['icon'] + "></td><td><span onClick=\"PhotosAndReviews()\" style=\"cursor: pointer;\">"
                            + json_results[i]['name'] + "</span></td><td>" + json_results[i]['vicinity'] + "</td></tr>";
            }

            myTable += "</table>";
            document.getElementById("displayTable").innerHTML = myTable;
        }

      

    }

    function sayhi()
    {
        alert("hi");
    }

        function PhotosAndReviews(){
            var place_id = "ChIJddwOWuLHwoARFZlsBjrcY2E";
            alert("HIII");
            document.getElementById("displayTable").innerHTML = "";
           // var xyz = <?php //echo $search_result2 ?>;
            var xmlHttp = new XMLHttpRequest();
            /*xmlHttp.onreadystatechange = function()
            {
                
               if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    user_entered_location="";
                    user_lat = JSON.parse(xmlHttp.responseText).lat;
                    user_long = JSON.parse(xmlHttp.responseText).lon;
                    document.getElementById("search_button").disabled = false;
                    document.getElementById("hidden_here_location").value = user_lat.toString() + "," + user_long.toString();
                    
                }
            }*/
            xmlHttp.open( "GET", "place2.php?place_id="+place_id, true); 
            xmlHttp.send( null );
            var xyz = JSON.parse(xmlHttp.responseText);
            var user_entered_location="";
            

            var temp2 = xyz.result.reviews[0].text;
            alert(temp2);

            for (var k = 0; k < 5; k++) {
                myTable += "<tr><td> <img  src=" + temp2[k]['photos'] + "</td></tr>";
            }
                document.getElementById("displayTable").innerHTML = myTable ;

                return xmlHttp.responseText;

        }

        function setdisable()
     {
      document.getElementById("user_entered_location").disabled=true;
     }
     function setenable()
     {
      document.getElementById("user_entered_location").disabled=false;
     }

        function getCurrLocation(){
            var xmlHttp = new XMLHttpRequest();
            var user_lat = "", user_long = "";

            xmlHttp.onreadystatechange = function()
            {
                
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                {
                    user_entered_location="";
                    user_lat = JSON.parse(xmlHttp.responseText).lat;
                    user_long = JSON.parse(xmlHttp.responseText).lon;
                    document.getElementById("search_button").disabled = false;
                    document.getElementById("hidden_here_location").value = user_lat.toString() + "," + user_long.toString();
                    
                }
            }
            xmlHttp.open( "GET", "http://ip-api.com/json", true); 
            xmlHttp.send( null );
            var user_entered_location="";
            return xmlHttp.responseText;
        }

        /*function ValueRetain(keyword)
        {
            var a1 = "<?php echo $keyword ?>";
            document.getElementById("keyword").innerHTML = a1 ;
        }*/
        
        function resetForm(form) {
    // clearing inputs
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i<inputs.length; i++) {
        switch (inputs[i].type) {
            // case 'hidden':
            case 'text':
                inputs[i].value = '';
                break;
            case 'radio':
            case 'checkbox':
                inputs[i].checked = false;   
        }
    }

    // clearing selects
    var selects = form.getElementsByTagName('select');
    for (var i = 0; i<selects.length; i++)
        selects[i].selectedIndex = 0;

    // clearing textarea
    var text= form.getElementsByTagName('textarea');
    for (var i = 0; i<text.length; i++)
        text[i].innerHTML= '';

    //myTable.innerHTML="";



    return false;
}


    </script>

</head>
<body onload="getCurrLocation()">

<center><fieldset style="width: 600px;">
    <h2><i>Travel and Entertainment Search</i></h2><hr>
<form method="post" id="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    
        <b>Keyword</b> <input type="text" name="keyword" id="keyword" required value="<?php  if(isset($keyword)) echo $keyword?>">
   
    <br>
    <b>Category</b>
            <select name = "category"  value="<?php echo selected;?>">
  <option value="<?php  if(isset($category)) echo 'selected'?>">default</option>
  <option value="<?php  if(isset($_POST[$category])) echo $category?>">Cafe</option>
        <option value="bakery" name="category">Bakery</option>
  <option value="restaurant" name="category">Restaurant</option>
  <option value="beauty_salon" name="category">Beauty Salon</option>
  <option value="casino" name="category">Casino</option>
    <option value="movie_theater" name="category">Movie Theatre</option>
    <option value="lodging" name="category">Lodging</option>
    <option value="airport" name="category">Airport</option>
    <option value="train_station" name="category">Train Station</option>
    <option value="subway_station" name="category">Subway Station</option>
    <option value="bus_station" name="category">Bus Station</option>
</select>
    <br><br>
    <b>Distance (miles)</b> <input type="text"  name="distance" placeholder="10" value="<?php  if(isset($distance)) echo ($distance/1609.34)?>">
    <b>from</b>



    <input type="radio" checked id = "radio" onclick="setdisable()" name="location" value="here">
    <input id="hidden_here_location" name="hidden_here_locale" type="hidden"  >
    Here
    <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="location" id= "radio" onclick="setenable()" value="user_entered_location">
         <input type="text" id="user_entered_location" disabled name="user_entered_location" placeholder="location"  required  value="<?php  if(isset($user_entered_location)) echo $user_entered_location?>" >
    
    <br><br>
    <button type="submit" id="search_button" value="Search"  >Search</button>
    <button value="Reset" type="reset" onclick="return resetForm(this.form); ">Reset</button>
</form>
</fieldset></center>
<div id="displayTable"> </div>

<script type="text/javascript">

    

    var search_result = <?php echo json_encode($search_result, JSON_HEX_TAG); ?>;
    getTable(search_result);
    

</script>


</body>
</html>