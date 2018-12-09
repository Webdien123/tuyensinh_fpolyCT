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

    <!-- Form tìm kiếm trường -->
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
                    <th>Năm tuyển sinh</th>
                    <th>Chỉ số 1</th>
                    <th>Chỉ số 2</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @if ($count == 0)
                    <tr>
                        <td colspan="6" style="font-style: inherit; font-weight: bold; text-align: center;">Danh sách rỗng</td>
                    </tr>
                @else
                @for ($i = 0; $i < $count; $i++)
                    <tr class="data_row">
                        <input type="hidden" class="form-control" value="{{ $ddiem_list[$i]->id }}">
                        <input type="hidden" class="form-control" value="{{ $ddiem_list[$i]->lat }}">
                    	<input type="hidden" class="form-control" value="{{ $ddiem_list[$i]->lng }}">
                        <td class="data_account">{{ $ddiem_list[$i]->ten_diadiem }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->diachi }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->namhoc }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->chiso1 }}</td>
                        <td class="data_account">{{ $ddiem_list[$i]->chiso2 }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn_edit_truong" title="Cập nhật thông tin">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <a href="/lsutuongtac/{{ $ddiem_list[$i]->id }}" class="btn btn-primary" title="Xem lịch sử tương tác">
                                <span class="glyphicon glyphicon-list"></span>
                            </a>
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

    <div class="modal fade" id="modal_truong">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thông tin trường</h4>
                    <div class="btn-group pull-right">
                        <button type="button" id="btn_save_flag" class="btn btn-success">
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Lưu
                        </button>
                        <button type="button" class="btn btn-danger btn_modal_remove_truong" title="Xóa trường">
                            <span class="glyphicon glyphicon-trash"></span>
                            Xóa
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Hủy
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="f_update_ddiem" class="form-horizontal" role="form">

                        {!! csrf_field() !!}
                        <input type="hidden" name="id_ddiem" id="id_ddiem" class="form-control" value="">
                        <input type="hidden" name="lat" id="lat" class="form-control" value="">
                        <input type="hidden" name="lng" id="lng" class="form-control" value="">

                        <label>Tên địa điểm</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="text" name="ten_diadiem" id="ten_diadiem" class="form-control" placeholder="nhập tên địa điểm">
                            </div>
                        </div>

                        <label>Địa chỉ</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="text" name="diachi" id="diachi" class="form-control" placeholder="nhập địa chỉ">
                            </div>
                        </div>

                        <label>Năm tuyển sinh</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="text" name="namhoc" id="namhoc" class="form-control" disabled="">
                            </div>
                        </div>
                        <input type="hidden" name="_namhoc" id="_namhoc" class="form-control" value="">

                        <label>Chỉ số 1</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso1" value="0" id="chiso1" class="form-control">
                            </div>
                        </div>

                        <label>Chỉ số 2</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso2" value="0" id="chiso2" class="form-control">
                            </div>
                        </div>

                        <label>Ghi chú</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea name="ghichu" id="ghichu" class="form-control" rows="3" placeholder="nhập ghi chú (nếu cần)"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script xử lý js trên trang account -->
    <script type="text/javascript" src="./js/highlight.js"></script>
    <script type="text/javascript" src="./js/dstruong.js"></script>

@endsection