@extends('master')

@section('title', 'hỗ trợ tuyển sinh')

@section('content')

    <!-- Chèn menu -->
    @include('menu')
	
    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        $(".navbar-nav > li").eq(2).addClass("active");
    </script>

    <center>
        <h3 style="padding-top: 2%">Danh sách người dùng</h3>
        <?php
            $count = count($acc_list);
        ?>
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
                    @for ($i = 0; $i < $count; $i++)
                        <tr>
                            <td>{{ $acc_list[$i]->uname }}</td>
                            <td>{{ $acc_list[$i]->hoten }}</td>
                            <td>{{ $acc_list[$i]->ten_level }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_account">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Sửa
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-trash"></span>
                                    Xóa
                            </button>
                            </td>
                        </tr>
                    @endfor                    
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
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <form action="/action_page.php">
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd">
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
        </div>
    </center>

@endsection