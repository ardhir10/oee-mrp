<?php

namespace App\Imports;

use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpMaterial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InventoryMaterialImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            if($i==0){
                continue;
            }

            $target_day = $row[4];
            $qty_target = $row[5];

            if ($target_day == 0 && $qty_target == 0) 
            {
                $total_target_day = 0;
            } else {
                $total_target_day = round($qty_target/$target_day);
            }

            $materialid = MrpMaterial::where('part_number', $row[0])->first();
            MrpInventoryMaterialList::updateOrCreate(
                [
                    'material_id' => $materialid->id ?? 0,
                ],
                [
                    'initial_stock' => $row[2] ?? 0,
                    'stock' => $row[2] ?? 0,
                    'lot_material' => $row[3] ?? '',
                    'target_day' => $row[4] ?? 0,
                    'qty_target' => $row[5] ?? 0,
                    'total_target_day' => $total_target_day,
                    'target_min' => $row[6] ?? 0,
                    'target_max' => $row[7] ?? 0,
                    'description' => $row[8] ?? '',
                    
                ]
            );
        }
    }
}
