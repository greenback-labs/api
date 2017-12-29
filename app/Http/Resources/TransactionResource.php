<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TransactionResource extends Resource
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
            'id' => $this->id,
            'transferCode' => $this->transfer_code,
            'type' => $this->type,
            'value' => $this->value,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'recordAccount' => new AccountResource($this->whenLoaded('recordAccount')),
            'recordCategory' => new CategoryResource($this->whenLoaded('recordCategory')),
            'recordPerson' => new PersonResource($this->whenLoaded('recordPerson')),
            'recordsInstallment' => new InstallmentCollection($this->whenLoaded('recordsInstallment'))
        ];
    }
}
