<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Get activity logs by user with date range filter
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActivityLogs(Request $request)
    {
        // Validate request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'per_page' => 'nullable|integer|min:1|max:100',
            'model_type' => 'nullable|string',
        ]);

        // Get authenticated user
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Token tidak valid atau tidak ditemukan.'
            ], 401);
        }

        // Parse dates
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $perPage = $request->per_page ?? 15;

        // Build query
        $query = Activity::where('causer_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

        // Filter by model type if provided
        if ($request->filled('model_type')) {
            $modelType = $request->model_type;
            $modelMap = [
                'barang' => 'App\Models\barangs',
                'barangs' => 'App\Models\barangs',
                'kategori' => 'App\Models\Kategori',
                'pelanggan' => 'App\Models\Pelanggan',
                'data_stok' => 'App\Models\data_stok',
                'stok' => 'App\Models\data_stok',
            ];

            if (isset($modelMap[strtolower($modelType)])) {
                $query->where('subject_type', $modelMap[strtolower($modelType)]);
            }
        }

        // Paginate results
        $activities = $query->paginate($perPage);

        // Format response
        return response()->json([
            'message' => 'Activity logs berhasil diambil',
            'filters' => [
                'start_date' => $startDate->toDateTimeString(),
                'end_date' => $endDate->toDateTimeString(),
                'model_type' => $request->model_type ?? 'all',
            ],
            'pagination' => [
                'total' => $activities->total(),
                'per_page' => $activities->perPage(),
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'from' => $activities->firstItem(),
                'to' => $activities->lastItem(),
            ],
            'data' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'event' => $activity->event,
                    'subject_type' => class_basename($activity->subject_type),
                    'subject_id' => $activity->subject_id,
                    'causer_id' => $activity->causer_id,
                    'causer_type' => $activity->causer_type ? class_basename($activity->causer_type) : null,
                    'properties' => $activity->properties,
                    'created_at' => $activity->created_at,
                ];
            })
        ], 200);
    }

    /**
     * Get activity logs summary by date range
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActivitySummary(Request $request)
    {
        // Validate request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Get authenticated user
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Token tidak valid atau tidak ditemukan.'
            ], 401);
        }

        // Parse dates
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        // Get activities in date range
        $activities = Activity::where('causer_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Group by event type
        $summary = [
            'total_activities' => $activities->count(),
            'by_event' => [
                'created' => $activities->where('event', 'created')->count(),
                'updated' => $activities->where('event', 'updated')->count(),
                'deleted' => $activities->where('event', 'deleted')->count(),
            ],
            'by_model' => []
        ];

        // Group by model type
        $groupedByModel = $activities->groupBy('subject_type');
        foreach ($groupedByModel as $modelType => $items) {
            $summary['by_model'][class_basename($modelType)] = [
                'total' => $items->count(),
                'created' => $items->where('event', 'created')->count(),
                'updated' => $items->where('event', 'updated')->count(),
                'deleted' => $items->where('event', 'deleted')->count(),
            ];
        }

        return response()->json([
            'message' => 'Activity summary berhasil diambil',
            'period' => [
                'start_date' => $startDate->toDateTimeString(),
                'end_date' => $endDate->toDateTimeString(),
            ],
            'summary' => $summary
        ], 200);
    }

    /**
     * Get recent activity logs (last 24 hours)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentActivities(Request $request)
    {
        // Get authenticated user
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Token tidak valid atau tidak ditemukan.'
            ], 401);
        }

        $limit = $request->limit ?? 20;

        // Get recent activities (last 24 hours)
        $activities = Activity::where('causer_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'message' => 'Recent activities berhasil diambil',
            'period' => 'Last 24 hours',
            'total_records' => $activities->count(),
            'data' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'event' => $activity->event,
                    'subject_type' => class_basename($activity->subject_type),
                    'subject_id' => $activity->subject_id,
                    'properties' => $activity->properties,
                    'created_at' => $activity->created_at,
                    'time_ago' => $activity->created_at->diffForHumans(),
                ];
            })
        ], 200);
    }
}
