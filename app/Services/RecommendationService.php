<?php

namespace App\Services;

use App\Models\Resource;
use App\Models\UserActivity;

class RecommendationService
{
    public function getRecommendations($user, $limit = 10, $filters = [])
    {
        $query = Resource::whereIn('subject', function ($q) use ($user) {
            $q->select('subject')
              ->from('user_activities')
              ->where('user_id', $user->id);
        });

        // 🔍 Apply filter (UC08)
        if (!empty($filters['subject'])) {
            $query->where('subject', $filters['subject']);
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
