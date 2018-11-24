// Validate dữ liệu form nhập thông tin địa chỉ.
jQuery(document).ready(function($) {
    $( "#f_update_ddiem" ).validate({
        rules: {
            ten_diadiem: {
                required: true,
                maxlength: 500
            },
            diachi: {
                required: true,
                maxlength: 500
            },
            chiso1: {
                min: 0
            },
            chiso2: {
                min: 0
            },
            ghichu: {
                maxlength: 5
            }
        },

        messages: {
            ten_diadiem: {
                required: "Chưa nhập tên địa điểm",
                maxlength: "Tên địa điểm tối đa 500 kí tự"
            },
            diachi: {
                required: "Chưa nhập địa chỉ",
                maxlength: "Địa chỉ tối đa 500 kí tự"
            },
            chiso1: {
                required: "Chưa nhập địa chỉ"
            },
            chiso2: {
                required: "Chưa nhập địa chỉ"
            },
            ghichu: {
                maxlength: "Ghi chú tối đa 5000 kí tự"                
            }
        },

        errorPlacement: function (error, element) {
            error.css("color", "#FC4848");
            error.addClass('help-block');
            error.insertAfter(element);
        },

        highlight: function(element,errorClass,validClass){
            $(element).css('border', '2px solid #FC4848');
        },
                    
        unhighlight: function(element, errorClass, validClass) {
            $(element).css('border', '2px solid #41BE47');
        }
    });
});

// Hiển thị thông tin vị trí hiện tại và loại biểu đồ tròn.
// function setCurrentInfo(place, name_id, cirle_id) {
//     if (name_id != null) {
//         $("#" + name_id).text(place.name);
//     }
//     if (cirle_id != null) {
//         $("#" + cirle_id).text(circle_type);
//     }
// }

// function getPlaceByLatlng(position) {
//     var geocoder = new google.maps.Geocoder;
//     var latlng = {
//         lat: position.lat(), 
//         lng: position.lng()
//     };
//     geocoder.geocode({'location': latlng}, function(results, status) {
//         if (status === 'OK') {
//             if (results[0]) {
//                 var service = new google.maps.places.PlacesService(map);
//                 service.getDetails({
//                     placeId: results[0].place_id
//                 }, function(place, status) {
//                     ABC(place);
//                 });
//             } else {
//                 window.alert('No results found');
//             }
//         } else {
//             window.alert('Geocoder failed due to: ' + status);
//         }
//     });
// }

// Hàm kiểm tra vị trí cần search đã có marker hay chưa.
function isLocationFree(search) {
    for (var i = 0, l = ddiem_list.length; i < l; i++) {
        if (ddiem_list[i]['lat'] === search[0] && ddiem_list[i]['lng'] === search[1]) {
            return false;
        }
    }
    return true;
}

// Cập nhật màu và bán kính hình tròn.
function updateCircle(circle, radius) {
    var color = '#FF0000';
    if (circle_type == '2') {
        color = '#EBAC00';
    }

    circle.setOptions({
        fillColor: color,
        strokeColor: color,
        radius: parseInt(radius)
    });
}

// Vẽ circle theo tâm và bán kính.
function createCircle(map, lat, lng, radius) {

    var color = '#FF0000';
    if (circle_type == '2') {
        color = '#EBAC00';
    }

    var circle = new google.maps.Circle({
        strokeColor: color,
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: color,
        fillOpacity: 0.35,
        map: map,
        center: {
            lat: parseFloat(lat), 
            lng: parseFloat(lng)
        },
        radius: parseInt(radius)
    });
    arr_circle.push(circle);

    index_marker = arr_circle.length - 1;
    circle.addListener('click', function() {
        show_InfoDiaDiem(index_marker);
    });
}

// Hiển thị modal thông tin địa điểm.
function show_InfoDiaDiem(index_marker) {
    if (index_marker == null) {

        var geocoder = new google.maps.Geocoder;
        var latlng = {
            lat: selected_position.lat(), 
            lng: selected_position.lng()
        };
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var service = new google.maps.places.PlacesService(map);
                    service.getDetails({
                        placeId: results[0].place_id
                    }, function(place, status) {

                        console.log(place);

                        // $("#id_ddiem").val("");
                        // $("#lat").val("");
                        // $("#lng").val("");
                        // $("#ten_diadiem").val("");
                        // $("#diachi").val("");
                    });
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });


        $("#id_ddiem").val("");
        $("#lat").val("");
        $("#lng").val("");
        $("#ten_diadiem").val("");
        $("#diachi").val("");
        $("#chiso1").val("");
        $("#chiso2").val("");
        $("#ghichu").val("");

        $('#modal_place_info').modal('show');
    } else {

        $("#id_ddiem").val(ddiem_list[index_marker]['id']);
        $("#lat").val(ddiem_list[index_marker]['lat']);
        $("#lng").val(ddiem_list[index_marker]['lng']);
        $("#ten_diadiem").val(ddiem_list[index_marker]['ten_diadiem']);
        $("#diachi").val(ddiem_list[index_marker]['diachi']);
        $("#chiso1").val(ddiem_list[index_marker]['chiso1']);
        $("#chiso2").val(ddiem_list[index_marker]['chiso2']);
        $("#ghichu").val(ddiem_list[index_marker]['ghichu']);

        $('#modal_place_info').modal('show');
    }
}

// Tạo marker theo tọa độ.
function createFlagMarker(map, flag_position, index_marker = null) {
    // Tùy chỉnh kích thước icon marker.
    var icon = {
        url: "img/marker2.png", // url
        scaledSize: new google.maps.Size(35, 25), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(18, 28) // anchor
    };

    // Tạo marker.
    var marker = new google.maps.Marker({
        position: flag_position,
        icon: icon,
        map: map,
        animation: google.maps.Animation.DROP,
    });

    if (index_marker == null) {
        $("#id_ddiem").val("");
        $("#lat").val("");
        $("#lng").val("");
        $("#ten_diadiem").val("");
        $("#diachi").val("");
        $("#chiso1").val("");
        $("#chiso2").val("");
        $("#ghichu").val("");
        
        arr_flag.push(marker);
    }

    marker.addListener('click', function() {
        show_InfoDiaDiem(index_marker);
    });
}

// Đánh dấu cờ mới theo tọa độ.
function setFlagByPosition(map, index_marker = null, flag_position = selected_position) {
    search = [flag_position.lat(), flag_position.lng()];
    is_free = isLocationFree(search);
    if (is_free) {
        createFlagMarker(map, flag_position, index_marker);
        $('#modal_place_info').modal('show');
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // Thêm tọa độ marker vào mảng.
        var element = {
            chiso1: 'chiso1',
            chiso2: 'chiso2',
            diachi: "diachi",
            id: "id",
            lat: flag_position.lat(),
            lng: flag_position.lng(),
            ten_diadiem: "ten_diadiem" 
        };
        ddiem_list.push(element);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    }
    else {
        alert("Vị trí đã đánh dấu trước đó");
    }
}

// Hiển thị về vị trí hiện tại.
function getLocation(map) {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        selected_position = pos;
        map.setCenter(pos);
        map.setZoom(18);

        find_marker.setMap(null);

        find_marker = new google.maps.Marker({
            position: pos,
            map: map
        });

        find_marker.setAnimation(google.maps.Animation.BOUNCE);

        // Đựa thông tin vị trí hiện tại lên màn hình.
        var geocoder = new google.maps.Geocoder;
        var latlng = {
            lat: selected_position.lat(), 
            lng: selected_position.lng()
        };
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var service = new google.maps.places.PlacesService(map);
                    service.getDetails({
                        placeId: results[0].place_id
                    }, function(place, status) {
                        console.log(place);
                        $("#vitrihientai_div").html("<b>Vị trí hiện tại:</b> " + place.name + "<br>\
                        <b>Loại biẻu đồ tròn:</b> " + loai);
                    });
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
        
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