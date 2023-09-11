<?php
namespace Themes\Jamrock\Faq\Models;

use App\BaseModel;

class FaqCategoryTranslation extends BaseModel
{
    protected $table = 'bravo_faq_category_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $cleanFields = [
        'content'
    ];
}
