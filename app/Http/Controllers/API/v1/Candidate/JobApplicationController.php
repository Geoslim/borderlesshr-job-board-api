<?php

namespace App\Http\Controllers\API\v1\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\CreateJobApplicationRequest;
use App\Http\Resources\JobApplication\JobApplicationCollection;
use App\Services\Candidate\JobApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobApplicationController extends Controller
{
    public function __construct(protected JobApplicationService $jobApplicationService)
    {
        //
    }

    public function apply(CreateJobApplicationRequest $request, int|string $jobListingId): JsonResponse
    {
        try {
            $response = $this->jobApplicationService
                ->applyForJob($request->validated(), $jobListingId, $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->success($response['message']);
        } catch (\Exception $exception) {
            Log::error('Job application error', ['exception' => $exception, 'job_listing' => $jobListingId]);
            return $this->error('An error occurred while applying for this job. Kindly try again later.');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function myApplications(Request $request): JsonResponse
    {
        try {
            $response = $this->jobApplicationService
                ->myApplications($request->all(), $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse(new JobApplicationCollection($response['data']), $response['message']);
        } catch (\Exception $exception) {
            Log::error('error fetching candidate job applications', ['exception' => $exception]);
            return $this->error('An error occurred while fetching your job applications. Kindly try again later.');
        }
    }
}
