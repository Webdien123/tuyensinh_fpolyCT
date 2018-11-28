// Khởi tạo bảng đồ sau khi page load xong.
window.onload = initMap;

// Biến lưu tọa độ vị trí đang hiển thị trên map.
var selected_position = null;

// Biến lưu index của địa điểm đang hiển thị trêm modal.
var index_info_ddiem = null;

// Biến lưu marker hiển thị kết quả tìm kiếm.
var find_marker = null;

// Danh sách vòng tròn hiển thị chỉ số 1.
var arr_circle_1 = [];

// Danh sách vòng tròn hiển thị chỉ số 1.
var arr_circle_2 = [];

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
    controlUI.style.marginTop = '10px';
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
        hideCircle('2');
        showCircle('1');
        updateCircleTypeInfo();
    });

    col2.addEventListener('click', function() {
        circle_type = '2';
        $(this).prev("button").css('border', '1px solid gray');
        $(this).next("button").css('border', '1px solid gray');
        $(this).css('border', '3px solid #2CC133');
        hideCircle('1');
        showCircle('2');
        updateCircleTypeInfo();
    });

    col3.addEventListener('click', function() {
        if (circle_type == '1') {
            showCircle('2');
        }
        if (circle_type == '2') {
            showCircle('1');
        }
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
    controlText.style.paddingLeft = '8px';
    controlText.style.paddingRight = '5px';
    controlText.innerHTML = '<i class="fa fa-toggle-on fa-lg" id="btn_hdshw_circle" aria-hidden="true"></i>';
    controlUI.appendChild(controlText);

    // Xử lý đánh dáu cờ khi click nút.
    controlUI.addEventListener('click', function() {
        if( $("#btn_hdshw_circle").hasClass('fa-toggle-on') ){
            $("#btn_hdshw_circle").removeClass('fa-toggle-on').addClass('fa-toggle-off');
            $(this).css('color', 'black');
            hideCircle('1');
            hideCircle('2');
        }else{
            $("#btn_hdshw_circle").removeClass('fa-toggle-off').addClass('fa-toggle-on');
            $(this).css('color', '#69CE3C');
            showCircle('1');
            showCircle('2');
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
    controlUI.title = 'Thông tin vị trí hiện tại';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.color = 'rgb(25,25,25)';
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    controlText.style.fontSize = '14px';
    controlText.style.lineHeight = '30px';
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
                    controlText.innerHTML = "<b>Vị trí hiện tại: </b><span id='name_info'>" + place.name + "</span><br>\
                    <b>Vòng tròn thể hiện cho: </b><span id='circle_info'>" + loai + "</span>";
                });
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
      
    controlUI.appendChild(controlText);
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
        mapTypeControl: false,
        // mapTypeControlOptions: {
        //     style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        //     position: google.maps.ControlPosition.LEFT_TOP
        // },
        scaleControl: false,
        streetViewControl: false,
        overviewMapControl: false,
        rotateControl: false
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);

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
        // infowindow.close();
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
            map: map
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
        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso1'], i);
        createCircle(map, ddiem_list[i]['lat'], ddiem_list[i]['lng'], ddiem_list[i]['chiso2'], i, '2');
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

    // Thêm ông tin về vị trí hiện tại.
    var CurrentInfoControlDiv = document.createElement('div');
    CurrentInfoControlDiv.style.width = '80%';
    var currentInfoControl = new CurrentInfoControl(CurrentInfoControlDiv, map);
    CurrentInfoControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(CurrentInfoControlDiv);   
}