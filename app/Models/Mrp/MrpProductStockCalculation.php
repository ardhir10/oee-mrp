<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProductStockCalculation extends Model
{
    use HasFactory;

    public function inventoryProductList()
    {
        return $this->belongsTo(MrpInventoryProductList::class);
    }
}
