<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\CustomerTopupModel;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transactions.index');
    }

    /** Historical wallet top-ups (top-ups themselves were switched off 2026-10-19). */
    public function topups()
    {
        $topups = CustomerTopupModel::orderBy('id', 'DESC')->get();

        return view('admin.customer.topuptransactions.index')
            ->with('topups', $topups)
            ->with('customers', CustomerModel::whereIn('id', $topups->pluck('customer_id'))->get()->keyBy('id'));
    }
}
