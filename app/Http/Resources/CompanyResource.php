<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CompanyResource extends JsonResource
{
    public function toArray(Request $request) : array
    {
        if (!isset($this->id)) {
            return parent::toArray($request);
        }

        return [
            'type'          => 'company',
            'id'            => $this->id,
            'attributes'    => [
                'id'         => $this->id,
                'type'       => $this->type,
                'name'       => $this->name,
                'notes'      => $this->notes,
                'created_at' => $this->created_at?->format('m/d/Y h:i A'),
                'updated_at' => $this->updated_at?->format('m/d/Y h:i A'),
                'deleted_at' => $this->deleted_at?->format('m/d/Y h:i A'),
            ],
            'relationships' => [
                'customers'  => CustomerResource::collection($this->whenLoaded('customers')),
                'created_by' => new UserResource($this->whenLoaded('created_by')),
                'updated_by' => new UserResource($this->whenLoaded('updated_by')),
                'deleted_by' => new UserResource($this->whenLoaded('deleted_by')),
                'contacts'   => ContactResource::collection($this->whenLoaded('contacts')),
            ],
            'links'         => [
                'self' => '',
            ]
        ];
    }
}
