// Biến lưu trạng thái form update tài khoản: 
// 0-các giá trị đã nhập đúng, 1-Có giá trị nhập không hợp lệ
var form_status = 0;

// Xử lý sự kiện bấm nút tạo tài khoản.
$("#btn_add_account").click(function(event) {
	$('#f_update_account').attr('action', '/add_account');
	$(".modal-title").text('Tạo tài khoản mới');
	$("#btn_submit").removeClass('btn-primary').addClass('btn-success');

	// Đặt lại giá trị form, mở khóa trường tên tài khoản.
	$("#uname").val("");
	$("#hoten").val("");
	$("#level").val("1");
	$("input").removeAttr('disabled');

	$("#btn_submit").html("<span class='glyphicon glyphicon-plus'></span>Thêm");
	$('#modal_account').modal('show');
});

// Chuyển giá trị level về số.
function getLevelValue(level_text) {
	if (level_text == "Quản trị viên") {
		return 1;
	}

	if (level_text == "Nhân viên tuyển sinh") {
		return 2;
	}
}

// Xử lý sự kiện bấm nút sửa.
$(".btn_update_account").click(function(event) {
	$('#f_update_account').attr('action', '/update_account');
	$(".modal-title").text('Cập nhật tài khoản');
	$("#btn_submit").removeClass('btn-success').addClass('btn-primary');

	// lấy các thông tin tài khoản.
	uname = $(this).closest('tr').children('td').eq(0).html();
	hoten = $(this).closest('tr').children('td').eq(1).html();
	level = $(this).closest('tr').children('td').eq(2).text();
	level = getLevelValue(level);

	// Hiển thị thông tin tài khoản lên form, khóa trường tên tài khoản.
	$("#uname").val(uname);
	$("#_uname").val(uname);
	$("#hoten").val(hoten);
	$("#level").val(level);
	$("#uname").prop("disabled", "disabled");

	$("#btn_submit").html("<span class='glyphicon glyphicon-save'></span>Lưu");
	$('#modal_account').modal('show');
});

// Gửi yêu cầu xóa tài khoản.
function deleteAccount(uname, element) {
	$.ajax({
		url: '/delete_account',
		type: 'POST',
		data: {
			_token: $('input[name="_token"]').val(),
			uname: uname
		},
        success: function( result ) {
        	if (result == "ok") {
        		element.closest('tr').remove();

        		if ( $("tr").length == 0) {
        			$("tbody").append('<tr> \
                        <td colspan="4" style="font-style: inherit; font-weight: bold; text-align: center;">Danh sách rỗng</td>\
                        </tr>'
                    );
        		}
        	}
        	if (result == "fail") {
        		alert("Có lỗi trong quá trình xử lý, vui lòng thử lại sau");
        	}
        },
        error: function( xhr, err ) {
            alert('Error');
        }
	});
}

// Xử lý sự kiện bấm nút xóa.
$(".btn_delete_account").click(function(event) {
	// lấy các thông tin tài khoản cần xóa.
	uname = $(this).closest('tr').children('td').eq(0).text();
	hoten = $(this).closest('tr').children('td').eq(1).text();

	if (session_uname == uname) {
		alert("Không thể xóa tài khoản của chính mính.");
	}
	else{
		result = confirm("Xóa tài khoản " + hoten);
		if (result) {
			deleteAccount(uname, $(this));	
		}	
	}	
});

// ==================================================================================================================
// === PHẦN KIỂM TRA THÔNG TIN ĐÃ NHẬP TRÊN FORM UPDATE ACCOUNT =====================================================
// ==================================================================================================================

// Gửi yêu cầu kiểm tra tên tài khoản đã tồn tại chưa.
function checkAccount(uname) {
	$.ajax({
		url: '/checkaccount',
		type: 'POST',
		data: {
			_token: $('input[name="_token"]').val(),
			uname: uname
		},
        success : function( data ) {
        	if (data == 1) {
            	$("#uname").closest('div').removeClass('has-success').addClass('has-error');
            	$("#uname").next("span").remove();
            	$("#uname").after('<span style="font-weight: bold; font-style: inherit; color: red">Tài khoản đã tồn tại</span>');
            	form_status = 1;
            } else {
            	$("#uname").closest('div').removeClass('has-error').addClass('has-success');
            	$("#uname").next("span").remove();
            	form_status = 0;
            }
        },
        error   : function( xhr, err ) {
            alert('Error');
        }
	});
}

// Kiểm tra sự tồn tại của tài khoản sau khi nhập tên tài khoản.
$("#uname").focusout(function() {
	if ($("#uname").val() != "") {
		checkAccount( $("#uname").val() );
	}
});

// Kiểm tra độ dài họ tên có vượt quá 100 kí tự không.
$("#hoten").focusout(function() {
	if ($("#hoten").val().length > 100) {
    	$("#hoten").closest('div').removeClass('has-success').addClass('has-error');
    	$("#hoten").next("span").remove();
    	$("#hoten").after('<span style="font-weight: bold; font-style: inherit; color: red">Họ tên tối đa 100 kí tự</span>');
    	form_status = 1;
    } else {
    	$("#hoten").closest('div').removeClass('has-error').addClass('has-success');
    	$("#hoten").next("span").remove();
    	form_status = 0;
    }
});

// Kiểm tra thông tin form đã hợp lệ hay chưa trước khi submit.
$(document).ready(function() {
    $("#f_update_account").one('submit', function(event) {
	    if ( form_status != 0 ) {
    		$(".has-error").eq(0).children('input').focus();
			event.preventDefault();
		}
		else{
			$(this).submit();
		}
	});
});

// ==================================================================================================================