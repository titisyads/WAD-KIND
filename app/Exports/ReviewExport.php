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


class ReviewExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithColumnFormatting
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
     * @var Export
     */
    public function map($review): array
    {
        return [
            ++$this->rowNumber,
            $review->user->name,
            $review->kegiatan->nama_kegiatan,
            $review->rating,
            $review->komentar,
            $review->tanggal,
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'Nama Volunteer',
            'Nama Kegiatan',
            'Rating',
            'Komentar',
            'Tanggal Dibuat',
        ];
    }


    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
