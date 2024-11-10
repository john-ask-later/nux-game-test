@php use App\Http\Controllers\LandingController; @endphp

<div class="alert alert-info mt-5 w-100">
    Your lucky link is here:
    <a href="{{ action([LandingController::class, 'show'], $hashId) }}" class="alert-link">{{ $hashId }}</a>
</div>
