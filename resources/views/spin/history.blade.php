<table class="table">
    <thead>
    <th>Try #</th>
    <th>Score</th>
    <th>Amount</th>
    </thead>
    <tbody>
    @forelse($list as $spin)
        @if($spin->is_win)
            <tr class="table-success">
                <td>{{ $spin->num }}</td>
                <td>{{ $spin->score }}</td>
                <td>{{ $spin->amountInUsd() }}</td>
            </tr>
        @else
            <tr class="table-warning">
                <td>{{ $spin->num }}</td>
                <td>{{ $spin->score }}</td>
                <td></td>
            </tr>
        @endif
    @empty
        <tr class="table-info">
            <td colspan="3">You must click "Imfeelinglucky" first</td>
        </tr>
    @endforelse
    </tbody>
</table>
