<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (!isset($this->id)) {
            return parent::toArray($request);
        }

        return [
            'type'       => 'contact',
            'id'         => $this->id,
            'attributes' => [
                'id'          => $this->id,
                'on_type'     => $this->on_type,
                'on_id'       => $this->on_id,
                'type'        => $this->type,
                'is_primary'  => (bool) $this->is_primary,
                'address_1'   => $this->address_1,
                'address_2'   => $this->address_2,
                'city'        => $this->city,
                'state'       => $this->state,
                'postal_code' => $this->postal_code,
                'country'     => $this->country,
                'notes'       => $this->notes,
                'created_at'  => $this->created_at?->format('m/d/Y h:i A'),
                'updated_at'  => $this->updated_at?->format('m/d/Y h:i A'),
                'deleted_at'  => $this->deleted_at?->format('m/d/Y h:i A'),
            ],
            'relationships' => [
                'contactable' => $this->whenLoaded('contactable'),
                'created_by'  => new UserResource($this->whenLoaded('created_by')),
                'updated_by'  => new UserResource($this->whenLoaded('updated_by')),
            ],
            'links' => [
                'self' => '',
            ],
        ];
    }
}
