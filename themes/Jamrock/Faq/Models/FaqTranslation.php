<?php

namespace Themes\Jamrock\Faq\Models;

use App\BaseModel;

class FaqTranslation extends BaseModel
{
    protected $table = 'bravo_faq_translations';

    protected $fillable = [
        'title',
        'content',
    ];
    protected $casts = [
        'content' => 'array',
    ];
    protected $slugField     = false;
    protected $seo_type = 'faq_translation';
}
