@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">本会員登録</div>

                    @isset($message)
                        <div class="card-body">
                            {{$message}}
                        </div>
                    @endisset

                    @empty($message)
                        <div class="card-body">
                            {{Form::open(['route' => 'register.main.check', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
                                <input type="hidden" name="email_token" value="{{ $email_token }}">

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>
                                    <div class="col-md-6">
                                        {{Form::text('name', null, ['class' => 'form', 'id' => 'name', 'id' => 'name'])}}
                                        {{Form::text('name', null, ['class' => 'form', 'id' => 'name', 'id' => 'name'])}}
                                        {{Form::text('name', null, ['class' => 'form', 'id' => 'name', 'id' => 'name'])}}
                                        <!--<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>-->
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            確認画面へ
                                        </button>
                                    </div>
                                </div>
                            {{Form::close()}}
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </div>
@endsection