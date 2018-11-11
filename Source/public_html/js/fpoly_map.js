// Khởi tạo bảng đồ sau khi page load xong.
window.onload = initMap;

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
}