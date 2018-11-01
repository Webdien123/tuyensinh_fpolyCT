// Khởi tạo bảng đồ sau khi page load xong.
window.onload = initMap;

// Biến lưu vị trí đang hiển thị trên map.
var selected_position = null;

// Biến lưu maker hiển thị kết quả tìm kiếm.
var find_maker = null;

// Mảng lưu tọa độ tất cả các vị trí marker trên map.
var arr_maker = [];

// Hàm kiểm tra vị trí cần search đã có marker hay chưa.
function isLocationFree(search) {
  for (var i = 0, l = arr_maker.length; i < l; i++) {
    if (arr_maker[i][0] === search[0] && arr_maker[i][1] === search[1]) {
      return false;
    }
  }
  return true;
}

// Hàm tạo button đánh dấu cờ.
function MakerControl(controlDiv, map) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginRight = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click để đánh dấu vị trí';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '30px';
    controlText.style.paddingLeft = '8px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = '<img src="/img/btn_maker.png">';
    controlUI.appendChild(controlText);

    // Xử lý đánh dáu cờ khi click nút.
    controlUI.addEventListener('click', function() {

        search = [selected_position.lat(), selected_position.lng()];
        is_free = isLocationFree(search);
        if (is_free) {
            // Tùy chỉnh kích thước icon maker.
            var icon = {
                url: "img/maker2.png", // url
                scaledSize: new google.maps.Size(60, 40), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(30, 40) // anchor
            };

            // Tạo maker.
            var marker = new google.maps.Marker({
                position: selected_position,
                icon: icon,
                // icon: "img/maker2.png",
                map: map,
                animation: google.maps.Animation.DROP,
            });

            // console.log("vi tri đánh dấu: ");
            // console.log(marker.getPosition().lat() + " - " + marker.getPosition().lng());

            // Thêm tọa độ marker vào mảng.
            arr_maker.push([selected_position.lat(), selected_position.lng()]);
            // console.log(selected_position.lat()); 
        }
        else {
            alert("Vị trí đã đánh dấu trước đó");
        }
        
    });
}

// Hiển thị về vị trí hiện tại.
function getLocation(map) {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        // var currentLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        // infoWindow.setPosition(pos);
        // infoWindow.setContent('Location found.');
        // infoWindow.open(map);
        selected_position = pos;
        map.setCenter(pos);

        find_maker.setMap(null);

        find_maker = new google.maps.Marker({
            position: pos,
            map: map
        });

        find_maker.setAnimation(google.maps.Animation.BOUNCE);
        
        // find_maker.setPosition(currentLatlng);
        
        // console.log(position);
        // Set lại vị trí của maker hiển thị kết quả.
        // find_maker.setPlace({
        //     placeId: place_id,
        //     location: place.geometry.location,
        // });
        // find_maker.setVisible(true);
      }, function() {
        // handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    // infoWindow.setPosition(pos);
    // infoWindow.setContent(browserHasGeolocation ?
    //                       'Error: The Geolocation service failed.' :
    //                       'Error: Your browser doesn\'t support geolocation.');
    // infoWindow.open(map);
    alert("Loi tim kiem vi tri");
}


// Hàm tạo button về vị trí hiện tại.
function GpsControl(controlDiv, map) {
    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginRight = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Về vị trí hiện tại';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '30px';
    controlText.style.paddingLeft = '2px';
    controlText.style.paddingRight = '2px';
    controlText.style.paddingTop = '2px';
    controlText.style.paddingBottom = '2px';
    controlText.innerHTML = '<img src="/img/gps.png">';

    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to Chicago.
    controlUI.addEventListener('click', function() {
        getLocation(map);
    });
}

// Hàm khởi tạo map cho toàn bộ trang bản đồ tuyển sinh.
function initMap() {
    var mapCanvas = document.getElementById("map");

    var maker_position = new google.maps.LatLng(10.0268264, 105.75735280000004);

    var mapOptions = {
        center: maker_position,
        zoom: 20,
        panControl: true,
        zoomControl: true,
        mapTypeControl: true,
        mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
              position: google.maps.ControlPosition.LEFT_BOTTOM
          },
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: true,
        rotateControl: true      
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);

    // Thêm thanh search bar lên bản đồ.
    var input = document.getElementById('pac-input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(input);

    // Tạo maker hiển thị vị trí tìm kiếm
    find_maker = new google.maps.Marker({
        map: map
    });

    autocomplete.addListener('place_changed', function() {
        // infowindow.close();
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

        selected_position = place.geometry.location;

        // Set lại vị trí của maker hiển thị kết quả.
        find_maker.setMap(null);

        find_maker = new google.maps.Marker({
            position: selected_position,
            map: map
        });

        // console.log("vi tri tim kiem: ");
        // console.log(find_maker.getPosition().lat() + " - " + find_maker.getPosition().lng());
        // find_maker.setPlace({
        //     placeId: place.place_id,
        //     // location: place.geometry.location,
        //     location: new google.maps.LatLng(selected_position.lat(), selected_position.lng()),
        // });
        // find_maker.setVisible(true);
        // find_maker.setAnimation(null);

        // infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
            // 'Place ID: ' + place.place_id + '<br>' +
            // place.formatted_address);
        // infowindow.open(map, marker);

        // var service = new google.maps.places.PlacesService(map);
        
        // var details_container = document.getElementById('details');
        
        // service.getDetails({
        //     placeId: place.place_id
        // }, function(place, status) {
        //     details_container.innerHTML = '<p><strong>Status:</strong> <code>' + status + '</code></p>' +
        //         '<p><strong>Place ID:</strong> <code>' + place.place_id + '</code></p>' +
        //         '<p><strong>Location:</strong> <code>' + place.geometry.location.lat() + ', ' + place.geometry.location.lng() + '</code></p>' +

        //         '<p><strong>Formatted address:</strong> <code>' + place.formatted_address + '</code></p>' +
        //         '<p><strong>GMap Url:</strong> <code>' + place.url + '</code></p>' +
        //         '<p><strong>Place details:</strong></p>' +
        //         '<pre>' + JSON.stringify(place, null, " ") + '</pre>';

        // });

    });
    selected_position = maker_position;

    // Tùy chỉnh kích thước icon maker.
    var icon = {
        url: "img/title_icon.png", // url
        scaledSize: new google.maps.Size(50, 50), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(25, 30) // anchor
    };

    // Tạo maker.
    var marker = new google.maps.Marker({
        position: maker_position,
        icon: icon,
        map: map
    });


    // Thêm button đánh dấu cờ.
    var MakerControlDiv = document.createElement('div');
    var makercontrol = new MakerControl(MakerControlDiv, map);
    MakerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(MakerControlDiv);

    // Thêm button về vị trí hiện tại.
    var GpsControlDiv = document.createElement('div');
    var gpscontrol = new GpsControl(GpsControlDiv, map);
    GpsControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(GpsControlDiv);  
}