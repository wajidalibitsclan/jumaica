<?php
namespace Themes\Jamrock\Faq\Models;

use App\BaseModel;

class Faq extends BaseModel
{
    protected $table = 'bravo_faq';
    protected $fillable = [
        'title',
        'type',
        'content',
    ];
    protected $casts = [
        'content' => 'array',
    ];

    public function category()
    {
        return $this->hasOne("Themes\Jamrock\Faq\Models\FaqCategory", "id", 'type')->with(['translations']);
    }
}
