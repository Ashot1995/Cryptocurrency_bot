@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>{{ __('Мои биржи') }}</div>
                    <div class="card-body">
                        <div class="row">
                          <a href="{{ route('notes.create') }}" class="btn btn-primary m-2">{{ __('Добавить') }}</a>
                        </div>
                        <br>
                        <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>Биржа</th>
                            <th>API ключ</th>
                            <th>Удалить</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($notes as $note)
                            <tr>
                              <td><strong>{{ $note->exchange }}</strong></td>
                              <td><strong>{{ $note->key }}</strong></td>
                                <td>
                                <form action="{{ route('notes.destroy', $note->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-block btn-danger">Удалить</button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $notes->links() }}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection

