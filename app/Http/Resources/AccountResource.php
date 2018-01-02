<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AccountResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $recordsAccount = new AccountCollection($this->whenLoaded('recordsAccountRecursive'));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'recordsAccount' => $this->when($recordsAccount->isNotEmpty(), $recordsAccount)
        ];
    }
}
