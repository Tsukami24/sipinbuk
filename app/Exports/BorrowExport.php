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
    public function collection()
    {
        return Borrow::with([
            'user',
            'details.bookItem.book.category',
            'details.bookItem.book.subcategory'
        ])
            ->get()
            ->flatMap(function ($borrow) {

                return $borrow->details->map(function ($detail) use ($borrow) {

                    return [
                        $borrow->id,
                        $borrow->user->name ?? '-',
                        $borrow->user->nis ?? '-',
                        $detail->bookItem->book->title ?? '-',
                        $detail->bookItem->book->category->name ?? '-',
                        $detail->bookItem->book->subcategory->name ?? '-',
                        $borrow->status,
                        $borrow->borrow_date,
                        $borrow->due_date,
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
                    'color' => ['rgb' => '000000'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => 'FFFFFF'
                    ]
                ],
            ],
        ];
    }
}
