@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @auth
                        <div id="app">
                            <div style="margin-bottom: 15px">Выши ссылки:</div>
                            @foreach($Links as $obj)
                                <div style="margin-bottom: 15px">
                                    <span style="margin-right: 10px; color: grey"><i class="fa fa-bar-chart" aria-hidden="true"></i> {{ $obj->count_redirect }} </span>
                                    <a href="/home/{{ $obj->id }}">{{ request()->getSchemeAndHttpHost() }}/s/{{ $obj->key }}</a>
                                </div>
                            @endforeach
                            {{ $Links->links() }}
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
