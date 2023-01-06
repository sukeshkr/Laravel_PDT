<?php

namespace App\Imports;

use App\Models\Import;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportData implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $res =  new Import([
            'branch_id' => session('branch',1)->id,
            'item_code' => $row[0],
            'item_name' => $row[1],
            'price'     => $row[2],
            'unit'      => $row[3],
            'stock'     => $row[4],
        ]);

        return $res;

    }
}
