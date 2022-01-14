@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>{{ __('Управление ботами') }}</div>
                    <div class="card-body">
                        <div class="row">
                          <a href="{{ route('bots.create') }}" class="btn btn-primary m-2">{{ __('Добавить') }}</a>
                        </div>
                        <br>Account
                        <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>Биржа</th>
                            <th>Дата старта</th>
                            <th>Депозит</th>
                            <th>Процент дохода</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($bots as $note)
                            <tr>
                              <td><strong>{{ $note->exchange }}</strong></td>
                              <td><strong>{{ $note->created_at }}</strong></td>
                              <td><strong>{{ $note->deposit }}</strong></td>
                              <td><strong>{{ $note->percentage }}%</strong></td>
{{--                                <td>--}}
{{--                                <form action="{{ route('bots.destroy', $note->id ) }}" method="POST">--}}
{{--                                    @method('DELETE')--}}
{{--                                    @csrf--}}
{{--                                    <button class="btn btn-block btn-danger">Удалить</button>--}}
{{--                                </form>--}}
{{--                              </td>--}}
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $bots->links() }}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection

