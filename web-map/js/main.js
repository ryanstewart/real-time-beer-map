var firebase_url = "<YOUR FIREBASE INSTANCE>";
var myFirebase;
var checkinData;
var arrMapMarkers = [];
var counter = 0;

window.onload = init;

function init() {
    var mapOptions = {
          center: { lat: 47.6487245, lng: -122.3506068},
          zoom: 17
    };
    
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    
    myFirebase = new Firebase(firebase_url);
    
    myFirebase.child("checkins").on("child_added", function(snapshot) {
        var lat = snapshot.child("venue/location/lat").val();
        var lng = snapshot.child("venue/location/lng").val(); 
        var latLng = new google.maps.LatLng(lat,lng);
        var marker = new google.maps.Marker({
            position: latLng,
            title: snapshot.child("beer/beer_name").val(),
            animation: google.maps.Animation.DROP
        });
        arrMapMarkers.push(marker);
        marker.setMap(map);
        map.panTo(latLng);
    });
}