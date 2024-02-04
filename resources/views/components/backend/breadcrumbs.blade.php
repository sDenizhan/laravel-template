<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                    @if (count($links) > 0 )
                        @foreach ($links as $item )
                            @if ( !empty($item['url']) )
                                <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                            @else
                                <li class="breadcrumb-item">{{ $item['title'] }}</li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>