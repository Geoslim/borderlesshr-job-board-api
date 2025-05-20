<?php

namespace App\Services\Company;

use App\Models\Company;
use App\Models\JobApplication;
use App\Traits\ServiceResponseTrait;

class CompanyService
{
    use ServiceResponseTrait;

    /**
     * @param Company $company
     * @return array
     */
    public function fetchDashboardData(Company $company): array
    {
        $response['number_of_job_posts'] = $company->jobListings()->count();
        $response['total_applications_received'] = JobApplication::whereHas(
            'jobListing',
            function ($query) use ($company) {
                $query->where('company_id', $company->id);
            }
        )->count();

        return $this->serviceResponse('Company Dashboard Data Fetched Successfully', true, $response);
    }
}
