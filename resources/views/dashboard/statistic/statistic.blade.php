@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>{{ __('Бот') }}</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>Биржа</th>
                                    <th>Дата создание</th>
                                    <th>Тип</th>
                                    <th>Мин. цена</th>
                                    <th>Макс. цена</th>
                                    <th>Тип</th>
                                    <th>Процент</th>
                                    <th>Статус</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bots as $bot)
                                    <tr>
                                        <td><strong>{{ $bot->name }}</strong></td>
                                        <td><strong>{{ $bot->created_at }}</strong></td>
                                        <td><strong>{{ $bot->type }}</strong></td>
                                        <td><strong>{{ $bot->min_price }}</strong></td>
                                        <td><strong>{{ $bot->max_price }}</strong></td>
                                        <td><strong>{{ $bot->safety_order_step_percentage }}</strong></td>
                                        <td><strong>{{ $bot->is_enabled ? 'Актив' : 'Не активно' }}</strong></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
