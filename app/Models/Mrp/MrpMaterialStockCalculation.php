<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpMaterialStockCalculation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inventoryMaterialList()
    {
        return $this->belongsTo(MrpInventoryMaterialList::class, 'inventory_material_list_id');
    }
}
