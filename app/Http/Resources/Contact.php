<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'contact_id' => $this->id,
                'name' => $this->name,
                'city' => $this->city,
                'adress' => $this->adress,
                'phone' => $this->phone,
                'last_updated' => $this->updated_at->diffForHumans(),
                'links' => [
                    'self' => $this->path()
                ]
        ];
    }
}
