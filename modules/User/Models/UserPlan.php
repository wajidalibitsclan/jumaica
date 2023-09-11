<?php


namespace Modules\User\Models;


use App\BaseModel;

class UserPlan extends BaseModel
{
    protected $table  = 'bravo_user_plan';

    protected $casts = [
        'end_date'=>'datetime',
        'plan_data'=>'array'
    ];

    public function getIsValidAttribute(){
        if(!$this->end_date) return true;

        return $this->end_date->timestamp > time();
    }

    public function plan(){
        return $this->belongsTo(Plan::class,'plan_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'create_user');
    }

    public function getUsedAttribute(){
        return $this->user->service()->where('status','publish')->count('id');
    }
}
