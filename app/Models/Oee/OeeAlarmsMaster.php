<?php

namespace App\Models\Oee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OeeAlarmsMaster extends Model
{
    use HasFactory;

    protected $table = 'alarms_master';

    protected $fillable = ['machine_id','alarm_name', 'alarm_tag'];

    public function alarms()
    {
        return $this->belongsToMany(OeeAlarmDetail::class,  'alarms','alarm_master_id', 'alarm_detail_id');
    }

    public function alarmDetail()
    {
        return $this->hasMany(OeeAlarms::class, 'alarm_master_id');
    }

    public function machine()
    {
        return $this->belongsTo(OeeMachine::class, 'machine_id', 'id');
    }

    public function alarmList()
    {
        return $this->hasMany(OeeAlarmList::class,'alarm_master_id')
        // ->select(DB::raw('max(id),alarm_master_id'))
        // ->groupBy('alarm_master_id')
        ->orderBy('alarm_master_id')
        ;
    }
}
