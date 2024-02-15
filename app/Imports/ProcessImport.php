<?php

namespace App\Imports;

use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpProcessMachine;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProcessImport implements ToCollection
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

            
            // name
            MrpProcess::updateOrCreate(
                [
                    'process_code' => $row[0] ?? "-", 
                    
                ],
                [
                    'process_name' => $row[1] ?? "-", 

                ]
                );
                
        }

        foreach ($rows as $i => $row) {
            if($i==0){
                continue;
            }
            
            $process = MrpProcess::where('process_code', $row[2])->first();
            $machine = MrpMachine::where('machine_code', $row[3])->first();
        

            //id
            MrpProcessMachine::updateOrCreate(
            [
                'process_machines_id' => $process->id ?? null, 
            ],
            [
                'machine_id' => $machine->id ?? null, 

            ]
            );
        }
    }
}
