<?php

namespace App\Http\Resources\JobApplication;

use App\Http\Resources\Common\PaginatedResourceCollection;

class JobApplicationCollection extends PaginatedResourceCollection
{
    /**
     * The key for the resource array.
     *
     * @var string
     */
    protected string $resourceKey = 'job_applications';
}
