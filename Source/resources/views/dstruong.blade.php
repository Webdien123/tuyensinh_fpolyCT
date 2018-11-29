@extends('master')

@section('title', 'Danh sách trường')

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
    </script>

    <div class="modal fade" id="success-alert"  style="margin-top: 20%; text-align: center; z-index: 9999">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="modal-body">
                    <strong id="alert-text"></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Form tìm kiếm tài khoản -->
    <div class="form-inline pull-right">
        <div class="input-group">
            <input type="text" class="form-control" id="search_input" placeholder="Tìm trường">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="btn_cancer_search">x</button>
                <button class="btn btn-primary" type="button" id="btn_search">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>

    <center>
        <h3 style="padding-top: 2%">Danh sách trường</h3>
    </center>

    <?php
        $count = count($ddiem_list);
    ?>
    {!! csrf_field() !!}
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-condensed" style="background-color: #FFFFFF">
            <thead>
                <tr>
                    <th>Tên địa điểm</th>
                    <th>Địa chỉ</th>
                    <th>Chỉ số 1</th>
                    <th>Chỉ số 2</th>
                    <th>Ghi chú</th>
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
                    	<input type="hidden" class="form-control" value="{{ $ddiem_list[$i]->id }}">
                        <td class="data_account">{{ $ddiem_list[$i]->ten_diadiem }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->diachi }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->chiso1 }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->chiso2 }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->ghichu }}</td>
                        <td>
                            @if(\Session::get("ulevel") == "1")
                            <!-- Xóa -->
                            <button type="button" class="btn btn-danger btn_remove_truong" title="Xóa trường">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                            @endif
                        </td>
                    </tr>
                @endfor
                @endif

            </tbody>
        </table>
    </div>

    <!-- Script xử lý js trên trang account -->
    <script type="text/javascript" src="./js/highlight.js"></script>
    <script type="text/javascript" src="./js/dstruong.js"></script>

@endsection