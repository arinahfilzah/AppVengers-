<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index() {
        $user = auth()->user();

        // Premium-only access
        if (! $user->isPremium()) {
            abort(403, 'Premium access required');
        }

        $limit = 10;

        // Get selected filter
        $filters = [
            'subject' => request('subject'),
       ];

        $recommendations = $this->recommendationService
            ->getRecommendations($user, $limit, $filters);

        // Get subjects for dropdown
        $subjects = \App\Models\Resource::distinct()
            ->pluck('subject');

        return view('recommendations.index', compact(
            'recommendations',
            'subjects'
       ));
    }
}
