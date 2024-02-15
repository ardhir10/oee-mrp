<?php

namespace App\Imports;

use App\Models\Mrp\MrpMaterial;
use App\Models\Mrp\MrpSupplier;
use App\Models\Mrp\MrpUnit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MaterialImport implements ToCollection
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

            $supplier = MrpSupplier::where('supplier_code', $row[7])->first();
            $unit = MrpUnit::where('unit_code', $row[8])->first();

            MrpMaterial::updateOrCreate(
                [
                    'material_code' => $row[0] ?? "-", 
                    
                ],
                [
                    'material_name' => $row[1] ?? "-",
                    'part_number' => $row[2] ?? "-",
                    'dim_long' => $row[3] ?? 0,
                    'dim_width' => $row[4] ?? 0,
                    'dim_height' => $row[5] ?? 0,
                    'dim_weight' => $row[6] ?? 0,
                    'supplier_id' => $supplier->id ?? null,
                    'unit_id' => $unit->id ?? null,
                    'description' => $row[9] ?? "",

                ]
            );
        }
    }
}
