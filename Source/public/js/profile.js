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
        		$(location).attr('href', '/account');
        	}
        },
        error: function( xhr, err ) {
            alert('Error');
        }
	});
}

jQuery(document).ready(function($) {

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

	// Click nút đổi avatar.
	$("#btn_upload_avt").click(function(event) {
		$("#selectedFile").click();
	});

	// Xử lý sau khi nhận file avt mới.
	$("#selectedFile").change(function(event) {
		if ($("#selectedFile").val() != "") {
			$("#f_upload_avt").submit();
			
		}
	});

	$( "#f_change_pass" ).validate({
        rules: {
            old_pass: {
                required: true                
            },
            new_pass: {
                required: true                
            },
            re_new_pass: {
            	required: true,
            	equalTo: "#new_pass"
            }
        },

        messages: {
            old_pass: {
                required: "Chưa nhập mật khẩu cũ"
            },
            new_pass: {
                required: "Chưa nhập mật khẩu mới"                
            },
            re_new_pass: {
                required: "Chưa nhập lại mật khẩu mới",
                equalTo: "Xác nhận mật khẩu mới chưa khớp"
            }
        },

        errorPlacement: function (error, element) {
            error.css('color', '#FC4848');
            error.addClass('help-block');
            element.css('border', '2px solid #FC4848');
            var father_element = element.closest('.input-group');
            error.insertAfter(father_element);
        },

        highlight: function(element,errorClass,validClass){
            $(element).css('border', '2px solid #FC4848');
        },
                    
        unhighlight: function(element, errorClass, validClass) {
            $(element).css('border', '2px solid #41BE47');
        }
    });
});

// Click vào nút hiển thị mật khẩu.
$(".input-group-addon").click(function(event) {
	if ($(this).hasClass('success')){
		$(this).removeClass('success');
		$(this).children('.fa-toggle-on').removeClass('fa-toggle-on').addClass('fa-toggle-off');
		$(this).prev("input").prop("type", "password");
	}
	else{
		$(this).addClass('success');
		$(this).children('.fa-toggle-off').removeClass('fa-toggle-off').addClass('fa-toggle-on');
		$(this).prev("input").prop("type", "text");
	}
});

