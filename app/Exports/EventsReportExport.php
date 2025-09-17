<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventsReportExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil dan mengelompokkan data event
        return Event::select(
            DB::raw("DATE_FORMAT(start_date, '%M') as month_name"),
            DB::raw("YEAR(start_date) as year"),
            DB::raw("SUM(CASE WHEN start_date < NOW() THEN 1 ELSE 0 END) as past_events"),
            DB::raw("SUM(CASE WHEN start_date >= NOW() THEN 1 ELSE 0 END) as upcoming_events")
        )
        ->groupBy('year', 'month_name')
        ->orderBy('year', 'desc')
        ->orderByRaw("FIELD(month_name, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
        ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Mendefinisikan judul kolom di file Excel
        return [
            'Bulan',
            'Tahun',
            'Event Terlaksana',
            'Event Mendatang',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        // Memetakan data dari collection ke setiap baris Excel
        return [
            $row->month_name,
            $row->year,
            $row->past_events,
            $row->upcoming_events,
        ];
    }
}