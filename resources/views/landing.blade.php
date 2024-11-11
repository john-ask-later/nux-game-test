@php use App\Domain\Landing\Landing;use App\Http\Controllers\LandingController; @endphp
@extends('layout')

@php
    /** @var Landing $landing */
    /** @var string $hashId */
@endphp

@section('content')
    <div class="text-center">
        <div class="mb-5">
            <h1>
                <i class="fa fa-fw fa-user"></i> Welcome {{ $landing->getPlayerName() }}
            </h1>
            <small class="text-muted">{{ $landing->getTimeToExpiration() }} your lucky page gets expired, don't
                miss your chance!</small>
        </div>

        <div class="mb-5">
            {{ html()->button('Imfeelinglucky')
                ->id('create-spin')
                ->data('url', route('spin.create', $landing->hash))
                ->class('btn btn-lg btn-outline-primary') }}
            {{ html()->a(route('spin.history', $landing->hash), 'History')
                ->id('spin-history')
                ->class('btn btn-sm btn-outline-light text-secondary ms-5') }}
        </div>

        <div class="mb-5" id="history-container">
        </div>

        <div class="mt-5 mb-5 d-flex justify-content-between">
            {{ html()->form('POST', route('landing.regenerate', $landing->hash))->open() }}
            {{ html()->submit('Create new lucky page')->class('btn btn-sm btn-link') }}
            {{ html()->form()->close() }}

            {{ html()->form('DELETE', route('landing.deactivate', $landing->hash))->open() }}
            {{ html()->submit('Stop my journey')->class('btn btn-sm btn-link text-secondary') }}
            {{ html()->form()->close() }}
        </div>

        @includeWhen($hashId, 'components.lucky-link')
    </div>
@endsection
