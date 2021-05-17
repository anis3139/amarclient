<?php

namespace App\Http\Resources;

use App\Models\Supplier;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'type' => $this->transaction_type == Supplier::class ? 'Supplier' : 'Customer',
            'type_id' => $this->transaction_id,
            'taken' => $this->taken,
            'given' => $this->given,
            'date' => $this->date,
        ];
    }
}
