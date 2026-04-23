<?php

namespace App\Exports;

use App\Models\Borrow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BorrowExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $status, $startDate, $endDate;

    public function __construct($status = null, $startDate = null, $endDate = null)
    {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Borrow::with([
            'user',
            'details.bookItem.book.category',
            'details.bookItem.book.subcategory'
        ]);

        // FILTER STATUS
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // FILTER TANGGAL
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('borrow_date', [$this->startDate, $this->endDate]);
        }

        return $query->get()->flatMap(function ($borrow) {
            return $borrow->details->map(function ($detail) use ($borrow) {
                return [
                    $borrow->id,
                    $borrow->user->name ?? '-',
                    $borrow->user->nis ?? '-',
                    $detail->bookItem->book->title ?? '-',
                    $detail->bookItem->book->category->name ?? '-',
                    $detail->bookItem->book->subcategory->name ?? '-',
                    $borrow->status,
                    optional($borrow->borrow_date)->format('Y-m-d'),
                    optional($borrow->due_date)->format('Y-m-d'),
                    $detail->return_condition ?? '-',
                    $detail->returned_at ?? '-',
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'Borrow ID',
            'User',
            'NIS',
            'Judul Buku',
            'Kategori',
            'Sub Kategori',
            'Status',
            'Tanggal Pinjam',
            'Batas Kembali',
            'Kondisi',
            'Tanggal Kembali',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => '2D6A4F'
                    ]
                ],
            ],
        ];
    }
}
