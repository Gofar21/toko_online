<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Pertanyaan;
use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; 


class DashboardController extends Controller
{
    /**
     * Index dashboard - main app preview
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //ambil data data untuk ditampilkan di card pada dashboard
        $pendapatan = Order::select(DB::raw('SUM(subtotal) as penghasilan'))
            ->where('status_order_id', 5)
            ->first();
        $transaksi = Order::select(DB::raw('COUNT(id) as total_order'))
            ->first();
        $pelanggan = User::select(DB::raw('COUNT(id) as total_user'))
            ->where('role', '=', 'customer')
            ->first();
        $order_terbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->orderBy('order.created_at', 'desc')
            ->paginate(10);

        
        $questionsCount = Pertanyaan::select('text_input', DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('text_input')
            ->orderBy('count', 'DESC')
            ->get();

            $percentageData = Pertanyaan::select('text_input', DB::raw('count(*) as count'))
            ->groupBy('text_input')
            ->orderBy('count', 'DESC')
            ->get();

            // Hitung total semua pertanyaan
            $totalPertanyaan = Pertanyaan::count();

            // Hitung persentase untuk setiap kategori
            $percentageData->transform(function ($item) use ($totalPertanyaan) {
            $item->percentage = ($item->count / $totalPertanyaan) * 100;
            return $item;
            });
        // echo $percentageData;
        // die();

        return view('admin/dashboard', [
            'pendapatan' => $pendapatan,
            'transaksi'  => $transaksi,
            'pelanggan'  => $pelanggan,
            'order_baru' => $order_terbaru,
            'questionsCount' => $questionsCount,
            'percentageData' => $percentageData
        ]);
    }

    public function filterQuestions(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $questionsCount = Pertanyaan::select('text_input', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('text_input')
            ->orderBy('count', 'DESC')
            ->get();

        return response()->json($questionsCount);
    }
    

    public function exportPdf()
    {
        $pendapatan = Order::select(DB::raw('SUM(subtotal) as penghasilan'))
            ->where('status_order_id', 5)
            ->first();
        $transaksi = Order::select(DB::raw('COUNT(id) as total_order'))
            ->first();
        $pelanggan = User::select(DB::raw('COUNT(id) as total_user'))
            ->where('role', '=', 'customer')
            ->first();
        $order_terbaru = Order::join('status_order', 'status_order.id', '=', 'order.status_order_id')
            ->join('users', 'users.id', '=', 'order.user_id')
            ->select('order.*', 'status_order.name', 'users.name as nama_pemesan')
            ->limit(10)
            ->get();
        $questionsCount = Pertanyaan::select('text_input', DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('text_input')
            ->orderBy('count', 'DESC')
            ->get();

        $percentageData = Pertanyaan::select('text_input', DB::raw('count(*) as count'))
            ->groupBy('text_input')
            ->orderBy('count', 'DESC')
            ->get();

        $totalPertanyaan = Pertanyaan::count();

        $percentageData->transform(function ($item) use ($totalPertanyaan) {
            $item->percentage = ($item->count / $totalPertanyaan) * 100;
            return $item;
        });

        $data = [
            'pendapatan' => $pendapatan,
            'transaksi' => $transaksi,
            'pelanggan' => $pelanggan,
            'order_baru' => $order_terbaru,
            'questionsCount' => $questionsCount,
            'percentageData' => $percentageData,
        ];

        $pdf = PDF::loadView('admin.dashboard_pdf', $data);

        return $pdf->download('dashboard.pdf');
    }

}
