<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BorrowExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportBorrow()
    {
        return Excel::download(new BorrowExport, 'data-peminjaman.xlsx');
    }
}
