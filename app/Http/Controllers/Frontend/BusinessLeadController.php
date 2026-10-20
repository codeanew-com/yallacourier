<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreBusinessLeadRequest;
use App\Models\FormModel;

/** The public business sign-up form. Leads land unread in the admin inbox. */
class BusinessLeadController extends Controller
{
    public function store(StoreBusinessLeadRequest $request)
    {
        FormModel::create($request->validated());

        return redirect()->route('lead.thankyou')->with('success', 'Form submitted successfully!');
    }
}
