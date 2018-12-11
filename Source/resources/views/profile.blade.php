@extends('master')

@section('title', 'Thông tin cá nhân')

@section('content')

    <!-- Chèn menu -->
    @include('menu')
  
    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        @if(\Session::get("ulevel") == "1")
            $(".navbar-nav > li").eq(4).addClass("active");
        @endif

        @if(\Session::get("ulevel") == "2")
            $(".navbar-nav > li").eq(2).addClass("active");
        @endif
        // Tạo biến lưu session tài khoản đang đăng nhập vào javascript.
        var session_uname = '{{ \Session::get("uname") }}';

    </script>

    <div class="container-fluid">
        <div class="row">
            @if($change_pass_error != 0)
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $("#link_tab_info").closest('li').removeClass('active');
                        $("#link_tab_change_pass").closest('li').addClass('active');
                        $('.tab-pane').eq(1).addClass('active');

                        var message = '\
                            <div class="alert alert-danger alert-dismissible" id="danger-alert">\
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                            Mật khẩu cũ không đúng.\
                            </div>\
                            <script>\
                            $("#danger-alert").fadeTo(1000, 500).slideUp(500, function(){\
                                $("#danger-alert").slideUp(500);\
                            });\
                            <\/script>\
                        ';

                        @if($change_pass_error == 2)
                        var message = '\
                            <div class="alert alert-warning alert-dismissible" id="warning-alert">\
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                            Có lỗi ở máy chủ, vui lòng thử lại.\
                            </div>\
                            <script>\
                            $("#warning-alert").fadeTo(1000, 500).slideUp(500, function(){\
                                $("#warning-alert").slideUp(500);\
                            });\
                            <\/script>\
                        ';
                        @endif

                        @if($change_pass_error == 3)
                        var message = '\
                            <div class="alert alert-success alert-dismissible" id="success-alert">\
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                            Cập nhật mật khẩu thành công.\
                            </div>\
                            <script>\
                            $("#success-alert").fadeTo(1000, 500).slideUp(500, function(){\
                                $("#success-alert").slideUp(500);\
                            });\
                            <\/script>\
                        ';
                        @endif

                        $(message).insertBefore('#f_change_pass');
                    });
                </script>
            @endif

            @if($update_info != 0)
                <script type="text/javascript">
                    jQuery(document).ready(function($) {

                        $("#link_tab_info").closest('li').addClass('active');
                        $("#link_tab_change_pass").closest('li').removeClass('active');
                        $('.tab-pane').eq(0).addClass('active');

                        var message = '\
                            <div class="alert alert-success alert-dismissible" id="success-alert">\
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                            Cập nhật thông tin thành công.\
                            </div>\
                            <script>\
                            $("#success-alert").fadeTo(1000, 500).slideUp(500, function(){\
                                $("#success-alert").slideUp(500);\
                            });\
                            <\/script>\
                        ';

                        @if($update_info == 2)
                        var message = '\
                            <div class="alert alert-error alert-dismissible" id="error-alert">\
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                            Có lỗi ở máy chủ, vui lòng thử lại.\
                            </div>\
                            <script>\
                            $("#error-alert").fadeTo(1000, 500).slideUp(500, function(){\
                                $("#error-alert").slideUp(500);\
                            });\
                            <\/script>\
                        ';
                        @endif

                        $(message).insertBefore('#f_update');
                    });
                </script>
            @endif


            <!-- Phần tên và ảh -->
            <div class="col-xs-12 col-sm-3">
                <h1>{{ $user_info[0]->hoten }}</h1>
                <img src="" id="img_profile" class="img-responsive img-rounded" style="width: 100%">

                @if($user_info[0]->uname == \Session::get('uname'))
                <form id="f_upload_avt" method="POST" action="/upload_avt" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_uname_avt" id="_uname_avt" value="{{ $user_info[0]->uname }}">
                    <input type="file" id="selectedFile" name="img_avt" style="display: none;" accept="image/x-png,image/gif,image/jpeg">
                    <button type="button" class="btn btn-primary btn-block" id="btn_upload_avt">
                        <i class="fa fa-upload" aria-hidden="true"></i>
                        Cập nhật ảnh đại diện
                    </button>
                </form>
                @endif
                <hr class="col-xs-12">
                <div>
                    @if($user_info[0]->level == '1')
                        <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-user-o fa-2x" aria-hidden="true"></i>
                    @endif
                    <h3 style="display: inline">{{ $user_info[0]->ten_level }}</h3>
                </div>                
                <div class="col-xs-12">
                    {{ $user_info[0]->ghichu }}
                </div>
                <hr class="col-xs-12">
            </div>                

            @if( ( $user_info[0]->uname == \Session::get('uname') ) || (\Session::get('ulevel') == "1") )
            <!-- Phần menu tab thông tin và tab đổi mật khẩu -->
            <div class="col-xs-12 col-sm-9">

                <!-- Nav tabs -->
                <div class="card">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab_info" aria-controls="info" role="tab" data-toggle="tab" id="link_tab_info">
                            Thông tin cơ bản
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_change_pass" aria-controls="change_pass" role="tab" data-toggle="tab" id="link_tab_change_pass">
                            Đổi mật khẩu
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab_info">
                    <form action="/update_account" method="POST" class="col-xs-12 col-sm-5" id="f_update">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="uname">Tên tài khoản</label>
                            <input type="text" class="form-control" id="uname" name="uname" autofocus="" 
                            value="{{ $user_info[0]->uname }}" 
                            required="" 
                            oninvalid="this.setCustomValidity('Chưa nhập tên tài khoản')"
                            oninput="setCustomValidity('')"
                            autofocus=""
                            disabled="">
                            <input type="hidden" name="_uname" id="_uname" value="{{ $user_info[0]->uname }}">
                            <input type="hidden" name="page" id="page" value="profile">
                        </div>
                        <div class="form-group" >
                            <label for="hoten">Họ tên</label>
                            <input type="text" class="form-control" name="hoten" id="hoten" required="" 
                            value="{{ $user_info[0]->hoten }}" 
                            oninvalid="this.setCustomValidity('Chưa nhập họ tên')"
                            oninput="setCustomValidity('')">
                        </div>
                        @if(\Session::get('ulevel') == "1")
                        <div class="form-group">
                            <label for="level">Mức quyền</label>
                            <select class="form-control" id="level" name="level">
                                <option value="1">Quản trị viên</option>
                                <option value="2">Nhân viên tuyển sinh</option>
                            </select>
                        </div>

                        <script type="text/javascript">
                            $("#level").val('{{ $user_info[0]->level }}');
                        </script>

                        @else
                            <input type="hidden" name="level" id="level" value="{{ $user_info[0]->level }}">
                        @endif
                        
                        <hr>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success" id="btn_update">
                                <span class="glyphicon glyphicon-save"></span>
                                Cập nhật
                            </button>
                            @if(\Session::get("ulevel") == '1')
                            <button type="button" class="btn btn-danger" id="btn_del_acc_model">
                                <span class="glyphicon glyphicon-trash"></span>
                                Xóa
                            </button>
                            @endif
                        </div>
                        
                    </form>
                    </div>

                    <!-- Phần đổi mật khẩu -->
                    <div role="tabpanel" class="tab-pane" id="tab_change_pass">
                    <form class="form-horizontal col-xs-12 col-sm-5" action="/change_pass" method="POST" id="f_change_pass">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_uname_pass" id="_uname_pass" value="{{ $user_info[0]->uname }}">
                        <label class="control-label" for="old_pass">Mật khẩu cũ</label>
                        <div class="input-group">                            
                            <input id="old_pass" name="old_pass" type="password" placeholder="" class="form-control input-md">
                            <span class="input-group-addon">
                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                            </span>
                        </div>

                        <label class="control-label" for="new_pass">Mật khẩu mới</label>
                        <div class="input-group">                            
                            <input id="new_pass" name="new_pass" type="password" placeholder="" class="form-control input-md">
                            <span class="input-group-addon">
                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                            </span>
                        </div>

                        <label class="control-label" for="re_new_pass">Nhập lại mật khẩu mới</label>
                        <div class="input-group">                            
                            <input id="re_new_pass" name="re_new_pass" type="password" placeholder="" class="form-control input-md">
                            <span class="input-group-addon">
                                <i class="fa fa-toggle-off" aria-hidden="true"></i>
                            </span>
                        </div>

                        <!-- Button (Double) -->
                        <hr>
                        <div class="input-group pull-right">
                            <label class="control-label" for="bCancel"></label>
                            <button type="submit" id="btn_change_pass" name="bCancel" class="btn btn-danger">
                                <span class="glyphicon glyphicon-save"></span>
                                Cập nhật
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            @else
                <h1>Bạn không thể xem được thông tin của người dùng khác.</h1>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
        
            var avt_profile = '{{ url("/") }}' + "/avt/" + '{{ $user_info[0]->uname }}' + ".png";
            $("#img_profile").attr('src', avt_profile);

            $("#img_profile").error(function () {
                if ( $(this).attr("src").indexOf("png") != -1 ) {
                    $(this).unbind("error").attr("src", $(this).attr("src").replace("png", "jpg"));
                }
                $("#img_profile").error(function () {
                    if ( $(this).attr("src").indexOf("jpg") != -1 ) {
                        $(this).unbind("error").attr("src", $(this).attr("src").replace("jpg", "gif"));
                    }
                    $("#img_profile").error(function () {
                        $(this).unbind("error").attr("src", "../img/no_avt.png");
                    });
                });
            });
        });
    </script>

    <script type="text/javascript" src="../js/profile.js"></script>
@endsection