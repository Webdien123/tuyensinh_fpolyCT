
@extends('master')

@section('title', 'Quản lý tài khoản')

@section('content')

    <!-- Chèn menu -->
    @include('menu')

    <!-- Chỉnh màu hightlight từ khóa sau khi tìm được. -->
    <style type="text/css">
        .highlight { background-color: #FEFD83 }
    </style>
	
    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        $(".navbar-nav > li").eq(1).addClass("active");

        // Tạo biến lưu session tài khoản đang đăng nhập vào javascript.
        var session_uname = '{{ \Session::get("uname") }}';
    </script>

    @if($show_alert == true)
        <div class="alert alert-{{ $alert_type }} alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $alert_message }}
        </div>
    @endif

    <!-- Form tìm kiếm tài khoản -->
    <div class="form-inline pull-right">
        <div class="input-group">
            <input type="text" class="form-control" id="search_input" placeholder="Tìm tài khoản">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="btn_cancer_search">x</button>
                <button class="btn btn-primary" type="button" id="btn_search">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>     

    <center>
        <h3 style="padding-top: 2%">Danh sách người dùng</h3>
    </center>
    <?php
        $count = count($acc_list);
    ?>
    <button type="button" class="btn btn-success" id="btn_add_account">
        <span class="glyphicon glyphicon-plus"></span>
        Tạo tài khoản
    </button>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-condensed" style="background-color: #FFFFFF">
            <thead>
                <tr>
                    <th>Tên tài khoản</th>
                    <th>Họ tên</th>
                    <th>Mức quyền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @if ($count == 0)
                    <tr>
                        <td colspan="4" style="font-style: inherit; font-weight: bold; text-align: center;">Danh sách rỗng</td>
                    </tr>
                @else                    
                @for ($i = 0; $i < $count; $i++)
                    <tr class="data_row">
                        <td class="data_account">{{ $acc_list[$i]->uname }}</td>
                        <td class="data_account">{{ $acc_list[$i]->hoten }}</td>
                        <td class="data_account">{{ $acc_list[$i]->ten_level }}</td>
                        <td>
                            <!-- Sửa -->
                            <button type="button" class="btn btn-warning btn_update_account" title="Chỉnh sửa thông tin">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>

                            <!-- Reset mật khẩu -->
                            <button type="button" class="btn btn-primary btn_reset_pass" title="Reset mật khẩu">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </button>

                            <!-- Xem thông tin chi tiết -->
                            <a class="btn btn-info btn_profile" title="Xem trang cá nhân"
                            href="/profile/{{ $acc_list[$i]->uname }}">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </a>

                            <!-- Xóa -->
                            <button type="button" class="btn btn-danger btn_delete_account" title="Xóa tài khoản">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                @endfor
                @endif

            </tbody>
        </table>
    </div>

    <!-- Modal thêm và sửa thông tin tài khoản-->
    <div id="modal_account" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Thông tin tài khoản</h4>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success" id="btn_submit" form="f_update_account"></button>
                <button type="button" class="btn btn-danger" id="btn_del_acc_model">
                    <span class="glyphicon glyphicon-trash"></span>
                    Xóa
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                    Đóng
                </button>
            </div>
        </div>
        <div class="modal-body">
            <form action="" id="f_update_account" method="POST">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="uname">Tên tài khoản</label>
                    <input type="text" class="form-control" id="uname" name="uname" autofocus="" required="" 
                    oninvalid="this.setCustomValidity('Chưa nhập tên tài khoản')"
                    oninput="setCustomValidity('')">
                    <input type="hidden" name="_uname" id="_uname" value="">
                </div>
                <div class="form-group" >
                    <label for="hoten">Họ tên</label>
                    <input type="text" class="form-control" name="hoten" id="hoten" required="" 
                    oninvalid="this.setCustomValidity('Chưa nhập họ tên')"
                    oninput="setCustomValidity('')">
                </div>
                <div class="form-group" id="pass_default">
                    <label for="pass">Mật khẩu</label>
                    <input type="text" class="form-control" name="pass" id="pass" value="123" required="" 
                    oninvalid="this.setCustomValidity('Chưa nhập mật khẩu')"
                    oninput="setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label for="level">Mức quyền</label>
                    <select class="form-control" id="level" name="level">
                        <option value="1" selected>Quản trị viên</option>
                        <option value="2">Nhân viên tuyển sinh</option>
                    </select>
                </div>
            </form>
        </div>
        
    </div>
    </div>
    </div>

    <div class="modal fade" id="modal_reset_pass">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Reset mật khẩu</h4>
                    <div class="btn-group pull-right">
                        <button type="submit" form="f_reset_pass" class="btn btn-danger">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            Reset
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Close
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="/reset_pass" id="f_reset_pass" method="POST" role="form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_uname_reset" id="_uname_reset" value="">
                        <div class="form-group">
                            <label for="">Mật khẩu mặc định</label>
                            <input type="text" value="123" class="form-control" id="pass_reset" name="pass_reset" placeholder="Mật khẩu reset">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
    
    <!-- Script xử lý js trên trang account -->
    <script type="text/javascript" src="./js/highlight.js"></script>
    <script type="text/javascript" src="./js/account.js"></script>
@endsection