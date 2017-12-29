<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class InstallmentResource extends Resource
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
            'value' => $this->value,
            'deadlineDate' => $this->deadline_date,
            'effectiveDate' => $this->effective_date,
            'status' => $this->status,
            'recordTransaction' => new TransactionResource($this->whenLoaded('recordTransaction'))
        ];
    }
}
