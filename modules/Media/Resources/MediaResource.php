<?php

namespace Modules\Media\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{

    public function toArray($request)
    {
        $res  = parent::toArray($request);
        $res['created_at'] = $this->created_at ? display_datetime($this->created_at) : '';
        return $res;
    }
}
