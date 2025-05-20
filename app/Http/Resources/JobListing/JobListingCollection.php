<?php

namespace App\Http\Resources\JobListing;

use App\Http\Resources\Common\PaginatedResourceCollection;

class JobListingCollection extends PaginatedResourceCollection
{
    /**
     * The key for the resource array.
     *
     * @var string
     */
    protected string $resourceKey = 'job_listings';
}
