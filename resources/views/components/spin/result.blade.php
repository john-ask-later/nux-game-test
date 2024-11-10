@php use App\Domain\Spin\SpinDto; @endphp
@php
    /** @var SpinDto $spin */
@endphp
@if($spin->is_win)
    <div class="alert alert-success">
        You won <strong>{{ $spin->getAmountInUsd() }}</strong> within {{ $spin->score }} score
    </div>
@else
    <div class="alert alert-warning">
        Your score <u>{{ $spin->score }}</u>. Good luck next time...
    </div>
@endif
