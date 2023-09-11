<?php


    namespace Themes\Findhouse\User\Models;


    use App\BaseModel;
    use Themes\Findhouse\Agencies\Models\Agencies;
    use Themes\Findhouse\Property\Models\Property;

    class BravoContactObject extends BaseModel
    {

        protected $table = 'bravo_contact_object';

        protected $fillable=[
            'object_id',
            'object_model',
            'vendor_id',
            'name',
            'phone',
            'email',
            'message',
        ];

        public function property(){
            return $this->belongsTo(Property::class,'object_id');
        }
        public function agencies(){
            return $this->belongsTo(Agencies::class,'object_id');
        }
    }
