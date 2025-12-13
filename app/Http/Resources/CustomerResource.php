<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!isset($this->id)) {
            return parent::toArray($request);
        }

        return [
            'type'          => 'customer',
            'id'            => $this->id,
            'attributes'    => [
                'id'                => $this->id,
                'company_id'        => $this->company_id,
                'title'             => $this->title,
                'prefix'            => $this->prefix,
                'first_name'        => $this->first_name,
                'last_name'         => $this->last_name,
                'suffix'            => $this->suffix,
                'full_name'         => trim(($this->prefix ? $this->prefix . ' ' : '') . 
                                           $this->first_name . ' ' . 
                                           $this->last_name . 
                                           ($this->suffix ? ' ' . $this->suffix : '')),
                'email'             => $this->email,
                'email_verified_at' => $this->email_verified_at?->format('m/d/Y h:i A'),
                'created_at'        => $this->created_at?->format('m/d/Y h:i A'),
                'updated_at'        => $this->updated_at?->format('m/d/Y h:i A'),
                'deleted_at'        => $this->deleted_at?->format('m/d/Y h:i A'),
            ],
            'relationships' => [
                'company'    => new CompanyResource($this->whenLoaded('company')),
                'created_by' => new UserResource($this->whenLoaded('created_by')),
                'updated_by' => new UserResource($this->whenLoaded('updated_by')),
                'deleted_by' => new UserResource($this->whenLoaded('deleted_by')),
            ],
            'links'         => [
                'self' => '',
            ]
        ];
    }
}
