@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Konfigurasi Aplikasi</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::model($item, ['method' => 'POST', 'url' => url('/admin/config-app/update'), "enctype" => "multipart/form-data"]) !!}
    <div class="card-body">
        @if (session('status'))
        <div class="row alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Sukses!</b>
            &nbsp;{{ session('status') }}
        </div>
        @endif
        @include('errors.list')
        <div class="form-group">
            {!! Form::label('title', 'Username',['class'=> ''])!!}
            {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Masukan Nama Aplikasi']) !!}
        </div>
    
        <div class="form-group">
            <label for="customFile">Logo Aplikasi</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="logo" name="logo">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
    
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="#" data-href="{{ url('admin/config-app/reset') }}" class="reset-btn btn btn-danger">Reset Konfigurasi</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('styles')
{!! Html::style("lte/plugins/sweetalert2/sweetalert2.min.css") !!}
@endsection

@section('scripts')
{!! Html::script('lte/plugins/sweetalert2/sweetalert2.all.min.js') !!}
{!! Html::script('lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
<script>
    $(document).ready(function () {
        $(function () {
            bsCustomFileInput.init();
        });

        $('.reset-btn').on('click', function (e) {
            e.preventDefault();
            var url = $(this).data('href');

            Swal.fire({
                icon: 'warning',
                text: 'Apakah anda yakin ingin kembali ke konfigurasi default?',
                showCancelButton: true,
                confirmButtonText: "Iya, Reset!",
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
    });
</script>
@endsection