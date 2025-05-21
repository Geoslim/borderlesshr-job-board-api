<?php

namespace App\Jobs;

use App\Models\JobApplication;
use App\Services\Cloudinary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessJobApplication implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int|string $candidateId,
        public int|string $jobListingId,
        public string $resumeFile,
        public ?string $coverLetterFile = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Cloudinary $cloudinaryService): void
    {
        $resumeUrl = null;
        $coverLetterUrl = null;

        try {
            if (!file_exists($this->resumeFile)) {
                Log::debug('fsfere', [$this->resumeFile]);
                // Notify user of failed application
                throw new \Exception("Resume file not found at $this->resumeFile");
            }

            $resumeUploadResponse = $cloudinaryService->upload($this->resumeFile);
            $resumeUrl = $resumeUploadResponse;

            if ($this->coverLetterFile !== null) {
                if (!file_exists($this->coverLetterFile)) {
                    // Notify user of failed application
                    throw new \Exception("Cover letter file not found at $this->coverLetterFile");
                }

                $coverLetterUploadResponse = $cloudinaryService->upload($this->coverLetterFile);
                $coverLetterUrl = $coverLetterUploadResponse;
            }

            JobApplication::create([
                'candidate_id' => $this->candidateId,
                'job_listing_id' => $this->jobListingId,
                'cover_letter' => $coverLetterUrl,
                'resume' => $resumeUrl,
            ]);

            Log::info("Job application created for Candidate ID: $this->candidateId on Job ID: $this->jobListingId");
        } catch (\Exception $e) {
            Log::error('Error processing job application: ', [$e]);
            // Notify user of failed application
            $this->fail($e);
        }
    }
}
