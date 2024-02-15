<?php

namespace App\Imports;

use App\Models\Mrp\MrpCounterMeasure;
use App\Models\Mrp\MrpProblem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CounterMeasureImport implements ToCollection
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

            $problem = MrpProblem::where('problem_code', $row[2])->first();

            MrpCounterMeasure::updateOrCreate(
            [
                'cm_code'  => $row[0] ?? "-",
            ],
            [
                'cm_name'   => $row[1] ?? "-",
                'problem_id'   => $problem->id ?? null,
                 'description'   => $row[3] ?? "",

            ]

        );
    }
}
}