
// Validate dữ liệu form nhập thông tin địa chỉ.
jQuery(document).ready(function($) {

    if (ddiem_list.length == 0) {
        alert("Năm " + selected_namhoc + " chưa có dữ liệu tuyển sinh");
    }

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
            chiso2_3: {
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

    $("#btn_remove_flag").click(function(event) {
        removeFlag();
    });

    $("#f_update_ddiem").keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            saveFlag()
        }
    });
});

// Thông báo kết quả xử lý cho người dùng.
function thongBaoKetQua(result, text_content = null) {
    if (result == "ok") {
        $('#success-alert').modal('toggle');
        $("#alert-text").removeClass('text-danger').addClass('text-success');
        $("#alert-text").html('<i class="fa fa-check-circle-o fa-4x" aria-hidden="true"></i><br>' + text_content);
        setTimeout(function() {$('#success-alert').modal('hide');}, 800);
    }
    if (result == "fail") {
        $('#success-alert').modal('toggle');
        $("#alert-text").removeClass('text-success').addClass('text-danger');
        if (text_content == null) {
            $("#alert-text").html('<i class="fa fa-frown-o fa-4x" aria-hidden="true"></i><br>Có lỗi! vui lòng thử lại sau.');
        } else {
            $("#alert-text").html('<i class="fa fa-frown-o fa-4x" aria-hidden="true"></i><br>' + text_content + '');
        }
        
        setTimeout(function() {$('#success-alert').modal('hide');}, 800);
    }
}

// Lưu cờ mới.
function addFlag() {
    console.log($("#f_update_ddiem").serialize());
    $.ajax({
        url: '/add_flag',
        type: 'POST',
        data: $("#f_update_ddiem").serialize(),
        success: function( result ) {
            thongBaoKetQua(result, "Đã thêm cờ");
        },
        error: function( xhr, err ) {
            thongBaoKetQua("fail");
        }
    }); 
}

// Cập nhật thông tin địa điểm đang hiển thị trên modal.
function saveFlag() {
    if ($("#f_update_ddiem").valid()) {
        console.log($("#f_update_ddiem").serialize());
        $.ajax({
            url: '/save_flag',
            type: 'POST',
            data: $("#f_update_ddiem").serialize(),
            success: function( result ) {
                thongBaoKetQua(result, "Cập nhật thông tin thành công");

                if (result == "ok") {
                    radius = (circle_type == '1') ? $("#chiso1").val() : $("#chiso2").val();

                    // Cập nhật thông tin địa điểm vào mảng lưu trữ.
                    ddiem_list[index_info_ddiem]['id'] = $("#id_ddiem").val();
                    ddiem_list[index_info_ddiem]['lat'] = $("#lat").val();
                    ddiem_list[index_info_ddiem]['lng'] = $("#lng").val();
                    ddiem_list[index_info_ddiem]['ten_diadiem'] = $("#ten_diadiem").val();
                    ddiem_list[index_info_ddiem]['diachi'] = $("#diachi").val();
                    ddiem_list[index_info_ddiem]['ghichu'] = $("#ghichu").val();
                    ddiem_list[index_info_ddiem]['chiso1_3'] = $("#chiso1").val();
                    ddiem_list[index_info_ddiem]['chiso2_3'] = $("#chiso2").val();

                    // Cập nhật độ lớn biểu đồ tròn tại địa điểm tương ứng.
                    updateCircle([index_info_ddiem], $("#chiso1").val(), $("#chiso2").val());
                }
            },
            error: function( xhr, err ) {
                thongBaoKetQua("fail");
            }
        });       
    }
}

// Xóa cờ.
function removeFlag() {
    result = confirm("Xóa tất cả dữ liệu của " + $("#ten_diadiem").val());
    if (result) {
        $.ajax({
            url: '/remove_flag',
            type: 'POST',
            data: $("#f_update_ddiem").serialize(),
            success: function( result ) {
                $('#modal_place_info').modal('hide');

                thongBaoKetQua(result, "Đã xóa cờ");

                if (result == "ok") {
                    arr_flag[index_info_ddiem].setOptions({map: null});
                    arr_circle_1_3[index_info_ddiem].setOptions({map: null});
                    arr_circle_2_3[index_info_ddiem].setOptions({map: null});

                    ddiem_list.splice(index_info_ddiem, 1);
                    arr_flag.splice(index_info_ddiem, 1);
                    arr_circle_1_3.splice(index_info_ddiem, 1);
                    arr_circle_2_3.splice(index_info_ddiem, 1);
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

// Ẩn/Hiện hình tròn gợp màu khi các vòng tròn có cùng bán kính.
function circleOverlay(hide = true) {
    size = ddiem_list.length;
    for (var i = 0; i < size; i++) {
        if(ddiem_list[i]['chiso1_3'] == ddiem_list[i]['chiso2_3']){
            radius = ddiem_list[i]['chiso1_3'];
            if (hide) {
                updateCircle(i, radius, radius);
            }
            else{
                updateCircle(i, radius, radius, "#DB6F2D");
            }
        }
    }
}

// Hiển thị loại chỉ số của biểu đồ tròn.
function updateCircleTypeInfo() {
    loai = "";
    if (circle_type == '1') {
        hideCircle('2');
        showCircle('1');
        loai = "Chỉ số 1";
    }
    if (circle_type == '2') {
        hideCircle('1');
        showCircle('2');
        loai = "Chỉ số 2";
        circleOverlay(true);
    }
    if (circle_type == '3') {
        showCircle('1');
        showCircle('2');
        loai = "Chỉ số 1 và chỉ số 2";
        circleOverlay(false);
    }
    $("#circle_info").text(loai);
    if( $("#btn_hdshw_circle").hasClass('fa-toggle-off') ){
        $("#btn_hdshw_circle").removeClass('fa-toggle-off').addClass('fa-toggle-on');
        $("#div_hdshw_circle").css('color', '#69CE3C');
    }
}

// Hiện biểu đồ tròn theo năm.
function showCircleByYear(year) {
    if (year == '1') {
        size = arr_circle_1_1.length;
        for (var i = 0; i < size; i++) {
            if (circle_type == '1') {
                arr_circle_1_1[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
            if (circle_type == '2') {
                arr_circle_2_1[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
            if (circle_type == '3') {
                arr_circle_1_1[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
                arr_circle_2_1[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
        }
    }

    if (year == '2') {
        size = arr_circle_1_2.length;
        for (var i = 0; i < size; i++) {
            if (circle_type == '1') {
                arr_circle_1_2[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
            if (circle_type == '2') {
                arr_circle_2_2[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
            if (circle_type == '3') {
                arr_circle_1_2[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
                arr_circle_2_2[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
        }
    }

    if (year == '3') {
        size = arr_circle_1_3.length;
        for (var i = 0; i < size; i++) {
            if (circle_type == '1') {
                arr_circle_1_3[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
            if (circle_type == '2') {
                arr_circle_2_3[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
            if (circle_type == '3') {
                arr_circle_1_3[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
                arr_circle_2_3[i].setOptions({fillOpacity: 0.02, strokeOpacity: 1});
            }
        }
    }
}

// Ẩn biểu đồ tròn theo năm.
function hideCircleByYear(year) {
    if (year == '1') {
        size = arr_circle_1_1.length;
        for (var i = 0; i < size; i++) {
            arr_circle_1_1[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_2_1[i].setOptions({fillOpacity:0, strokeOpacity:0});
        }
    }

    if (year == '2') {
        size = arr_circle_1_2.length;
        for (var i = 0; i < size; i++) {
            arr_circle_1_2[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_2_2[i].setOptions({fillOpacity:0, strokeOpacity:0});
        }
    }

    if (year == '3') {
        size = arr_circle_1_3.length;
        for (var i = 0; i < size; i++) {
            arr_circle_1_3[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_2_3[i].setOptions({fillOpacity:0, strokeOpacity:0});
        }
    }
}

// Hiển thị biểu đồ tròn theo loại chỉ số.
function showCircle(type) {
    if (type == '1') {
        size = arr_circle_1_3.length;
        console.log();
        for (var i = 0; i < size; i++) {
            if ($("#chk_1").prop('checked')) {  
                arr_circle_1_1[i].setOptions({fillOpacity: 0.02, strokeOpacity:1});  
            }
            if ($("#chk_2").prop('checked')) {
                arr_circle_1_2[i].setOptions({fillOpacity: 0.02, strokeOpacity:1});
            }
            if ($("#chk_3").prop('checked')) {
                arr_circle_1_3[i].setOptions({fillOpacity: 0.02, strokeOpacity:1});
            }
        }
    }

    if (type == '2') {
        size = arr_circle_2_3.length;
        for (var i = 0; i < size; i++) {
            if ($("#chk_1").prop('checked')) {
                arr_circle_2_1[i].setOptions({fillOpacity: 0.02, strokeOpacity:1});  
            }
            if ($("#chk_2").prop('checked')) {
                arr_circle_2_2[i].setOptions({fillOpacity: 0.02, strokeOpacity:1});
            }
            if ($("#chk_3").prop('checked')) {
                arr_circle_2_3[i].setOptions({fillOpacity: 0.02, strokeOpacity:1});
            }
        }
    }
}

// Ẩn biểu đồ tròn theo loại chỉ số.
function hideCircle(type) {
    if (type == '1') {
        size = arr_circle_1_3.length;
        for (var i = 0; i < size; i++) {
            arr_circle_1_3[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_1_2[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_1_1[i].setOptions({fillOpacity:0, strokeOpacity:0});
        }
    }

    if (type == '2') {
        size = arr_circle_2_3.length;
        for (var i = 0; i < size; i++) {
            arr_circle_2_3[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_2_2[i].setOptions({fillOpacity:0, strokeOpacity:0});
            arr_circle_2_1[i].setOptions({fillOpacity:0, strokeOpacity:0});
        }
    }
}

// Cập nhật màu và bán kính hình tròn.
function updateCircle(index, radius1, radius2, overlay_color = null) {

    arr_circle_1_3[index].setOptions({
        radius: parseInt(radius1) * 40
    });

    arr_circle_2_3[index].setOptions({
        radius: parseInt(radius2) * 40
    });

    if (overlay_color != null) {
        arr_circle_2_3[index].setOptions({
            strokeWeight: 4,
            strokeColor: overlay_color,
            fillColor: overlay_color
        });
    }
    else{
        arr_circle_2_3[index].setOptions({
            strokeWeight: 2,
            strokeColor: "#EBCD00",
            fillColor: "#EBCD00"
        });
    }
}

// Vẽ circle theo tâm và bán kính.
function createCircle(map, lat, lng, radius, index_marker = null, type = '1', year = '3') {
    
    if (year == '1') {
        var color = color_circle_1_1;
        if (type == '2') {
            color = color_circle_2_1;
        }
    }if (year == '2') {
        var color = color_circle_1_2;
        if (type == '2') {
            var color = color_circle_2_2;
        }
    }
    if (year == '3') {
        var color = color_circle_1_3;
        if (type == '2') {
            var color = color_circle_2_3;
        }
    }

    var circle = new google.maps.Circle({
        strokeColor: color,
        strokeOpacity: 1,
        strokeWeight: 2,
        fillColor: color,
        fillOpacity: 0.02,
        map: map,
        center: {
            lat: parseFloat(lat), 
            lng: parseFloat(lng)
        },
        radius: parseInt(radius) * 50,
        zIndex: 1
    });

    if (year == '3') {
        if (type == '1') {
            arr_circle_1_3.push(circle);
        }
        if (type == '2') {
            arr_circle_2_3.push(circle);
        }
    }
    if (year == '1') {
        if (type == '1') {
            arr_circle_1_1.push(circle);
        }
        if (type == '2') {
            arr_circle_2_1.push(circle);
        }
    }
    if (year == '2') {
        if (type == '1') {
            arr_circle_1_2.push(circle);
        }
        if (type == '2') {
            arr_circle_2_2.push(circle);
        }
    }    

    // if (index_marker == null) {
    //     circle.addListener('click', function() {
    //         show_InfoDiaDiem(arr_circle_1_3_1.length - 1);
    //     });
    // }
    // else{
    //     circle.addListener('click', function() {
    //         show_InfoDiaDiem(index_marker);
    //     });
    // }
}

// Hiển thị modal thông tin địa điểm.
function show_InfoDiaDiem(index_marker) {
    $("#id_ddiem").val(ddiem_list[index_marker]['id']);
    $("#lat").val(ddiem_list[index_marker]['lat']);
    $("#lng").val(ddiem_list[index_marker]['lng']);
    $("#ten_diadiem").val(ddiem_list[index_marker]['ten_diadiem']);
    $("#diachi").val(ddiem_list[index_marker]['diachi']);
    $("#ghichu").val(ddiem_list[index_marker]['ghichu']);
    $("#chiso1_2").val(ddiem_list[index_marker]['chiso1_2']);
    $("#chiso2_2").val(ddiem_list[index_marker]['chiso2_2']);
    $("#chiso1_1").val(ddiem_list[index_marker]['chiso1_1']);
    $("#chiso2_1").val(ddiem_list[index_marker]['chiso2_1']);
    $("#btn_lsutuongtac").prop('href', '/lsutuongtac/' + ddiem_list[index_marker]['id'])

    if (ddiem_list[index_marker]['chiso1_3'] == null) {        
        $("#chiso1").val(0);
        $("#chiso2").val(0);
        $("#no_data").text("(Chưa có dữ liệu)");
    } else {        
        $("#chiso1").val(ddiem_list[index_marker]['chiso1_3']);
        $("#chiso2").val(ddiem_list[index_marker]['chiso2_3']);
        $("#no_data").text("");
    }

    index_info_ddiem = index_marker;
    $('#modal_place_info').modal('show');
}

// Tạo marker theo tọa độ.
function createFlagMarker(map, flag_position, index_marker = null) {
    // Tùy chỉnh kích thước icon marker.
    var icon = {
        url: "../img/marker2.png", // url
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
        zIndex: 2
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

                        // Cập nhật thông tin lên form để submit cắm cờ.
                        $("#id_ddiem").val(place.place_id);
                        $("#lat").val(place.geometry.location.lat());
                        $("#lng").val(place.geometry.location.lng());
                        $("#ten_diadiem").val(place.name);
                        $("#diachi").val(place.formatted_address);
                        $("#chiso1").val("0");
                        $("#chiso2").val("0");
                        $("#ghichu").val("");

                        // Tạo đối tượng lưu địa điểm mới.
                        var ddiem = {
                            id: place.place_id,
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng(),
                            ten_diadiem: place.name,
                            diachi: place.formatted_address,
                            namhoc: selected_namhoc,
                            chiso1_3: null,
                            chiso2_3: null,
                            ghichu: "",
                        };

                        // Add địa điểm vào mảng dữ liệu.
                        ddiem_list.push(ddiem);

                        // Đánh dấu cờ cho địa điểm mới.
                        addFlag();

                        // Vẽ các biểu đồ tròn.
                        createCircle(map, place.geometry.location.lat(), place.geometry.location.lng(), 0, null, '1');
                        createCircle(map, place.geometry.location.lat(), place.geometry.location.lng(), 0, null, '2');

                        // Ẩn hiện biểu đồ theo loại biểu đồ đang chọn.
                        updateCircleTypeInfo();
                    });
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
           
        marker.addListener('click', function() {
            show_InfoDiaDiem(ddiem_list.length - 1);
        });
    }
    else{
        marker.addListener('click', function() {
            show_InfoDiaDiem(index_marker);
        });
    }
    arr_flag.push(marker);
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
        thongBaoKetQua("fail", "Trình duyệt chưa được cấp quyền truy cập vị trí");
      });
    } else {
      // Browser doesn't support Geolocation
      thongBaoKetQua("fail", "Dịch vụ vị trí có lỗi");
    }
}