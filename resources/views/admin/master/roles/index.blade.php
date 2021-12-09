@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <label class="col-sm-12 col-md-9 col-lg-9 col-form-label">Hak Akses</label>
            <div class="col-sm-12 col-md-3 col-lg-3 float-right">
                <a href="{{ url('admin/master-roles/create') }}" class="btn btn-primary float-right"> {{ ('+ Tambah Data') }} </a>
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
        </div>
        <br>
        @if(isset($list) && $list->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <form action="{{ url('admin/master-roles/deletebatch') }}" method="POST" id="form_delete">
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
                                        <th rowspan="2"> Name  </th>
                                        <th rowspan="2"> Display Name </th>
                                        <th rowspan="2"> Description </th>
                                        <th class="text-center" colspan="2"> Aksi </th>
                                    </tr>
                                    <tr class="bg-primary">
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
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->display_name }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td class="text-center">
                                            <a class="text-orange mr-2" data-toggle="tooltip" data-placement="top"
                                                title="edit data"
                                                href="{{ url('admin/master-roles/edit/'.$value->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a class="delete-btn text-red mr-2" href="#" data-href="{{ url('admin/master-roles/delete/'.$value->id) }}">
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
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-red">
				<b>Hapus Data</b>
			</div>
			<div class="modal-body">
				Apakah anda yakin akan menghapus data ini ?!!!
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a class="btn btn-danger text-white btn-ok">Hapus</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-delete-all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-red">
				<b>Hapus Data</b>
			</div>
			<div class="modal-body">
				Apakah anda yakin akan menghapus seluruh data ini ?!!!
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a class="btn btn-danger text-white btn-ok">Hapus</a>
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
