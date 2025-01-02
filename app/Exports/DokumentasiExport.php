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


class DokumentasiExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithColumnFormatting
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
     * @var Dokumentasi
     */
    public function map($dokumentasi): array
    {
        return [
            ++$this->rowNumber,
            $dokumentasi->kegiatan->nama_kegiatan,
            $dokumentasi->judul,
            Date::dateTimeToExcel($dokumentasi->created_at),
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'Nama Kegiatan',
            'Judul foto',
            'Tanggal Dibuat',
        ];
    }


    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}


