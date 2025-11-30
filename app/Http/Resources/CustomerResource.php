<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request) : array
    {

        if (!isset($this->id)) {
            return parent::toArray($request);
        }

        return [
            'type'          => 'customer',
            'id'            => $this->id,
            'attributes'    => [
                'id'         => $this->id,
                'company_id' => $this->company_id,
                'title'      => $this->title,
                'prefix'     => $this->prefix,
                'first_name' => $this->first_name,
                'last_name'  => $this->last_name,
                'full_name'  => $this->full_name,
                'suffix'     => $this->suffix,
                'email'      => $this->email,
                'created_at' => $this->created_at?->format('m/d/Y h:i A'),
                'updated_at' => $this->updated_at?->format('m/d/Y h:i A'),
                'deleted_at' => $this->deleted_at?->format('m/d/Y h:i A'),
            ],
            'relationships' => [
                'created_by' => new UserResource($this->whenLoaded('created_by')),
                'updated_by' => new UserResource($this->whenLoaded('updated_by')),
                'deleted_by' => new UserResource($this->whenLoaded('deleted_by')),
                'company'    => new Customer($this->whenLoaded('company')),
                'contact'    => new ContactResource($this->whenLoaded('contact')),
            ],
            'links'         => [
                'self' => route('customers.profile', $this->id),
            ]
        ];
    }
}
