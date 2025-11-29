<?php

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Contact */
class ContactResource extends JsonResource
{
    public function toArray(Request $request) : array
    {
        return [
            'id'          => $this->id,
            'on'          => $this->on,
            'on_id'       => $this->on_id,
            'type'        => $this->type,
            'phone'       => $this->phone,
            'fax'         => $this->fax,
            'email'       => $this->email,
            'address_1'   => $this->address_1,
            'address_2'   => $this->address_2,
            'city'        => $this->city,
            'state'       => $this->state,
            'postal_code' => $this->postal_code,
            'country'     => $this->country,
            'notes'       => $this->notes,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            
        ];
    }
}
