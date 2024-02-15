<?php

namespace App\Imports;

use App\Models\Mrp\MrpUnit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UnitImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $i=> $row) {
            if($i==0){
                continue;
            }
            MrpUnit::updateOrCreate(
                [
                    'unit_code' => $row[0] ?? "-", 
                    
                ],
                [
                    'unit_name' => $row[1] ?? "-",
                    'description' => $row[2] ?? "",

                ]
            );
        }
    }
}
