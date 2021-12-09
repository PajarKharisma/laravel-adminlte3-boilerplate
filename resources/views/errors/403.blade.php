@extends('layouts.app', ['activePage' => 'error-handling', 'titlePage' => __('Error Handling')])
@section('content')
<?php
if(!isset($searchtext)){
	$searchtext = '';
}
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('Error') }}</h4>
                        <p class="card-category"> {{ __('') }}</p>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <br><br><br>
                            <strong>Anda tidak memiliki wewenang untuk mengakses halaman ini</strong>
                            <br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection