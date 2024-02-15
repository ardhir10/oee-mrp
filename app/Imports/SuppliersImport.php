<?php

namespace App\Imports;

use App\Models\Mrp\MrpSupplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SuppliersImport implements ToCollection
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
        MrpSupplier::updateOrCreate(
            [
                    'supplier_code' => $row[0] ?? "-", 
            ],
            [
              'supplier_name' => $row[1] ?? "-",
              'address' => $row[2] ?? "-",
              'email' => $row[3] ?? "-",
              'description' => $row[4] ?? "",

            ]
            );
    }
  }
}
