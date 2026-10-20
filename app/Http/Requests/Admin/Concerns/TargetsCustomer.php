<?php

namespace App\Http\Requests\Admin\Concerns;

use App\Models\CustomerModel;

/** For admin requests on /admin/customers/{id}/…: the customer being acted on (404 if missing). */
trait TargetsCustomer
{
    private ?CustomerModel $targetCustomer = null;

    public function customer(): CustomerModel
    {
        return $this->targetCustomer ??= CustomerModel::findOrFail($this->route('id'));
    }
}
