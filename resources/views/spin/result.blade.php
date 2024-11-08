@if($spin->is_win)
    <div class="alert alert-success">
        You won <strong>{{ $spin->amountInUsd() }}</strong> within {{ $spin->score }} score
    </div>
@else
    <div class="alert alert-warning">
        Your score <u>{{ $spin->score }}</u>. Good luck next time...
    </div>
@endif
