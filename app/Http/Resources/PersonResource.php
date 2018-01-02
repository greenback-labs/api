<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PersonResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $recordsPerson = new PersonCollection($this->whenLoaded('recordsPersonRecursive'));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'recordsPerson' => $this->when($recordsPerson->isNotEmpty(), $recordsPerson)
        ];
    }
}
