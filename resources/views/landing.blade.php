@php use App\Http\Controllers\LandingController; @endphp
@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto pt-5 text-center">
                <div class="mb-5">
                    <h1>
                        <i class="fa fa-fw fa-user"></i> Welcome {{ $landing->player->name }}
                    </h1>
                    <small class="text-muted">{{ $landing->getTimeToExpiration() }} your lucky page gets expired, don't
                        miss your chance!</small>
                </div>

                <div class="mb-5" id="history-container">
                </div>

                <div class="mt-5">
                    {{ html()->button('Imfeelinglucky')
                        ->id('create-spin')
                        ->data('url', route('spin.create', $landing->hash))
                        ->class('btn btn-lg btn-outline-primary') }}
                    {{ html()->a(route('spin.history', $landing->hash), 'History')
                        ->id('spin-history')
                        ->class('btn btn-sm btn-outline-light text-secondary ms-5') }}
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    {{ html()->form('POST', action([LandingController::class, 'regenerate'], $landing->hash))->open() }}
                    {{ html()->submit('Create new lucky page')->class('btn btn-sm btn-link') }}
                    {{ html()->form()->close() }}

                    {{ html()->form('DELETE', action([LandingController::class, 'deactivate'], $landing->hash))->open() }}
                    {{ html()->submit('Stop my journey')->class('btn btn-sm btn-link text-secondary') }}
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#create-spin').on('click', function () {
                var $btn = $(this),
                    url = $btn.data('url');

                $btn.attr('disabled', true);

                $.post(url, {}, function (resp) {
                    $('#history-container').html(resp.result)
                }).always(function () {
                    $btn.attr('disabled', false);
                });
            });

            $('#spin-history').on('click', function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (resp) {
                    $('#history-container').html(resp.result)
                })
            })
        });
    </script>
@endpush
