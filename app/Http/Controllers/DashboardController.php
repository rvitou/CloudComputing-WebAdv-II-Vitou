<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Exercise;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with all the required data.
     */
    public function index()
    {
        // --- DATA FOR TOP CARDS ---
        $studentCount = Student::count();
        $coachCount = Coach::count();
        $exerciseCount = Exercise::count();

        // --- DATA FOR REVENUE CARDS ---
        // Joins subscriptions with their plans using 'plan_id' to get the price.
        $totalRevenue = Subscription::join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->sum('subscription_plans.price');

        $monthlyRevenue = Subscription::join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->whereMonth('subscriptions.created_at', now()->month)
            ->whereYear('subscriptions.created_at', now()->year)
            ->sum('subscription_plans.price');

        // Assuming 70% of total revenue is due to coaches. Adjust as needed.
        $amountDueToCoaches = DB::table('subscriptions')
            ->join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->where('subscriptions.end_date', '<', now())
            ->where('subscriptions.paid_out_to_coach', false)
            ->sum(DB::raw('subscription_plans.price * 0.50'));

        // --- DATA FOR CHARTS ---

        // Student Gender Chart
        $studentGenders = Student::join('users', 'students.user_id', '=', 'users.id')
            ->select('users.gender', DB::raw('count(*) as total'))
            ->groupBy('users.gender')
            ->pluck('total', 'gender');
        $studentGenderChart = [
            'labels' => $studentGenders->keys(),
            'data' => $studentGenders->values(),
        ];

        // Coach Gender Chart
        $coachGenders = Coach::join('users', 'coaches.user_id', '=', 'users.id')
            ->select('users.gender', DB::raw('count(*) as total'))
            ->groupBy('users.gender')
            ->pluck('total', 'gender');
        $coachGenderChart = [
            'labels' => $coachGenders->keys(),
            'data' => $coachGenders->values(),
        ];

        // New Users Chart (Last 6 Months)
        $newUsersData = User::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->pluck('count', 'month');
            
        $userChartLabels = collect();
        for ($i = 5; $i >= 0; $i--) {
            $userChartLabels->push(now()->subMonths($i)->format('M'));
        }
        
        $newUsersChart = [
            'labels' => $userChartLabels,
            'data' => $userChartLabels->map(fn ($month) => $newUsersData->get($month) ?? 0),
        ];

        // Revenue Chart (Last 9 Months)
        $revenueData = Subscription::join('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->where('subscriptions.created_at', '>=', now()->subMonths(8)->startOfMonth())
            ->selectRaw('DATE_FORMAT(subscriptions.created_at, "%b") as month, SUM(subscription_plans.price) as revenue')
            ->groupBy('month')
            ->orderByRaw('MIN(subscriptions.created_at)')
            ->pluck('revenue', 'month');

        $revenueChartLabels = collect();
        for ($i = 8; $i >= 0; $i--) {
            $revenueChartLabels->push(now()->subMonths($i)->format('M'));
        }

        $revenueChart = [
            'labels' => $revenueChartLabels,
            'data' => $revenueChartLabels->map(fn ($month) => $revenueData->get($month) ?? 0),
        ];

        // --- PASS ALL DATA TO THE VIEW ---
        return view('dashboard', [
            'studentCount' => $studentCount,
            'coachCount' => $coachCount,
            'exerciseCount' => $exerciseCount,
            'monthlyRevenue' => $monthlyRevenue,
            'totalRevenue' => $totalRevenue,
            'amountDueToCoaches' => $amountDueToCoaches,
            'studentGenderChart' => $studentGenderChart,
            'coachGenderChart' => $coachGenderChart,
            'newUsersChart' => $newUsersChart,
            'revenueChart' => $revenueChart,
        ]);
    }
}
