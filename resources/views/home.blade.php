@extends('layout')

@section('content')
    <div class="container">
        {{ html()->form()->open() }}
        <div class="row">
            <div class="col-12 col-md-6 mx-auto pt-5">
                <legend>
                    <i class="fa fa-fw fa-door-open"></i> Welcome
                </legend>
                @if($errors->isNotEmpty())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row row-cols-lg-auto g-2 align-items-top">
                    <div class="col-12">
                        <div class="form-floating position-relative">
                            {{ html()->text('name')->class('form-control')->attribute('placeholder', '-') }}
                            <label for=""><i class="fa fa-fw fa-lg fa-user text-muted"></i> Nickname</label>
                        </div>
                        <small class="text-muted">* Only alpha dash</small>
                    </div>
                    <div class="col-12">
                        <div class="form-floating position-relative">
                            {{ html()->text('phone')->class('form-control')->attribute('placeholder', '-') }}
                            <label for=""><i class="fa fa-fw fa-lg fa-phone text-muted"></i> Phone</label>
                        </div>
                        <small class="text-muted">* Only +, numbers, whitespaces</small>
                    </div>
                    <div class="col-12">
                        {{ html()->submit('Register')->class('btn btn-lg btn-outline-primary') }}
                    </div>
                    @if($link)
                        <div class="alert alert-info mt-5 w-100">
                            Your lucky link is here:
                            <a href="{{ $link }}" class="alert-link">{{ $hash }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
@stop
