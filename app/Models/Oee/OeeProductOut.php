<?php

namespace App\Models\Oee;

use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpShift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeProductOut extends Model
{
    use HasFactory;

    protected $table = 'detail_product_out';
    
    public function product()
    {
        // return $this->belongsTo(MrpProduct::class, 'product_id');
        return $this->belongsTo(MrpProduct::class, 'product_id');
    }

    public function shift()
    {
        return $this->belongsTo(MrpShift::class, 'shift_id');
    }
}
