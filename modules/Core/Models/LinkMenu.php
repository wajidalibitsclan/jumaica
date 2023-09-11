<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Cache;

class LinkMenu extends BaseModel
{
    protected $table = 'link_menus';
    protected $fillable = ['name', 'link', 'icon'];
}
