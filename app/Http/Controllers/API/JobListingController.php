<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobListing\JobListingCollection;
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
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $response = $this->jobListingService->fetchPublishedJobListings($request->all());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse(new JobListingCollection($response['data']), $response['message']);
        } catch (\Exception $exception) {
            Log::error('Error fetching published job listings', ['exception' => $exception]);
            return $this->error('An error occurred while fetching job listings. Kindly try again later.');
        }
    }
}
