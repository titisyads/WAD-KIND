<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LembagaExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithColumnFormatting
{
    public $collection;

    protected $rowNumber = 0;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * @var Lembaga
     */
    public function map($lembaga): array
    {
        return [
            ++$this->rowNumber,
            $lembaga->nama,
            $lembaga->alamat,
            $lembaga->telepon,
            $lembaga->instagram,
            $lembaga->kategori,
            $lembaga->deskripsi,
            $lembaga->user->name,
            Date::dateTimeToExcel($lembaga->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama Lembaga',
            'Alamat Lembaga',
            'Nomor Telepon',
            'Instagram',
            'Kategori',
            'Deskripsi',
            'Nama Pengurus',
            'Tanggal Dibuat',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}