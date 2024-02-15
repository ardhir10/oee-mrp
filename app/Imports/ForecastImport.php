<?php

namespace App\Imports;

use App\Models\Mrp\MrpForecast;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ForecastImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  collection(Collection $rows)
    {
        foreach ($rows as $i=> $row) {
            if($i==0){
                continue;
            }
        
        
            $product = MrpProduct::where('product_code', $row[1])->first();
            $customer = MrpCustomer::where('customer_code', $row[0])->first();
            // dd($row[0]);

            MrpForecast::updateOrCreate(
            [
                'customer_id'  => $customer->id ?? null,
            ],
            [
                'product_id'   => $product->id ?? null,
                'qty_forecast'   => $row[2] ?? 0,
                'forecast_date'   => date('Y-m-d', strtotime($row[3])) ?? "",

            ]
            

            

        );
    }
    
}
}
