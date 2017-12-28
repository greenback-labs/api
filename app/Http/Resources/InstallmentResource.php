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
            'deadlineDate' => $this->deadlineDate,
            'effectiveDate' => $this->effectiveDate,
            'status' => $this->status,
            'recordTransaction' => new TransactionResource($this->recordTransaction)
        ];
    }
}
