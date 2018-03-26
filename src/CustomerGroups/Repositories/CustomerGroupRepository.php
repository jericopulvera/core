<?php

namespace Laracommerce\Core\CustomerGroups\Repositories;

use Laracommerce\Core\Base\BaseRepository;
use Laracommerce\CustomerGroup\Core\CustomerGroup;

class CustomerGroupRepository extends BaseRepository
{
    public function __construct(CustomerGroup $model)
    {
        parent::__construct($model);
    }
}
