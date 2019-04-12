@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Two-Factor Authentication') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url(config('laravauth.validator_route')) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="{{ laravauth_token_var_name() }}" class="col-md-4 col-form-label text-md-right">{{ __('SMS Token') }}</label>

                                <div class="col-md-6">
                                    <input id="{{ laravauth_token_var_name() }}" type="text" class="form-control{{ $errors->has(laravauth_token_var_name()) ? ' is-invalid' : '' }}" name="{{ laravauth_token_var_name() }}" value="{{ old(laravauth_token_var_name()) }}" required autofocus>

                                    @if ($errors->has(laravauth_token_var_name()))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first(laravauth_token_var_name()) }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
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
