<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h1 class="m-0">Dashboard</h1> --}}
                @yield('header')
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (isset($breadcrumbs))    
                        @foreach ($breadcrumbs as $item)
                            <li class="breadcrumb-item">
                                @if ($item['link'] == 'javascript:void(0)')
                                    <strong>{{ $item['name'] }}</strong>
                                @else
                                    <a href="{{ url($item['link']) }}">{{ $item['name'] }}</a>
                                @endif
                            </li>    
                        @endforeach
                    @endif
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
