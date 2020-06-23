<?php

namespace Botble\RealEstate\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface PropertyInterface extends RepositoryInterface
{
    /**
     * @param int $propertyId
     * @param int $limit
     * @return array
     */
    public function getRelatedProperties(int $propertyId, $limit = 4);

    /**
     * @param array $filters
     * @param array $params
     * @return array
     */
    public function getProperties($filters = [], $params = []);
}
