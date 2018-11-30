// Dòng dữ liệu đang được giữ đúp chuột để edit.
var tr_dbclick = null;

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
function removeDiaDiem(id, ten_diadiem, namhoc, btn_remove) {
    result = confirm("Xóa địa điểm " + ten_diadiem);
    if (result) {
        var xhr = $.ajax({
            url: '/remove_flag',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                id_ddiem: id,
                _namhoc: namhoc
            },
            success: function( result ) {
                thongBaoKetQua(result, "Đã xóa cờ");

                if (result == "ok") {
                    $(btn_remove).closest('tr').remove();

                    // Xóa dòng dữ liệu vừa chứa data cần xóa trên màn hình.
                    tr_dbclick.remove();
                }
            },
            error: function( xhr, err ) {
                alert('Error');
            }
        });
        console.log(xhr);
    }  
}

// Hiển thị modal thông tin địa điểm.
function show_InfoDiaDiem(btn_edit) {
    $("#id_ddiem").val($(btn_edit).closest('tr').children('input').eq(0).val());
    $("#lat").val($(btn_edit).closest('tr').children('input').eq(1).val());
    $("#lng").val($(btn_edit).closest('tr').children('input').eq(2).val());
    $("#ten_diadiem").val($(btn_edit).closest('tr').children('td').eq(0).text());
    $("#diachi").val($(btn_edit).closest('tr').children('td').eq(1).text());
    $("#namhoc").val($(btn_edit).closest('tr').children('td').eq(2).text());
    $("#_namhoc").val($(btn_edit).closest('tr').children('td').eq(2).text());    
    $("#chiso1").val($(btn_edit).closest('tr').children('td').eq(3).text());
    $("#chiso2").val($(btn_edit).closest('tr').children('td').eq(4).text());
    $("#ghichu").val($(btn_edit).closest('tr').children('td').eq(5).text());
    $('#modal_truong').modal('show');
}

// Cập nhật thông tin địa điểm đang hiển thị trên modal.
function saveFlag() {
    if ($("#f_update_ddiem").valid()) {
        $.ajax({
            url: '/save_flag',
            type: 'POST',
            data: $("#f_update_ddiem").serialize(),
            success: function( result ) {
                thongBaoKetQua(result, "Cập nhật thông tin thành công");
            },
            error: function( xhr, err ) {
                thongBaoKetQua("fail");
            }
        });       
    }
}

// Giữ chuột lên dòng dữ liệu.
function holdMouseData(element) {
    tr_dbclick = element.closest('tr');
    show_InfoDiaDiem(element);
}

// Xử lý các sự kiện sau khi load xong page.
$(document).ready(function(){

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
        namhoc = $(this).closest('tr').children('td').eq(2).text();
        removeDiaDiem(id, ten_diadiem, namhoc, $(this));
    });

    $(".btn_modal_remove_truong").click(function(event) {
        id = $("#id_ddiem").val();
        ten_diadiem = $("#ten_diadiem").val();
        namhoc = $("#namhoc").val();
        removeDiaDiem(id, ten_diadiem, namhoc, $(this));
    });

    $(".btn_edit_truong").click(function(event) {
        show_InfoDiaDiem($(this));
    });

    $("#btn_save_flag").click(function(event) {
        saveFlag();
    });

    // Đúp chuột lên dòng dữ liệu.
    $('.data_account').dblclick(function() {
        holdMouseData($(this));
    });
});