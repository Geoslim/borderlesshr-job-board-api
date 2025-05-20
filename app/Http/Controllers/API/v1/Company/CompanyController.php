<?php

namespace App\Http\Controllers\API\v1\Company;

use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService)
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
            $response = $this->companyService->fetchDashboardData($request->user());

            if (!$response['success']) {
                return $this->error($response['message']);
            }

            return $this->successResponse($response['data'], $response['message']);
        } catch (\Exception $exception) {
            Log::error('Error fetching company dashboard data', ['exception' => $exception]);
            return $this->error('An error occurred while fetching company dashboard data. Kindly try again later.');
        }
    }
}
