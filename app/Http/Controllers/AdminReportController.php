<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function showRevenue(): View
    {
        return view('admin.pages.report.revenue');
    }

    public function showOrder(): View
    {
        return view('admin.pages.report.order');
    }

    public function getOrderData(Request $request): JsonResponse
    {
        $type = $request->get('type', 'year');
        $currentYear = Carbon::now()->year;

        if ($type === 'quarter') {
            $query = DB::table('orders')
                ->selectRaw('COUNT(*) as total, QUARTER(created_at) as quarter')
                ->where('status', 'completed')
                ->whereYear('created_at', $currentYear)
                ->groupBy('quarter')
                ->orderBy('quarter')
                ->get();

            $dataMap = $query->keyBy('quarter');
            $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
            $data = [];

            foreach ([1, 2, 3, 4] as $q) {
                $data[] = $dataMap[$q]->total ?? 0;
            }

        } else {
            $query = DB::table('orders')
                ->selectRaw('COUNT(*) as total, MONTH(created_at) as month')
                ->where('status', 'completed')
                ->whereYear('created_at', $currentYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $dataMap = $query->keyBy('month');
            $labels = [
                'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
            ];
            $data = [];

            foreach (range(1, 12) as $month) {
                $data[] = $dataMap[$month]->total ?? 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getRevenueData(Request $request): JsonResponse
    {
        $type = $request->get('type', 'year');
        $currentYear = Carbon::now()->year;

        // Orders
        $ordersQuery = DB::table('orders')
            ->selectRaw('SUM(total_amount) as total, ' . ($type === 'quarter' ? 'QUARTER(created_at) as period' : 'MONTH(created_at) as period'))
            ->where('status', 'completed')
            ->whereYear('created_at', $currentYear)
            ->groupBy('period')
            ->pluck('total', 'period');

        // Invoices
        $invoicesQuery = DB::table('invoices')
            ->selectRaw('SUM(total_amount) as total, ' . ($type === 'quarter' ? 'QUARTER(created_at) as period' : 'MONTH(created_at) as period'))
            ->where('status', 'completed')
            ->whereYear('created_at', $currentYear)
            ->groupBy('period')
            ->pluck('total', 'period');

        if ($type === 'quarter') {
            $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
            $range = range(1, 4);
        } else {
            $labels = [
                'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
            ];
            $range = range(1, 12);
        }

        $ordersData = [];
        $invoicesData = [];
        foreach ($range as $i) {
            $ordersData[] = (float) ($ordersQuery[$i] ?? 0);
            $invoicesData[] = (float) ($invoicesQuery[$i] ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'orders' => $ordersData,
            'invoices' => $invoicesData
        ]);
    }

}
