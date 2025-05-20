<?php

namespace App\Http\Controllers\API\v1\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateJobListingRequest;
use App\Http\Requests\Company\UpdateJobListingRequest;
use App\Http\Resources\JobListing\JobListingCollection;
use App\Http\Resources\JobListing\JobListingResource;
use App\Services\Company\JobListingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobListingController extends Controller
{
    public function __construct(protected JobListingService $jobListingService)
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $response = $this->jobListingService->fetchJobListings($request->all(), $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse(new JobListingCollection($response['data']), $response['message']);
        } catch (\Exception $exception) {
            Log::error('Error fetching company job listings', ['exception' => $exception]);
            return $this->error('An error occurred while fetching your job listings. Kindly try again later.');
        }
    }

    /**
     * @param CreateJobListingRequest $request
     * @return JsonResponse
     */
    public function create(CreateJobListingRequest $request): JsonResponse
    {
        try {
            $response = $this->jobListingService->createJobListing($request->validated(), $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse(JobListingResource::make($response['data']), $response['message']);
        } catch (\Exception $exception) {
            Log::error('Error creating a job listing', ['exception' => $exception]);
            return $this->error('An error occurred while creating a job listing. Kindly try again later.');
        }
    }

    /**
     * @param Request $request
     * @param int|string $jobListingId
     * @return JsonResponse
     */
    public function view(Request $request, int|string $jobListingId): JsonResponse
    {
        try {
            $response = $this->jobListingService->viewJobListing($jobListingId, $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse(JobListingResource::make($response['data']), $response['message']);
        } catch (\Exception $exception) {
            Log::error(
                'Error viewing company job listing',
                ['exception' => $exception, 'job_listing_id' => $jobListingId]
            );
            return $this->error('An error occurred while viewing your job listing. Kindly try again later.');
        }
    }

    /**
     * @param UpdateJobListingRequest $request
     * @param int|string $jobListingId
     * @return JsonResponse
     */
    public function update(UpdateJobListingRequest $request, int|string $jobListingId): JsonResponse
    {
        try {
            $response = $this->jobListingService
                ->updateJobListing($jobListingId, $request->validated(), $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse(JobListingResource::make($response['data']), $response['message']);
        } catch (\Exception $exception) {
            Log::error(
                'Error updating company job listing',
                ['exception' => $exception, 'job_listing_id' => $jobListingId]
            );
            return $this->error('An error occurred while updating your job listing. Kindly try again later.');
        }
    }


    /**
     * @param Request $request
     * @param int|string $jobListingId
     * @return JsonResponse
     */
    public function delete(Request $request, int|string $jobListingId): JsonResponse
    {
        try {
            $response = $this->jobListingService
                ->deleteJobListing($jobListingId, $request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->success($response['message']);
        } catch (\Exception $exception) {
            Log::error(
                'Error deleting company job listing',
                ['exception' => $exception, 'job_listing_id' => $jobListingId]
            );
            return $this->error('An error occurred while deleting your job listing. Kindly try again later.');
        }
    }
}
