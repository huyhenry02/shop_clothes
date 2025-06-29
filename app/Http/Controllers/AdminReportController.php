<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
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
        $result = $this->getOrderStatistics($type);

        return response()->json([
            'labels' => $result['labels'],
            'data' => $result['data']
        ]);
    }

    public function getRevenueData(Request $request): JsonResponse
    {
        $type = $request->get('type', 'year');

        $stats = $this->getRevenueStatistics($type);

        return response()->json([
            'labels' => $stats['labels'],
            'orders' => $stats['orders'],
            'invoices' => $stats['invoices'],
        ]);
    }

    public function exportPdfOrder(Request $request): Response
    {
        $type = $request->get('type', 'year');
        $result = $this->getOrderStatistics($type);

        $pdf = Pdf::loadView('admin.pages.report.pdf_order', [
            'labels' => $result['labels'],
            'data' => $result['data'],
            'type' => $type,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('thong_ke_don_hang.pdf');
    }

    public function exportPdfRevenue(Request $request): Response
    {
        $type = $request->get('type', 'year');
        $stats = $this->getRevenueStatistics($type);

        $pdf = Pdf::loadView('admin.pages.report.pdf_revenue', [
            'labels' => $stats['labels'],
            'orders' => $stats['orders'],
            'invoices' => $stats['invoices'],
            'type' => $type,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('thong_ke_doanh_thu.pdf');
    }

    public function showBestSelling(): View
    {
        return view('admin.pages.report.best_selling', ['data' => []]);
    }

    public function getBestSellingData(Request $request): JsonResponse
    {
        try {
            $data = $this->getBestSellingProducts(
                $request->start_date,
                $request->end_date,
                $request->sort_quantity ?? 'desc'
            );

            $html = view('admin.pages.report.table_best_selling', ['data' => $data])->render();

            return response()->json(['html' => $html]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }


    public function exportPdfBestSelling(Request $request): Response
    {
        $data = $this->getBestSellingProducts(
            $request->start_date,
            $request->end_date,
            $request->sort_quantity ?? 'desc'
        );

        $pdf = Pdf::loadView('admin.pages.report.pdf_best_selling', [
            'data' => $data,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('thong_ke_san_pham_ban_chay.pdf');
    }

    private function getBestSellingProducts(?string $startDate, ?string $endDate, string $sort = 'desc'): Collection
    {
        // Xử lý ngày mặc định
        if ($startDate && !$endDate) {
            $endDate = now()->toDateString();
        } elseif (!$startDate && $endDate) {
            $startDate = null;
        }

        // Query từ hóa đơn
        $invoiceQuery = DB::table('invoice_details')
            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->when($startDate, fn($q) => $q->whereDate('invoices.payment_time', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('invoices.payment_time', '<=', $endDate))
            ->where('invoices.status', '=', Invoice::STATUS_COMPLETED)
            ->select('invoice_details.product_id', DB::raw('SUM(invoice_details.quantity) as total_quantity'))
            ->groupBy('invoice_details.product_id');

        // Query từ đơn hàng
        $orderQuery = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->when($startDate, fn($q) => $q->whereDate('orders.payment_time', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('orders.payment_time', '<=', $endDate))
            ->where('orders.status', '=', Order::STATUS_COMPLETED)
            ->select('order_details.product_id', DB::raw('SUM(order_details.quantity) as total_quantity'))
            ->groupBy('order_details.product_id');

        // Gộp lại
        $unionSub = $invoiceQuery->unionAll($orderQuery);

        $products = DB::query()->fromSub($unionSub, 'combined')
            ->select('product_id', DB::raw('SUM(total_quantity) as quantity'))
            ->groupBy('product_id');

        // Join sản phẩm + danh mục
        return DB::table(DB::raw("({$products->toSql()}) as summary"))
            ->mergeBindings($products)
            ->join('products', 'summary.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.code',
                'products.name',
                'products.image',
                'categories.name as category_name',
                'summary.quantity'
            )
            ->orderBy('summary.quantity', $sort)
            ->get();
    }

    private function getOrderStatistics(string $type): array
    {
        $currentYear = Carbon::now()->year;

        if ($type === 'quarter') {
            $query = DB::table('orders')
                ->selectRaw('COUNT(*) as total, QUARTER(created_at) as period')
                ->where('status', 'completed')
                ->whereYear('created_at', $currentYear)
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
            $range = range(1, 4);
        } else {
            $query = DB::table('orders')
                ->selectRaw('COUNT(*) as total, MONTH(created_at) as period')
                ->where('status', 'completed')
                ->whereYear('created_at', $currentYear)
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            $labels = [
                'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
            ];
            $range = range(1, 12);
        }

        $dataMap = $query->keyBy('period');
        $data = [];

        foreach ($range as $i) {
            $data[] = $dataMap[$i]->total ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'type' => $type
        ];
    }

    private function getRevenueStatistics(string $type): array
    {
        $currentYear = Carbon::now()->year;

        $ordersQuery = DB::table('orders')
            ->selectRaw('SUM(total_amount) as total, ' . ($type === 'quarter' ? 'QUARTER(created_at) as period' : 'MONTH(created_at) as period'))
            ->where('status', 'completed')
            ->whereYear('created_at', $currentYear)
            ->groupBy('period')
            ->pluck('total', 'period');

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
            $ordersData[] = (float)($ordersQuery[$i] ?? 0);
            $invoicesData[] = (float)($invoicesQuery[$i] ?? 0);
        }

        return [
            'labels' => $labels,
            'orders' => $ordersData,
            'invoices' => $invoicesData,
        ];
    }
}
