<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BorrowExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportBorrow(Request $request)
    {
        $status = $request->status ?? 'all';
        $status = strtolower(str_replace(' ', '_', $status));

        $start = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : 'all';
        $end = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : 'all';

        $fileName = "borrow_{$status}_{$start}_to_{$end}.xlsx";

        return Excel::download(
            new BorrowExport(
                $request->status,
                $request->start_date,
                $request->end_date
            ),
            $fileName
        );
    }
}
