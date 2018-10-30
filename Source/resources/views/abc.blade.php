<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <h1 class="text-center">Hello World</h1>

        <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
        <div id="map"></div>
        <div id="details"></div>

        <script type="text/javascript">
            function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 41.9030632,
            lng: 12.466275999999993
        },
        zoom: 13
    });

    var input = document.getElementById('pac-input');

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map
    });
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        // Set the position of the marker using the place ID and location.
        marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location
        });
        marker.setVisible(true);

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
            'Place ID: ' + place.place_id + '<br>' +
            place.formatted_address);
        infowindow.open(map, marker);

        var service = new google.maps.places.PlacesService(map);
        
        var details_container = document.getElementById('details');
        
        service.getDetails({
            placeId: place.place_id
        }, function(place, status) {
            details_container.innerHTML = '<p><strong>Status:</strong> <code>' + status + '</code></p>' +
                '<p><strong>Place ID:</strong> <code>' + place.place_id + '</code></p>' +
                '<p><strong>Location:</strong> <code>' + place.geometry.location.lat() + ', ' + place.geometry.location.lng() + '</code></p>' +

                '<p><strong>Formatted address:</strong> <code>' + place.formatted_address + '</code></p>' +
                '<p><strong>GMap Url:</strong> <code>' + place.url + '</code></p>' +
                '<p><strong>Place details:</strong></p>' +
                '<pre>' + JSON.stringify(place, null, " ") + '</pre>';

        });

    }); // end autocomplete addListener
}
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnR7YAAG83jkhURYhrUkKbOfGDqA2BTqw&callback=initMap&libraries=places&sensor=false"></script>

        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
    </body>
</html>