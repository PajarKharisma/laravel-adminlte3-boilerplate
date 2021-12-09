@extends('layouts.app')

@section('content')
<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <ul class="nav nav-tabs" id="custom-tabs-four-tabContent" role="tablist">
                    @foreach ($roles as $role)
                        @php
                            $is_active = $active_tab == $role->name ? 'active' : null;
                        @endphp    
                        <li class="nav-item">
                            <a class="nav-link {{ $is_active }}" href="{{ url('admin/master-pengguna/list/'.$role->name) }}" role="tab">{{ $role->display_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <div class="card-body">
        @if (session('status'))
            <div class="row alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="far fa-check-circle"></i> Sukses!</h5>
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <form class="col-sm-12 col-md-4 col-lg-4" action="" method="get">
                <input type="text" class="form-control" name="searchtext" id="searchtext" placeholder="Filter.." value="{{ $searchtext ?? null }}">
            </form>
            <div class="col-sm-12 col-md-8 col-lg-8 float-right">
                <a href="{{ url('admin/master-pengguna/create') }}" class="btn btn-primary float-right"> {{ ('+ Tambah Data') }} </a>
            </div>
        </div>
        <br>
        @if(isset($list) && $list->count() > 0)
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <form action="{{ url('admin/master-pengguna/deletebatch') }}" method="POST" id="form_delete">
                            @csrf
                            <table class="table table-striped table-advance table-bordered table-hover">
                                <thead>
                                    <tr class="bg-primary">
                                        <th width="5%" rowspan="2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check_all">
                                                <label class="custom-control-label" for="check_all">No</label>
                                            </div>
                                        </th>
                                        <th rowspan="2"> ID </th>
                                        <th rowspan="2"> Nama </th>
                                        <th rowspan="2"> Email </th>
                                        <th rowspan="2"> Hak Akses </th>
                                        <th class="text-center" colspan="3"> Aksi </th>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th class="text-center"> Reset </th>
                                        <th class="text-center"> Edit </th>
                                        <th class="text-center"> Hapus </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $index => $value)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input check_item" name="data[{{ $index }}]" value="{{ $value->id }}" id="check_item_{{ $index }}">
                                                <label class="custom-control-label" for="check_item_{{ $index }}">
                                                </label>
                                                {{ ($index + 1) + (($list->currentPage() - 1) * $list->perPage())}}
                                            </div>
                                        </td>
                                        <td>{{ $value->user->id ?? null }}</td>
                                        <td>{{ $value->user->name ?? null}}</td>
                                        <td>{{ $value->user->email ?? null }}</td>
                                        <td>
                                            @foreach ($value->user->roleUser as $item)
                                                <strong>-</strong> {{ $item->role->display_name }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <a class="reset-btn text-success mr-2" href="#" data-href="{{ url('admin/master-pengguna/resetpassword/'.$value->user_id) }}">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a class="text-orange mr-2" data-toggle="tooltip" data-placement="top"
                                                title="edit data"
                                                href="{{ url('admin/master-pengguna/edit/'.$value->user_id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a class="delete-btn text-red mr-2" href="#" data-href="{{ url('admin/master-pengguna/delete/'.$value->user_id) }}">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            {{ $list->links() }}
        @else
            <p><strong>DATA TIDAK DITEMUKAN</strong></p>
        @endif
    </div>
    
    <div class="card-footer">
        <div class="col-sm-12 col-md-12 col-lg-12 float-right">
            <a class="delete-all-btn btn btn-danger float-right disabled" id="btn_delete_all" href="#">Hapus Semua</a>
        </div>
    </div>
</div>


{{-- MODAL --}}
<div class="modal fade" id="new-password-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<b>Reset Password Berhasil</b>
			</div>
			<div class="modal-body">
				ID User		: <b id="id_reset"></b><br>
                Password	: <b id="password_reset"></b><br>
                <br>
                Jagalah Kerahasiaan Akun
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('styles')
{!! Html::style("lte/plugins/sweetalert2/sweetalert2.min.css") !!}
@endsection

@section('scripts')
{!! Html::script('lte/plugins/sweetalert2/sweetalert2.all.min.js') !!}
<script>
    $(document).ready(function () {
        $('.delete-btn').on('click', function (e) {
            e.preventDefault();
            var url = $(this).data('href');

            Swal.fire({
                icon: 'warning',
                text: 'Apakah anda yakin ingin menghapus data ini?',
                showCancelButton: true,
                confirmButtonText: "Iya, Hapus!",
                cancelButtonText: "Tidak, Batalkan!",
                confirmButtonClass: "btn btn-danger mt-2 text-white",
                cancelButtonClass: "btn btn-primary ml-2 mt-2 text-white",
                buttonsStyling: !1,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = url;
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        icon: "error",
                    });
                }
            });
        });

        $('.delete-all-btn').on('click', function (e) {
            e.preventDefault();
            var url = $(this).data('href');

            Swal.fire({
                icon: 'warning',
                text: 'Apakah anda yakin ingin menghapus seluruh data ini?',
                showCancelButton: true,
                confirmButtonText: "Iya, Hapus!",
                cancelButtonText: "Tidak, Batalkan!",
                confirmButtonClass: "btn btn-danger mt-2 text-white",
                cancelButtonClass: "btn btn-primary ml-2 mt-2 text-white",
                buttonsStyling: !1,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_delete').submit();
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        icon: "error",
                    });
                }
            });
        });

        $('.reset-btn').on('click', function (e) {
            e.preventDefault();
            var url = $(this).data('href');

            Swal.fire({
                icon: 'warning',
                text: 'Apakah anda yakin ingin me-reset data ini?',
                showCancelButton: true,
                confirmButtonText: "Iya, Reset!",
                cancelButtonText: "Tidak, Batalkan!",
                confirmButtonClass: "btn btn-danger mt-2 text-white",
                cancelButtonClass: "btn btn-primary ml-2 mt-2 text-white",
                buttonsStyling: !1,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        beforeSend: function () {
                            Swal.fire({
                                icon : 'info',
                                text: 'Harap Tunggu..'
                            });
                            Swal.showLoading();
                        },
                        complete: function () {
                        },
                        success: function(data){
                            Swal.fire({
                                timer: 1,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            var parsedData = JSON.parse(data);
                            if(parsedData.status == 1){
                                $('#id_reset').text(parsedData.user.user_id);
                                $('#password_reset').text(parsedData.user.password);
                                $('#new-password-modal').modal('show');
                            }else{
                                alert('Reset Password Failed!!');
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Dibatalkan',
                        icon: "error",
                    });
                }
            });
        });

        $('#check_all').on('change', function (e) {
            e.preventDefault();
            $('.check_item').prop("checked", this.checked);
            if(this.checked){
                $('#btn_delete_all').removeClass('disabled');
            } else {
                $('#btn_delete_all').addClass('disabled');
            }
        });

        var check_item = 0;
        $('.check_item').on('change', function (e) {
            e.preventDefault();
            if(this.checked){
                check_item++;
            } else {
                check_item--;
            }

            if(check_item > 0){
                $('#btn_delete_all').removeClass('disabled');
            } else {
                $('#btn_delete_all').addClass('disabled');
            }
        });
    });
</script>
@endsection
