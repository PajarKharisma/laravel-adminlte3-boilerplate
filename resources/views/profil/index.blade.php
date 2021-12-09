@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengguna</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::model($item, ['method' => 'POST', 'url' => url('/profil/update/'), "enctype" => "multipart/form-data"]) !!}
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
            {!! Form::label('id', 'Username',['class'=> ''])!!}
            {!! Form::text('id', null, ['class' => 'form-control', 'id' => 'id', 'placeholder' => 'Masukan Username', "readonly" => isset($disabled) ? true : false]) !!}
        </div>
    
        <div class="form-group">
            {!! Form::label('name', 'Nama',['class'=> ''])!!}
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Masukan Nama']) !!}
        </div>
    
        <div class="form-group">
            {!! Form::label('email', 'Email',['class'=> ''])!!}
            {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Masukan Email']) !!}
        </div>
    
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password">
        </div>
    
    
        <div class="form-group">
            <label for="customFile">Foto Profil</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="foto" name="foto">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
    
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('styles')
@endsection

@section('scripts')
{!! Html::script('lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
<script>
    $(document).ready(function () {
        $(function () {
            bsCustomFileInput.init();
        });
    });
</script>
@endsection