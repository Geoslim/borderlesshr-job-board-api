<?php

namespace App\Services\Company;

use App\Models\Company;
use App\Models\JobListing;
use App\Traits\ServiceResponseTrait;

class JobListingService
{
    use ServiceResponseTrait;

    /**
     * @param array $params
     * @param Company $company
     * @return array
     */
    public function fetchJobListings(array $params, Company $company): array
    {
        $jobListings = JobListing::whereBelongsTo($company)
            ->latest()
            ->paginate($params['limit'] ?? 10);

        if ($jobListings->isEmpty()) {
            return $this->serviceResponse('No job listings found.');
        }

        return $this->serviceResponse('Job Listings Fetched Successfully', true, $jobListings);
    }

    /**
     * @param array $data
     * @param Company $company
     * @return array
     */
    public function createJobListing(array $data, Company $company): array
    {
        $jobListing = $company->jobListings()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'location' => $data['location'],
            'salary_range' => $data['salary_range'] ?? null,
            'is_remote' => $data['is_remote'],
            'is_published' => $data['is_published'],
            'published_at' => $data['is_published'] ? now() : null
        ]);

        return $this->serviceResponse('Job Listing Created Successfully', true, $jobListing);
    }

    /**
     * @param int|string $jobListingId
     * @param Company $company
     * @return array
     */
    public function viewJobListing(int|string $jobListingId, Company $company): array
    {
        $jobListing = JobListing::whereBelongsTo($company)
            ->whereId($jobListingId)
            ->first();

        if (is_null($jobListing)) {
            return $this->serviceResponse('Invalid job listing ID provided.');
        }

        return $this->serviceResponse('Job Listing Viewed Successfully', true, $jobListing);
    }

    /**
     * @param int|string $jobListingId
     * @param array $data
     * @param Company $company
     * @return array
     */
    public function updateJobListing(int|string $jobListingId, array $data, Company $company): array
    {
        $jobListing = JobListing::whereBelongsTo($company)
            ->whereId($jobListingId)
            ->first();

        if (is_null($jobListing)) {
            return $this->serviceResponse('Invalid job listing ID provided.');
        }

        $jobListing->update([
            'title' => $data['title'] ?? $jobListing->title,
            'description' => $data['description'] ?? $jobListing->description,
            'location' => $data['location'] ?? $jobListing->location,
            'salary_range' => $data['salary_range'] ?? $jobListing->salary_range,
            'is_remote' => $data['is_remote'] ?? $jobListing->is_remote,
            'is_published' => $data['is_published'] ?? $jobListing->is_published,
            'published_at' => $data['is_published'] ? now() : $jobListing->published_at
        ]);

        return $this->serviceResponse('Job Listing Updated Successfully', true, $jobListing);
    }

    /**
     * @param int|string $jobListingId
     * @param Company $company
     * @return array
     */
    public function deleteJobListing(int|string $jobListingId, Company $company): array
    {
        $jobListing = JobListing::whereBelongsTo($company)
            ->whereId($jobListingId)
            ->first();

        if (is_null($jobListing)) {
            return $this->serviceResponse('Invalid job listing ID provided.');
        }

        $jobListing->delete();

        return $this->serviceResponse('Job Listing Deleted Successfully', true);
    }
}
