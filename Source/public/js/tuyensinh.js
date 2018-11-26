// Validate dữ liệu form nhập thông tin địa chỉ.
jQuery(document).ready(function($) {
    // Validate form địa điểm.
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
                maxlength: 5000
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
                min: "Giá trị phải lớn hơn hoặc bằng 0"
            },
            chiso2: {
                min: "Giá trị phải lớn hơn hoặc bằng 0"
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

    $("#btn_save_flag").click(function(event) {
        saveFlag();
    });
});

function addFlag() {
    $.ajax({
        url: '/add_flag',
        type: 'POST',
        data: $("#f_update_ddiem").serialize(),
        success: function( result ) {
            $('#modal_place_info').modal('toggle');
            if (result == "ok") {
                alert("Đã thêm cờ");
            }
            if (result == "fail") {
                alert("Lỗi thêm cờ");
            }
        },
        error: function( xhr, err ) {
            alert('Error');
        }
    }); 
}

// Cập nhật thông tin địa điểm đang hiển thị trên modal.
function saveFlag() {
    if ($("#f_update_ddiem").valid()) {
        $.ajax({
            url: '/save_flag',
            type: 'POST',
            data: $("#f_update_ddiem").serialize(),
            success: function( result ) {
                $('#modal_place_info').modal('toggle');
                if (result == "ok") {
                    $("#success-alert").removeClass('alert-danger').addClass('alert-success');
                    $("#alert-text").text('Lưu địa điểm thành công.');
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });

                    // Ngược giá trị đã lưu vào mảng địa điểm.
                    ddiem_list[index_info_ddiem]['ten_diadiem'] = $("#ten_diadiem").val();
                    ddiem_list[index_info_ddiem]['diachi'] = $("#diachi").val();
                    ddiem_list[index_info_ddiem]['ghichu'] = $("#ghichu").val();
                    ddiem_list[index_info_ddiem]['chiso1'] = $("#chiso1").val();
                    ddiem_list[index_info_ddiem]['chiso2'] = $("#chiso2").val();

                    // Cập nhật độ lớn biểu đồ tròn.
                    radius = (circle_type == '1') ? ddiem_list[index_info_ddiem]['chiso1'] :  ddiem_list[index_info_ddiem]['chiso2'];
                    updateCircle(arr_circle[index_info_ddiem], radius);
                }
                if (result == "fail") {
                    $("#success-alert").removeClass('alert-success').addClass('alert-danger');
                    $("#alert-text").text('Có lỗi! vui lòng thử lại sau.');
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });
                }
            },
            error: function( xhr, err ) {
                alert('Error');
            }
        });       
    }
}

// Hàm kiểm tra vị trí cần search đã có marker hay chưa.
function isLocationFree(search) {
    for (var i = 0, l = ddiem_list.length; i < l; i++) {
        if (ddiem_list[i]['lat'] == search[0] && ddiem_list[i]['lng'] == search[1]) {
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
function createCircle(map, lat, lng, radius, index_marker = null) {

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
        radius: parseInt(radius),
        zIndex: 100
    });
    arr_circle.push(circle);

    if (index_marker == null) {
        circle.addListener('click', function() {
            show_InfoDiaDiem(arr_circle.length - 1);
        });
    }
    else{
        circle.addListener('click', function() {
            show_InfoDiaDiem(index_marker);
        });
    }
}

// Hiển thị modal thông tin địa điểm.
function show_InfoDiaDiem(index_marker) {
    $("#id_ddiem").val(ddiem_list[index_marker]['id']);
    $("#lat").val(ddiem_list[index_marker]['lat']);
    $("#lng").val(ddiem_list[index_marker]['lng']);
    $("#ten_diadiem").val(ddiem_list[index_marker]['ten_diadiem']);
    $("#diachi").val(ddiem_list[index_marker]['diachi']);
    $("#ghichu").val(ddiem_list[index_marker]['ghichu']);

    if (ddiem_list[index_marker]['chiso1'] == "-1") {        
        $("#chiso1").val(0);
        $("#chiso2").val(0);
    } else {        
        $("#chiso1").val(ddiem_list[index_marker]['chiso1']);
        $("#chiso2").val(ddiem_list[index_marker]['chiso2']);
    }

    index_info_ddiem = index_marker;
    $('#modal_place_info').modal('show');
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
        zIndex: 200 
    });

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

                        $("#id_ddiem").val(place.place_id);
                        $("#lat").val(place.geometry.location.lat());
                        $("#lng").val(place.geometry.location.lng());
                        $("#ten_diadiem").val(place.name);
                        $("#diachi").val(place.formatted_address);
                        $("#chiso1").val("0");
                        $("#chiso2").val("0");
                        $("#ghichu").val("");

                        var ddiem = {
                            id: place.place_id,
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng(),
                            ten_diadiem: place.name,
                            diachi: place.formatted_address,
                            chiso1: "-1",
                            chiso2: "-1",
                            ghichu: "",
                        };

                        ddiem_list.push(ddiem);

                        addFlag();
                    });
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
        arr_flag.push(marker);
        marker.addListener('click', function() {
            show_InfoDiaDiem(ddiem_list.length - 1);
        });
    }
    else{
        marker.addListener('click', function() {
            show_InfoDiaDiem(index_marker);
        });
    }
    
}

// Đánh dấu cờ mới theo tọa độ.
function setFlagByPosition(map, index_marker = null, flag_position = selected_position) {
    search = [flag_position.lat(), flag_position.lng()];
    is_free = isLocationFree(search);
    if (is_free) {
        createFlagMarker(map, flag_position, index_marker);
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
                        $("#name_info").text(place.name);
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