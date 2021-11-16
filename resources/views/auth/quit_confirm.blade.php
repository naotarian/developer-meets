@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">退会確認</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('quit_post') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">ユーザー名</label>

                            <div class="col-md-6">
                                <span class="">{{$user->user_name}}</span>
                                <input type="hidden" name="user_name" value="{{$user->user_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                            <div class="col-md-6">
                                <span class="">{{$user->email}}</span>
                                <input type="hidden" name="email" value="{{$user->email}}">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    退会する
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection