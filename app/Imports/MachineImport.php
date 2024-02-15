<?php

namespace App\Imports;

use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpPlace;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MachineImport implements ToCollection
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
            
            $unit = MrpUnit::where('unit_code', $row[5])->first();
            $place = MrpPlace::where('place_code', $row[6])->first();

            MrpMachine::updateOrCreate(
                [
                    'machine_code' => $row[0] ?? "-", 
                    
                ],
                [
                    'machine_name' => $row[1] ?? "-",
                    'type' => $row[2] ?? "-" ,
                    'brand' => $row[3] ?? "-",
                    'capacity' => $row[4] ?? 0,
                    'unit_id' => $unit->id ?? null,
                    'place_id' => $place->id ?? null,

                ]
            );
        }
    }
}
