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


class KegiatanVolunteerExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithColumnFormatting
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
     * @var KegiatanVolunteer
     */
    public function map($kegiatanVolunteers): array
    {
        return [
            ++$this->rowNumber,
            $kegiatanVolunteers->lembaga->nama,
            $kegiatanVolunteers->nama_kegiatan,
            $kegiatanVolunteers->kategori,
            $kegiatanVolunteers->lokasi,
            $kegiatanVolunteers->deskripsi,
            $kegiatanVolunteers->tanggal,
            $kegiatanVolunteers->kuota,
            $kegiatanVolunteers->jenis,
            $kegiatanVolunteers->harga,
            $kegiatanVolunteers->user->name,
            Date::dateTimeToExcel($kegiatanVolunteers->created_at),
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'Nama Lembaga',
            'Nama Kegiatan',
            'Kategori',
            'Lokasi',
            'Deskripsi',
            'Tanggal',
            'Kuota',
            'Jenis',
            'Harga',
            'Nama Pengurus',
            'Tanggal Dibuat',
        ];
    }


    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
