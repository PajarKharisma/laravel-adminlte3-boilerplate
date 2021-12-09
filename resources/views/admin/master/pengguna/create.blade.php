@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengguna</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include('errors.list')
    {!! Form::open(['method' => 'POST', 'url' => url('/admin/master-pengguna/save'), "enctype" => "multipart/form-data"]) !!}
        @include('admin.master.pengguna._form')
    {!! Form::close() !!}
</div>
@endsection

@section('styles')
{!! Html::style("lte/plugins/select2/css/select2.min.css") !!}
{!! Html::style("lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") !!}
@endsection

@section('scripts')
{!! Html::script('lte/plugins/select2/js/select2.full.min.js') !!}
{!! Html::script('lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $(function () {
            bsCustomFileInput.init();
        });
    });
</script>
@endsection