// Thời gian giữ chuột.
var timeoutId = 0;

// Dòng dữ liệu đang được giữ đúp chuột để edit.
var tr_dbclick = null;

// Bấm nút tạo tài khoản.
$("#btn_add_account").click(function(event) {
	$('#f_update_account').attr('action', '/add_account');
	$("#modal_account .modal-title").text('Tạo tài khoản mới');

	// Đặt lại giá trị form, mở khóa trường tên tài khoản.
	$("#uname").val("");
	$("#hoten").val("");
	$("#level").val("1");
	$("input").removeAttr('disabled');
	$("#uname").closest('div').removeClass('has-error');
	$("#uname").closest('div').removeClass('has-success');
	$("#hoten").closest('div').removeClass('has-error');
	$("#hoten").closest('div').removeClass('has-success');

	// Ẩn button xóa tài khoản, hiện phần nhập mật khẩu.
	$("#btn_del_acc_model").hide();
	$("#pass_default").show();

	$("#btn_submit").html("<span class='glyphicon glyphicon-plus'></span>Tạo");
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

// Chuẩn bị model click nút sửa.
function clickNutSua(element) {
	$('#f_update_account').attr('action', '/update_account');
	$("#modal_account .modal-title").text('Cập nhật tài khoản');

	// lấy các thông tin tài khoản.
	uname = element.closest('tr').children('td').eq(0).text();
	hoten = element.closest('tr').children('td').eq(1).text();
	level = element.closest('tr').children('td').eq(2).text();
	level = getLevelValue(level);

	// Hiển thị thông tin tài khoản lên form, khóa trường tên tài khoản.
	$("#uname").val(uname);
	$("#_uname").val(uname);
	$("#hoten").val(hoten);
	$("#level").val(level);
	$("#uname").prop("disabled", "disabled");
	$("#uname").next("span").remove();
	$("#hoten").next("span").remove();
	$("#uname").closest('div').removeClass('has-error');
	$("#uname").closest('div').removeClass('has-success');
	$("#hoten").closest('div').removeClass('has-error');
	$("#hoten").closest('div').removeClass('has-success');

	// Hiện button xóa tài khoản, ẩn phần nhập mật khẩu.
	$("#btn_del_acc_model").show();
	$("#pass_default").hide();

	$("#btn_submit").html("<span class='glyphicon glyphicon-save'></span>Lưu");
	$('#modal_account').modal('show');
}

// Bấm nút sửa.
$(".btn_update_account").click(function(event) {
	clickNutSua($(this));
});

// Bấm nút reset mật khẩu.
$(".btn_reset_pass").click(function(event) {
	// lấy các thông tin tài khoản.
	uname = $(this).closest('tr').children('td').eq(0).text();
	$("#_uname_reset").val(uname);

	$('#modal_reset_pass').modal('show');
});

// Gửi yêu cầu xóa tài khoản theo uname.
function deleteAccount(uname) {
	$.ajax({
		url: '/delete_account',
		type: 'POST',
		data: {
			_token: $('input[name="_token"]').val(),
			uname: uname
		},
        success: function( result ) {
        	if (result == "ok") {

        		// Xóa dòng dữ liệu vừa chứa data cần xóa trên màn hình.
        		tr_dbclick.remove();

        		// Ẩn form account.
        		$('#modal_account').modal('hide');

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

// Bấm nút xóa.
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
			tr_dbclick = $(this).closest('tr');
			deleteAccount(uname);
		}	
	}	
});

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

// Giữ chuột lên dòng dữ liệu.
function holdMouseData(element) {

	// Lấy button sửa tại dòng vừa giữ chuột.
	element = element.closest('.data_row');
	element = element.children('td');
	count = element.length;
	element = element.eq(count - 1);
	element = element.children('.btn_update_account');

	tr_dbclick = element.closest('tr');
	clickNutSua(element);
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

	// Đúp chuột lên dòng dữ liệu.
	$('.data_account').dblclick(function() {
		holdMouseData($(this));
	});

	// Xóa tài khoản từ model update.
	$("#btn_del_acc_model").click(function(event) {

		// lấy các thông tin tài khoản cần xóa.
		uname = $("#uname").val();
		hoten = $("#hoten").val();

		if (session_uname == uname) {
			alert("Không thể xóa tài khoản của chính mính.");
		}
		else{
			result = confirm("Xóa tài khoản " + hoten);
			if (result) {
				deleteAccount(uname);	
			}	
		}	
	});

	$("#f_update_account").keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
        	if ($("#f_update_ddiem").valid()) {
            	$("#f_update_account").submit();
        	}
        }
    });
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
            } else {
            	$("#uname").closest('div').removeClass('has-error').addClass('has-success');
            	$("#uname").next("span").remove();
            }
        },
        error   : function( xhr, err ) {
            alert('Error');
        }
	});
}

// Kiểm tra sự tồn tại của tài khoản sau khi nhập tên tài khoản.
$("#uname").on('input',function(e){
	if ($("#uname").val() != "") {
		checkAccount( $("#uname").val() );
	}
});

// Kiểm tra độ dài họ tên có vượt quá 100 kí tự không.
$("#hoten").on('input',function(e){
	if ($("#hoten").val().length > 100) {
    	$("#hoten").closest('div').removeClass('has-success').addClass('has-error');
    	$("#hoten").next("span").remove();
    	$("#hoten").after('<span style="font-weight: bold; font-style: inherit; color: red">Họ tên tối đa 100 kí tự</span>');
    } else {
    	$("#hoten").closest('div').removeClass('has-error').addClass('has-success');
    	$("#hoten").next("span").remove();
    }
});

// Kiểm tra thông tin form đã hợp lệ hay chưa trước khi submit.
$(document).ready(function() {
    $("#f_update_account").on('submit', function(event) {
	    if ( $("#f_update_account").valid() == true 
    	&& $("#uname").next("span").length == 0
    	&& $("#hoten").next("span").length == 0) {
			$(this).unbind('submit').submit();
		}
		else{
			event.preventDefault();
		}
	});
});

// ==================================================================================================================