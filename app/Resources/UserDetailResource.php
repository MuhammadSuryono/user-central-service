<?php

namespace App\Resources;

use Illuminate\Http\Request;

class UserDetailResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'division' => $this->division->name,
            'position' => $this->position->name,
            'level' => $this->level->name,
        ];
    }
}
