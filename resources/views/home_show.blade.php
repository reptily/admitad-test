@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @auth
                            <div id="app">
                                <div style="margin-bottom: 15px">Переходы: {{ $Url }}</div>

                                <table class="table">
                                    <tr class="table-active">
                                        <td>Дата/Время</td>
                                        <td>Браузер</td>
                                        <td>Версия</td>
                                        <td>Операционная система</td>
                                        <td>Устройство</td>
                                        <td>Язык</td>
                                        <td>IP адрес</td>
                                    </tr>

                                @foreach($History as $obj)
                                    <tr>
                                        <td>{{ $obj->created_at }}</td>
                                        <td>{{ $obj->browser }}</td>
                                        <td>{{ $obj->browser_version }}</td>
                                        <td>{{ $obj->platform }}</td>
                                        <td>{{ $obj->device == 0 ? 'Компьютер' : $obj->device }}</td>
                                        <td>{{ $obj->languages }}</td>
                                        <td>{{ $obj->ip }}</td>
                                    </tr>
                                @endforeach
                                    {{ $History->links() }}
                                </table>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
