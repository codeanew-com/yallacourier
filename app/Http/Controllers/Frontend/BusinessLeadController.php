<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreBusinessLeadRequest;
use App\Models\FormModel;
use App\Services\Leads\BusinessLeadNotifier;

/** The public business sign-up form. Leads land unread in the admin inbox. */
class BusinessLeadController extends Controller
{
    public function store(StoreBusinessLeadRequest $request, BusinessLeadNotifier $notifier)
    {
        $lead = FormModel::create($request->validated());
        $notifier->notify($lead);

        return redirect()->route('lead.thankyou')->with('success', 'Form submitted successfully!');
    }
}
