<?php

namespace App\Http\Resources\JobApplication;

use App\Http\Resources\JobListing\JobListingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'resume' => $this->resume,
            'cover_letter' => $this->cover_letter,
            'job_listing' => JobListingResource::make($this->whenLoaded('jobListing')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
