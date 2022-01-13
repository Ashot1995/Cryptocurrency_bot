@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{ __('Создать боти') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bots.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label>Биржа</label>
                                <input class="form-control" type="text" placeholder="{{ __('Биржа') }}" name="exchange" required autofocus>
                            </div>

                            <div class="form-group row">
                                <label>API ключ</label>
                                <input type="text" class="form-control" name="key" required/>
                            </div>
                            <div class="form-group row">
                                <label>Даходы(%)</label>
                                <input type="text" class="form-control" name="secret_key" required/>
                            </div>

                            <button class="btn btn-block btn-success" type="submit">{{ __('создать') }}</button>
                            <a href="{{ route('bots.index') }}" class="btn btn-block btn-primary">{{ __('Return') }}</a>
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')

@endsection
