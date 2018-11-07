@extends('master')

@section('title', 'hỗ trợ tuyển sinh')

@section('content')

    <!-- Chèn menu -->
    @include('menu')

    <style type="text/css">
        .highlight { background-color: yellow }
    </style>
	
    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        $(".navbar-nav > li").eq(2).addClass("active");

        // Tạo biến lưu session tài khoản đang đăng nhập vào javascript.
        var session_uname = '{{ \Session::get("uname") }}';
    </script>

    <!-- Form tìm kiếm tài khoản -->
    <div class="form-inline pull-right">
        <div class="input-group">
            <input type="text" class="form-control" id="search_input" placeholder="Tìm tài khoản">
            <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="btn_cancer_search">
                X
            </button>
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
                        <th>Thao tác</th>
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
                                <button type="button" class="btn btn-warning btn_update_account">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    <!-- Sửa -->
                                </button>
                                <button type="button" class="btn btn-danger btn_delete_account">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    <!-- Xóa -->
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
            </div>
            <div class="modal-body">
                <form action="" id="f_update_account" method="POST">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="uname">Tên tài khoản:</label>
                        <input type="text" class="form-control" id="uname" name="uname" autofocus="" required="" 
                        oninvalid="this.setCustomValidity('Chưa nhập tên tài khoản')"
                        oninput="setCustomValidity('')">
                        <input type="hidden" name="_uname" id="_uname" value="">
                    </div>
                    <div class="form-group" >
                        <label for="hoten">Họ tên:</label>
                        <input type="text" class="form-control" name="hoten" id="hoten" required="" 
                        oninvalid="this.setCustomValidity('Chưa nhập họ tên')"
                        oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label for="level">Mức quyền:</label>
                        <select class="form-control" id="level" name="level">
                            <option value="1" selected>Quản trị viên</option>
                            <option value="2">Nhân viên tuyển sinh</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn_submit"></button>
                        <button type="button" class="btn btn-danger" id="btn_del_acc_model">
                            <span class="glyphicon glyphicon-trash"></span>
                            Xóa
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
        </div>
        </div>
        
        <!-- Script xử lý js trên trang account -->
        <script type="text/javascript" src="./js/highlight.js"></script>
        <script type="text/javascript" src="./js/account.js"></script>
@endsection