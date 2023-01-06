<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportReport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::select('item_code','item_name','unit','price','sys_stock','phy_stock','difference')->get();
    }
    public function headings(): array
    {
        return ["BARCODE","ITEM NAME", "UNIT","PRICE",'SYSTEM STOCK',"PHYCICAL STOCK",'DIFFERENCE'];
    }
}
