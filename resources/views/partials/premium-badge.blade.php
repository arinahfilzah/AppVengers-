@auth
    @if(Auth::user()->isPremium())
    <span class="badge bg-gradient-premium px-3 py-2" style="font-size: 0.9rem;">
        <i class="fas fa-crown me-1"></i>PREMIUM
        @if(Auth::user()->getPremiumDaysRemaining() > 0)
        <small class="ms-1">({{ Auth::user()->getPremiumDaysRemaining() }} days left)</small>
        @endif
    </span>
    @else
    <a href="{{ route('premium.plans') }}" class="btn btn-outline-warning btn-sm">
        <i class="fas fa-rocket me-1"></i>Go Premium
    </a>
    @endif
@endauth

<style>
.bg-gradient-premium {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #000;
    font-weight: bold;
    border: none;
}
</style>