<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\FaqModel;
use Illuminate\Support\Facades\Session;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faq.index')->with('faq', FaqModel::orderBy('id', 'DESC')->get());
    }

    public function create()
    {
        return view('admin.faq.form')->with('faq', null);
    }

    public function store(FaqRequest $request)
    {
        FaqModel::create($request->faqData());
        Session::flash('msg', 'FAQ added.');
        Session::flash('class', 'alert-success');

        return $request->input('after') === 'new'
            ? redirect()->route('admin-faq.create')
            : redirect()->route('admin-faq.index');
    }

    public function show(string $id)
    {
        return redirect()->route('admin-faq.edit', $id);
    }

    public function edit(string $id)
    {
        return view('admin.faq.form')->with('faq', FaqModel::findOrFail($id));
    }

    public function update(FaqRequest $request, string $id)
    {
        FaqModel::findOrFail($id)->update($request->faqData());
        Session::flash('msg', 'FAQ saved.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-faq.index');
    }

    public function destroy(string $id)
    {
        FaqModel::findOrFail($id)->delete();
        Session::flash('msg', 'FAQ deleted.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-faq.index');
    }
}
