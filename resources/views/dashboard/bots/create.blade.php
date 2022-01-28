@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{ __('Создать боти') }}</div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div style="color: red">{{$error}}</div>
                        @endforeach
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('bots.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label>Биржа</label>
                                <select name="exchange" id="" class="form-control">
                                    @foreach($bots as $bot)
                                        <option value="{{$bot->id}}">{{$bot->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label>Депозит</label>
                                <input type="number" min="1" max="100"  class="form-control" name="deposit" required/>
                            </div>
                            <div class="form-group row">
                                <label>Процент дохода(%)</label>
                                <input type="number" min="1" max="100" class="form-control" name="percentage" required/>
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
