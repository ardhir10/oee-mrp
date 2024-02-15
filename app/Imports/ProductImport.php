<?php

namespace App\Imports;

use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpCustomer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
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
                $unit = MrpUnit::where('unit_code', $row[8])->first();
                $customer = Mrpcustomer::where('customer_code', $row[9])->first();

             MrpProduct::updateOrCreate(
                [
                    'product_code' => $row[0] ?? "-", 
                    
                ],
                [
                    'part_name' => $row[1] ?? "-",
                    'part_number' => $row[2] ?? "-",
                    'product_name' => $row[3] ?? "-",
                    'dim_long' => $row[4] ?? 0,
                    'dim_width' => $row[5] ?? 0,
                    'dim_height' => $row[6] ?? 0,
                    'dim_weight' => $row[7] ?? 0,
                    'unit_id' => $unit->id ?? null,
                    'customer_id' => $customer->id ?? null,
                    'description' => $row[10] ?? "",

                ]
            );
        }
    }
}
