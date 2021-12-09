@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hak Akses</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @include('errors.list')
    {!! Form::model($item,['method' => 'POST', 'url' => url('/admin/master-roles/update/'.$item->id)]) !!}
        @include('admin.master.roles._form')
    {!! Form::close() !!}
</div>
@endsection
