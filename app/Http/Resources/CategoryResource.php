<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $recordsCategory = new CategoryCollection($this->whenLoaded('recordsCategoryRecursive'));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'recordsCategory' => $this->when($recordsCategory->isNotEmpty(), $recordsCategory)
        ];
    }
}
