<?php

namespace App\Services\Candidate;

use App\Jobs\ProcessJobApplication;
use App\Models\Candidate;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Traits\ServiceResponseTrait;

class JobApplicationService
{
    use ServiceResponseTrait;

    /**
     * @param array $data
     * @param int|string $jobListingId
     * @param Candidate $candidate
     * @return array
     */
    public function applyForJob(array $data, int|string $jobListingId, Candidate $candidate): array
    {
        if (!JobListing::whereId($jobListingId)->published()->exists()) {
            return $this->serviceResponse('Invalid job listing ID provided.');
        }

        if (JobApplication::whereJobListingId($jobListingId)->whereBelongsTo($candidate)->exists()) {
            return $this->serviceResponse('You\'ve already applied for this job');
        }

        $resumeFile = $data['resume'];
        $coverLetterFile = $data['cover_letter'] ?? null;

        ProcessJobApplication::dispatch(
            $candidate->id,
            $jobListingId,
            $resumeFile->getRealPath(),
            $coverLetterFile?->getRealPath() ?? null
        );

        return $this->serviceResponse('Your application has been submitted and will be processed.', true);
    }

    /**
     * @param array $params
     * @param Candidate $candidate
     * @return array
     */
    public function myApplications(array $params, Candidate $candidate): array
    {
        $applications = JobApplication::whereBelongsTo($candidate)
            ->with('jobListing')
            ->latest()
            ->paginate($params['limit'] ?? 10);

        if (is_null($applications)) {
            return $this->serviceResponse('There are no applications for this candidate');
        }

        return $this->serviceResponse('Job Applications Fetched Successfully', true, $applications);
    }
}
