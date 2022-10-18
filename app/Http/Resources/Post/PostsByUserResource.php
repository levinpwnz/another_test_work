<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsByUserResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
