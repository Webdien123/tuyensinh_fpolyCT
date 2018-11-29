// Tìm và hightlight từ khóa tìm kiếm.
function timKiem() {

	// Lấy giá trị cần tìm
    var key = $("#search_input").val();
    
    // Xóa phần hightlight trước đó dưới các lớp data_account
    $('.data_account').removeHighlight();
    
    if ( key ) {

        // Highlight từ khóa.
        $('.data_account').removeHighlight().highlight(key);

        // Ẩn tất cả dòng dữ liệu.
        $(".data_row").hide();

        // Hiển thị lại các dòng dữ liệu chưa key cần tìm.
        $(".highlight").closest('tr').show();

        // console.log();
        if ($(".data_row:visible").length == 0) {
        	$("tbody").append('<tr class="data_empty"> \
                <td colspan="4" style="font-style: inherit; font-weight: bold; text-align: center;">Không tìm thấy account</td>\
                </tr>'
            );
        }
    }
}

// Thông báo kết quả xử lý cho người dùng.
function thongBaoKetQua(result, text_content) {
    if (result == "ok") {
        $('#success-alert').modal('toggle');
        $("#alert-text").removeClass('text-danger').addClass('text-success');
        $("#alert-text").html('<i class="fa fa-check-circle-o fa-4x" aria-hidden="true"></i><br>' + text_content);
        setTimeout(function() {$('#success-alert').modal('hide');}, 1500);
    }
    if (result == "fail") {
        $('#success-alert').modal('toggle');
        $("#alert-text").removeClass('text-success').addClass('text-danger');
        $("#alert-text").html('<i class="fa fa-frown-o fa-4x" aria-hidden="true"></i><br>Có lỗi! vui lòng thử lại sau.');
        setTimeout(function() {$('#success-alert').modal('hide');}, 1500);
    }
}

// Hủy tìm kiếm kết quả theo key đã nhập.
function huyTimKiem() {
    // Xóa dòng báo tìm kiếm rống.
    $(".data_empty").remove();

    //Xóa màu hightlight.
    $('.data_account').removeHighlight();

    // Hiển thị lại tất cả dòng dữ liệu.
    $("tr.data_row").show();

    // Xóa giá trị key cần tìm.
    $('#search_input').val("");
}

// Xóa địa điểm.
function removeDiaDiem(id, ten_diadiem, btn_remove) {
    result = confirm("Xóa địa điểm " + ten_diadiem);
    if (result) {
        $.ajax({
            url: '/remove_flag',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                id_ddiem: id
            },
            success: function( result ) {
                // thongBaoKetQua(result, "Đã xóa cờ");

                if (result == "ok") {
                    $(btn_remove).closest('tr').remove();
                }
            },
            error: function( xhr, err ) {
                alert('Error');
            }
        });
    }  
}

// Xử lý các sự kiện sau khi load xong page.
$(document).ready(function(){
    // Bấm nút tìm kiếm.
    $("#btn_search").click(function(event) {
        timKiem();      
    });

    // Hủy tìm kiếm.
    $('#search_input').keyup(function(e){
        if(e.keyCode == 13)
        {
            timKiem();
        }
        if($(this).val() == "")
        {
            huyTimKiem();
        }
    });

    // Thay đổi từ khóa tìm kiếm.
    $("#btn_cancer_search").click(function(event) {
        huyTimKiem();
    });

    $(".btn_remove_truong").click(function(event) {
        id = $(this).closest('tr').children('input').eq(0).val();
        ten_diadiem = $(this).closest('tr').children('td').eq(1).text();
        removeDiaDiem(id, ten_diadiem, $(this));
    });
});