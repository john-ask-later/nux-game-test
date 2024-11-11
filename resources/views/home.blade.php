@extends('layout')

@section('content')
    <legend>
        <i class="fa fa-fw fa-door-open"></i> Welcome
    </legend>

    {{ html()->form()->open() }}
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

        @includeWhen($hashId, 'components.lucky-link')
    </div>
    @if($errors->isNotEmpty())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ html()->form()->close() }}
@stop
