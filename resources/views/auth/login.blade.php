@extends('layouts.app_login')
@section('content')
    <section id="view-signin">
        <div class="col-md-4 col-md-offset-4">
            <div class="col-md-10 col-md-offset-1">
                {!! Form::open(['url'=>'post/login','method'=>'POST','class'=>'form-signin']) !!}
                    <div class="form-group text-center">
                        <br>
                        <br>
                        <h2 class="form-signin-heading text-muted">@lang('messages.signin')</h2>
                        <br>
                    </div>
                    <div class="form-group text-center">
                        <div class="thumbnail" style="background-color: transparent;border:0;">
                            <img src="{{ asset('images/upload.png') }}" alt="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="sr-only">@lang('messages.email')</label>
                        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="@lang('messages.email')"
                               required="" autofocus="">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="sr-only">@lang('messages.password')</label>
                        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="@lang('messages.password')" required=""/>
                        <div class="checkbox">
                            <label>
                                <input name="rememberme" type="checkbox" value="remember-me"> <span>@lang('messages.rememberme')</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group-lg">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">@lang('messages.login')</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection