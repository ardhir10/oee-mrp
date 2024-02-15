<?php

namespace App\Imports;

use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InventoryProductImport implements ToCollection
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
            $target_day = $row[3];
            $qty_target = $row[4];

            if($target_day == 0 && $qty_target == 0)
            {
                $total_target_day = 0;
            }else{
                $total_target_day = round($qty_target/$target_day);
            }
            $product = MrpProduct::where('part_number', $row[0])->first();
            MrpInventoryProductList::updateOrCreate(
                [
                    'product_id' => $product->id ?? null,
                    'initial_stock' => $row[2] ?? 0,
                    'stock' => $row[2] ?? 0,
                    'target_day' => $row[3] ?? 0,
                    'qty_target' => $row[4] ?? 0,
                    'status' => $row[5] ?? "",
                    'target_min' => $row[6] ?? 0,
                    'target_max' => $row[7] ?? 0,
                    'description' => $row[8] ?? '-',
                    'total_target_day' => $total_target_day,
                ],
               
            );
        }
    }
}
