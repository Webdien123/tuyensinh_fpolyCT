// Khởi tạo bảng đồ sau khi page load xong.
window.onload = initMap;

// Biến lưu tọa độ vị trí đang hiển thị trên map.
var selected_position = null;

// Biến lưu index của địa điểm đang hiển thị trêm modal.
var index_info_ddiem = null;

// Biến lưu marker hiển thị kết quả tìm kiếm.
var find_marker = null;

// Danh sách vòng tròn hiển thị chỉ số 1 năm thứ 3 (mới nhất).
var arr_circle_1_3 = [];

// Danh sách vòng tròn hiển thị chỉ số 2 năm thứ 3 (mới nhất).
var arr_circle_2_3 = [];

// Danh sách vòng tròn hiển thị chỉ số 1 năm thứ 2.
var arr_circle_1_2 = [];

// Danh sách vòng tròn hiển thị chỉ số 2 năm thứ 2.
var arr_circle_2_2 = [];

// Danh sách vòng tròn hiển thị chỉ số 1 năm thứ 1.
var arr_circle_1_1 = [];

// Danh sách vòng tròn hiển thị chỉ số 2 năm thứ 1.
var arr_circle_2_1 = [];

// Danh sách marker đánh dấu địa điểm.
var arr_flag = [];

// Loại chỉ số hiển thị cho các vòng tròn trên map.
var circle_type = null;

// Hàm tạo button đánh dấu cờ.
function MarkerControl(controlDiv, map) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginRight = '10px';
    // controlUI.style.marginTop = '10px';
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
    controlText.innerHTML = '<img src="/img/btn_marker.png">';
    controlUI.appendChild(controlText);

    // Xử lý đánh dáu cờ khi click nút.
    controlUI.addEventListener('click', function() {
        setFlagByPosition(map);        
    });
}

// Hàm tạo button chọn loại biểu đồ tròn .
function CircleControl(controlDiv, map) {

    // Tạo DIV cha.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginRight = '10px';
    controlUI.style.marginTop = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Chọn loại biểu đồ tròn';    
    $(controlUI).addClass('dropdown');    
    controlDiv.appendChild(controlUI);

    // Tạo Button.
    var controlText = document.createElement('button');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '30px';
    controlText.style.paddingLeft = '2px';
    controlText.style.paddingRight = '2px';
    controlText.innerHTML = '<img src="/img/circle_type.png">';
    $(controlText).addClass('dropdown-toggle');
    $(controlText).attr("data-toggle", "dropdown");
    controlUI.appendChild(controlText);

    // Tạo dropdown menu.
    var controlMenu = document.createElement('div');
    $(controlMenu).addClass('dropdown-menu dropdown-menu-right');
    controlMenu.style.paddingLeft = '5px';
    controlMenu.style.paddingRight = '5px';
    controlMenu.style.marginRight = '-4px';
    controlUI.appendChild(controlMenu);

    var col1 = document.createElement('button');
    $(col1).css('width', '48%');
    $(col1).css('color', '#FF0000');
    $(col1).css('border', '3px solid #2CC133');
    $(col1).css('padding-left', '0px');
    $(col1).css('padding-right', '0px');
    $(col1).css('margin-right', '5px');
    $(col1).addClass('btn btn-default');
    $(col1).html('Chỉ số 1<br><i class="fa fa-circle-o fa-2x" aria-hidden="true"></i>');

    var col2 = document.createElement('button');
    $(col2).css('width', '48%');
    $(col2).css('border', '1px solid gray');
    $(col2).css('color', '#EBAC00');
    $(col2).addClass('btn btn-default');
    $(col2).css('padding-left', '0px');
    $(col2).css('padding-right', '0px');
    $(col2).html('Chỉ số 2<br><i class="fa fa-circle-o fa-2x" aria-hidden="true"></i>');

    var col3 = document.createElement('button');
    $(col3).css('width', '100%');
    $(col3).css('border', '1px solid gray');
    $(col3).addClass('btn btn-default');
    $(col3).css('margin-top', '5px');
    $(col3).css('padding-left', '0px');
    $(col3).css('padding-right', '0px');
    $(col3).html('Chỉ số 1 và chỉ số 2<br><img src="../img/multi_circle.jpg" style="width: 24px">');

    controlMenu.appendChild(col1);
    controlMenu.appendChild(col2);
    controlMenu.appendChild(col3);

    col1.addEventListener('click', function() {
        circle_type = '1';
        $(this).next("button").css('border', '1px solid gray');
        $(this).next("button").next("button").css('border', '1px solid gray');
        $(this).css('border', '3px solid #2CC133');
        updateCircleTypeInfo();
    });

    col2.addEventListener('click', function() {
        circle_type = '2';
        $(this).prev("button").css('border', '1px solid gray');
        $(this).next("button").css('border', '1px solid gray');
        $(this).css('border', '3px solid #2CC133');
        updateCircleTypeInfo();
    });

    col3.addEventListener('click', function() {
        circle_type = '3';
        $(this).prev("button").css('border', '1px solid gray');
        $(this).prev("button").prev("button").css('border', '1px solid gray');
        $(this).css('border', '3px solid #2CC133');
        updateCircleTypeInfo();
    });
}

// Hàm tạo button ẩn hiện biểu đò tròn.
function HideShowCircleControl(controlDiv, map) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.id = "div_hdshw_circle";
    controlUI.style.color = '#69CE3C';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginRight = '10px';
    controlUI.style.marginTop = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Ẩn/hiện vòng tròn';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '30px';
    controlText.style.paddingLeft = '7px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = '<i class="fa fa-toggle-on fa-lg" id="btn_hdshw_circle" aria-hidden="true"></i>';
    controlUI.appendChild(controlText);

    // Xử lý đánh dáu cờ khi click nút.
    controlUI.addEventListener('click', function() {
        if( $("#btn_hdshw_circle").hasClass('fa-toggle-on') ){
            $("#btn_hdshw_circle").removeClass('fa-toggle-on').addClass('fa-toggle-off');
            $(this).css('color', 'gray');
            hideCircle('1');
            hideCircle('2');
        }else{
            $("#btn_hdshw_circle").removeClass('fa-toggle-off').addClass('fa-toggle-on');
            $(this).css('color', '#69CE3C');
            if (circle_type == '1') {
                showCircle('1');
            }
            if (circle_type == '2') {
                showCircle('2');
            }
            if (circle_type == '3') {
                showCircle('1');
                showCircle('2');
            }            
        }
    });
}

// Hàm tạo button ẩn hiện biểu đò tròn.
function HideShowYearControl(controlDiv, map) {

    // Tạo DIV cha.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.cursor = 'pointer';
    controlUI.style.marginRight = '10px';
    controlUI.style.marginBottom = '10px';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Chọn năm hiển thị';    
    $(controlUI).addClass('dropup');    
    controlDiv.appendChild(controlUI);

    // Tạo Button.
    var controlText = document.createElement('span');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.style.lineHeight = '30px';
    controlText.style.paddingLeft = '3px';
    controlText.style.paddingRight = '3px';
    controlText.innerHTML = '<img src="../img/calendar.png" style="width: 30px">';
    $(controlText).addClass('dropdown-toggle');
    $(controlText).attr("data-toggle", "dropdown");
    controlUI.appendChild(controlText);

    // Tạo dropdown menu.
    var controlMenu = document.createElement('div');
    $(controlMenu).addClass('dropdown-menu dropdown-menu-right');
    controlMenu.style.paddingLeft = '10px';
    controlMenu.style.marginRight = '-4px';
    controlUI.appendChild(controlMenu);

    var row1 = document.createElement('span');
    $(row1).css('width', '100%');
    $(row1).css('padding-left', '0px');
    $(row1).css('padding-right', '0px');
    $(row1).css('margin-right', '5px');
    $(row1).html('<label><input type="checkbox" checked="true" id="chk_1">&nbsp;&nbsp;Năm ' + (selected_namhoc - 2) + '</label>\
        <span class="input-color">\
            <span class="color-box" style="background-color: ' + color_circle_1_1 + ';"></span>\
        </span>\
        <span class="input-color">\
            <span class="color-box" style="background-color: ' + color_circle_2_1 + ';"></span>\
        </span>'
    );

    var row2 = document.createElement('span');
    $(row2).css('width', '100%');
    $(row2).css('padding-left', '0px');
    $(row2).css('padding-right', '0px');
    $(row2).css('margin-right', '5px');
    $(row2).html('<label><input type="checkbox" checked="true" id="chk_2">&nbsp;&nbsp;Năm ' + (selected_namhoc - 1) + '</label>\
        <span class="input-color">\
            <span class="color-box" style="background-color: ' + color_circle_1_2 + ';"></span>\
        </span>\
        <span class="input-color">\
            <span class="color-box" style="background-color: ' + color_circle_2_2 + ';"></span>\
        </span>'
    );

    var row3 = document.createElement('span');
    $(row3).css('width', '100%');
    $(row3).css('padding-left', '0px');
    $(row3).css('padding-right', '0px');
    $(row3).css('margin-right', '5px');
    $(row3).html('<label><input type="checkbox" checked="true" id="chk_3">&nbsp;&nbsp;Năm ' + selected_namhoc + '</label>\
        <span class="input-color">\
            <span class="color-box" style="background-color: ' + color_circle_1_3 + ';"></span>\
        </span>\
        <span class="input-color">\
            <span class="color-box" style="background-color: ' + color_circle_2_3 + ';"></span>\
        </span>'
    );

    controlMenu.appendChild(row1);
    controlMenu.appendChild(row2);
    controlMenu.appendChild(row3);

    $(row1).children('label').children('input').click(function(event) {
        // console.log("CHON NAM");
        // console.log($(this).prop('checked'));
        if ($(this).prop('checked') == true) {
            showCircleByYear('1');
        } else {
            hideCircleByYear('1');
        }
    });

    $(row2).children('label').children('input').click(function(event) {
        // console.log("CHON NAM");
        // console.log($(this).prop('checked'));
        if ($(this).prop('checked') == true) {
            showCircleByYear('2');
        } else {
            hideCircleByYear('2');
        }
    });

    $(row3).children('label').children('input').click(function(event) {
        // console.log("CHON NAM");
        // console.log($(this).prop('checked'));
        if ($(this).prop('checked') == true) {
            showCircleByYear('3');
        } else {
            hideCircleByYear('3');
        }
    });
}

// Tạo control hiển thị vị trí hiện tại và loại chỉ số hiển thị.
function CurrentInfoControl(controlDiv, map) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.border = '2px solid #fff';
    controlUI.style.borderRadius = '3px';
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    controlUI.style.marginLeft = '10px';
    controlUI.style.textAlign = 'left';
    controlUI.style.fontSize = '14px';
    controlUI.title = 'Thông tin vị trí hiện tại';
    $(controlUI).addClass('row');
    controlDiv.appendChild(controlUI);

    loai = (circle_type == '1') ? "Chỉ số 1" : "Chỉ số 2";

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
                    controlUI.innerHTML = '\
                        <div class="col-xs-12 col-md-9"><b>Vị trí hiện tại: </b><span id="name_info">' + place.name + '</span><br>\
                        <b>Vòng tròn thể hiện cho: </b><span id="circle_info">' + loai + '</span><br>\
                        <b>Năm tuyển sinh hiện tại: </b><span>' + selected_namhoc + '</span></div>\
                        <div class="col-xs-12 col-md-3"><b>' + (selected_namhoc - 2) + ':</b>\
                        <span class="input-color">\
                            Chỉ số 1 <span class="color-box" style="background-color: ' + color_circle_1_1 + ';"></span>\
                        </span>\
                        <span class="input-color">\
                            Chỉ số 2 <span class="color-box" style="background-color: ' + color_circle_2_1 + ';"></span>\
                        </span><br><b>' + (selected_namhoc - 1) + ':</b>\
                        <span class="input-color">\
                            Chỉ số 1 <span class="color-box" style="background-color: ' + color_circle_1_2 + ';"></span>\
                        </span>\
                        <span class="input-color">\
                            Chỉ số 2 <span class="color-box" style="background-color: ' + color_circle_2_2 + ';"></span>\
                        </span><br><b>' + selected_namhoc + ':</b>\
                        <span class="input-color">\
                            Chỉ số 1 <span class="color-box" style="background-color: ' + color_circle_1_3 + ';"></span>\
                        </span>\
                        <span class="input-color">\
                            Chỉ số 2 <span class="color-box" style="background-color: ' + color_circle_2_3 + ';"></span>\
                        </span></div>';
                });
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
      
    // controlUI.appendChild(controlText);
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

    var marker_position = new google.maps.LatLng(10.0268264, 105.75735280000004);

    var mapOptions = {
        center: marker_position,
        zoom: 13,
        panControl: false,
        fullscreenControl: false,
        zoomControl: true,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_RIGHT,
            index: 2
        },
        scaleControl: false,
        streetViewControl: false,
        overviewMapControl: false,
        rotateControl: false,
        zIndex: 0
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);

    M = new google.maps.Marker({
        position: marker_position,
        map: map,
        zIndex: 0
    });


    // Thêm thanh search bar lên bản đồ.
    var input = document.getElementById('pac-input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(input);

    // Tạo marker hiển thị vị trí tìm kiếm
    find_marker = new google.maps.Marker({
        map: map
    });

    // Gán loại chỉ số hiển thị là 1.
    circle_type = '1';

    autocomplete.addListener('place_changed', function() {
        
        $(".pac-container, .pac-item").css('z-index', '2147483647 !important');

        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(13);
        }

        selected_position = place.geometry.location;

        // Set lại vị trí của marker hiển thị kết quả.
        find_marker.setMap(null);

        find_marker = new google.maps.Marker({
            position: selected_position,
            map: map,
            zIndex: 0
        });

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
    });

    selected_position = marker_position;

    for (var i = 0; i < ddiem_list.length; i++) {
        var flag_position = new google.maps.LatLng(ddiem_list[i]['lat'], ddiem_list[i]['lng']);        
        createFlagMarker(map, flag_position, i);
        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso1_3'], i);
        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso2_3'], i, '2');

        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso1_1'], i, '1', '1');
        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso2_1'], i, '2', '1');

        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso1_2'], i, '1', '2');
        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso2_2'], i, '2', '2');
    }

    hideCircle('2');

    // Thêm button đánh dấu cờ.
    var MarkerControlDiv = document.createElement('div');
    var markercontrol = new MarkerControl(MarkerControlDiv, map);
    MarkerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(MarkerControlDiv);

    // Thêm button chọn loại biểu đồ tròn.
    var HideShowCircleControlDIV = document.createElement('div');
    var hideshowcirclecontrol = new HideShowCircleControl(HideShowCircleControlDIV, map);
    HideShowCircleControlDIV.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(HideShowCircleControlDIV);

    // Thêm button chọn loại biểu đồ tròn.
    var CircleControlDiv = document.createElement('div');
    var circlecontrol = new CircleControl(CircleControlDiv, map);
    CircleControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(CircleControlDiv);

    // Thêm button về vị trí hiện tại.
    var GpsControlDiv = document.createElement('div');
    var gpscontrol = new GpsControl(GpsControlDiv, map);
    GpsControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(GpsControlDiv);

    // Thêm button chọn năm hiển thị.
    var HideShowYearControlDiv = document.createElement('div');
    var hideshowyearcontrol = new HideShowYearControl(HideShowYearControlDiv, map);
    HideShowYearControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(HideShowYearControlDiv);

    // Thêm ông tin về vị trí hiện tại.
    var CurrentInfoControlDiv = document.createElement('div');
    CurrentInfoControlDiv.style.width = '80%';
    var currentInfoControl = new CurrentInfoControl(CurrentInfoControlDiv, map);
    CurrentInfoControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(CurrentInfoControlDiv);   
}