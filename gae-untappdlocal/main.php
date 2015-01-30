<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/');

require_once 'untappd/untappd.php';
require_once 'firebase/firebase.php';

$lastUpdatedTime = "";
$checkins = [];

$untappd = new Untappd();
$firebase = new Firebase();

// Get the last updated time
$lastUpdatedTime = $firebase->getUpdateTime();
echo "Last update: " . $lastUpdatedTime . "<br />";

// get the activity since the last update
$activity = $untappd->getBreweryActivity($untappd->guinness);
$array = json_decode($activity, true);

foreach( $array["response"]["checkins"]["items"] as $item ) {
   if(strtotime($item["created_at"]) > strtotime($lastUpdatedTime) && $item["venue"] != []) {
       array_push($checkins, $item);
       print_r($item);
   }
}

//
//// Update the last updated time
//$updateTime = $firebase->pushUpdateTime();
//
//// send it to firebase

foreach($checkins as $item) {
    $checkins_json = json_encode($item);    
    $pushFirebase = $firebase->pushData($checkins_json);
    print_r($pushFirebase);
    sleep(5);
}

// get a brewery
//echo "<pre>";
//print_r(json_decode($untappd->brewerySearch("Fremont"),true));


?>