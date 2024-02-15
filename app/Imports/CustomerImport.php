<?php

namespace App\Imports;

use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpCustomerDocsCd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomerImport implements ToCollection
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
            MrpCustomer::updateOrCreate(
                [
                    'customer_code' => $row[0] ?? "-", 
                    
                    
                    
                ],
                [
                    'customer_name' => $row[1] ?? "-",
                    'address' => $row[2] ?? "-",
                    'email' => $row[3] ?? "-",
                    'description' => $row[4] ?? "-",

                ]
            );
        }
        foreach ($rows as $i=> $row) {
            if($i==0){
                continue;
            }

            $customer = MrpCustomer::where('customer_code', $row[5])->first();
            

            MrpCustomerDocsCd::updateOrCreate(
                [
                    'customer_id' => $customer->id ?? null, 
                    
                    
                ],
                [
                    'dock_cd' => $row[6] ?? "",
                    
                ]
            );
        }
    }
}
