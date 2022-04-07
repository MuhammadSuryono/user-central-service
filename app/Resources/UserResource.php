<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'division' => $this->userDetail->division->name ?? 'Not Registered',
            'position' => $this->userDetail->position->name ?? 'Not Registered',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
