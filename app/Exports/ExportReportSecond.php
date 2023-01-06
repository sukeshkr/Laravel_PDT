<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportReportSecond implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::select('item_code','unit','batch','phy_stock')->get();
    }
    public function headings(): array
    {
        return ["CODE","UNIT","BATCH","STOCK"];
    }
}
