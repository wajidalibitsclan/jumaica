<?php
namespace Themes\Findhouse\Agencies\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Themes\Findhouse\Property\Models\Property;

class BravoContactObject extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bravo_contact_object';
    protected $fillable = [
        'name',
        'email',
        'message',
        'phone',
        'object_id',
        'object_model',
        'vendor_id'
    ];

//    protected $cleanFields = ['message'];
}
