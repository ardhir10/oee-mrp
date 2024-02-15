<?php

namespace App\Imports;

use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpBomMaterial;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpMaterial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BomImport implements ToCollection
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
            MrpBom::updateOrCreate(
                [
                    'bom_code' => $row[0] ?? "", 
                    
                ],
                [
                    'bom_name' => $row[1] ?? "",
                    'description' => $row[2] ?? "",

                ]
            );
        }
        // foreach ($rows as $i => $row) {
        //     if($i==0){
        //         continue;
        //     }

        //     $bom = MrpBom::where('bom_code', $row[3])->first();
        //     $inventory = MrpInventoryMaterialList::where('material_id')->get();
        //     dd($inventory);
        //     $material = MrpMaterial::where($inventory->material->material_code, $row[4])->first();
        //     MrpBomMaterial::updateOrCreate(
        //         [
        //             'bom_id' => $bom->id ?? null, 
        //             'material_id' => optional($material)->id ?? null,

        //         ]
        //     );
        // }
    }
}
