<?php

namespace App\Imports;

use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpPlace;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
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

            $place = MrpPlace::where('place_code', $row[6])->first();
            $shift = MrpShift::where('shift_code', $row[7])->first();

            MrpEmployee::updateOrCreate(
                [
                    'nik' => $row[0] ?? "-", 
                    
                ],
                [
                    'employee_name' => $row[1] ?? "-",
                    'departement' => $row[2] ?? "-",
                    'section' => $row[3] ?? "-",
                    'title' => $row[4] ?? "-",
                    'grade' => $row[5] ?? "-",
                    'place_id' => $place->id ?? null,
                    'shift_id' => $shift->id  ?? null,
                    'description' => $row[8] ?? "",

                ]
            );
        }
    }
}
