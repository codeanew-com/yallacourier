<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourierRequest;
use App\Models\CourierModel;
use App\Models\OrderModel;
use Illuminate\Support\Facades\Session;

class CourierController extends Controller
{
    public function index()
    {
        $usage = OrderModel::where('courier', '>', 0)->selectRaw('courier, COUNT(*) as n')->groupBy('courier')->pluck('n', 'courier');

        return view('admin.courier.index')->with('courier', CourierModel::orderBy('name')->get())->with('usage', $usage);
    }

    public function create()
    {
        return view('admin.courier.form')->with('courier', null);
    }

    public function store(CourierRequest $request)
    {
        $c = new CourierModel;
        $this->fill($c, $request);
        $c->save();
        Session::flash('msg', 'Courier "'.$c->name.'" added.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-couriers.index');
    }

    public function show(string $id)
    {
        return redirect()->route('admin-couriers.edit', $id);
    }

    public function edit(string $id)
    {
        return view('admin.courier.form')->with('courier', CourierModel::findOrFail($id));
    }

    public function update(CourierRequest $request, string $id)
    {
        $c = CourierModel::findOrFail($id);

        if ($request->isStatusToggle()) {
            $c->status = $request->boolean('toggle_status') ? 1 : 0;
            $c->save();
            Session::flash('msg', '"'.$c->name.'" is now '.($c->status ? 'active' : 'inactive').'.');
            Session::flash('class', 'alert-success');

            return redirect()->route('admin-couriers.index');
        }

        $this->fill($c, $request);
        $c->save();
        Session::flash('msg', 'Courier "'.$c->name.'" saved. New rates apply to orders priced from now on.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-couriers.index');
    }

    /**
     * Couriers are referenced by orders, so "removing" one deactivates it.
     * (The old method set status = 0 but never saved, so it did nothing.)
     */
    public function destroy(string $id)
    {
        $c = CourierModel::findOrFail($id);
        $c->status = 0;
        $c->save();
        Session::flash('msg', '"'.$c->name.'" deactivated. Existing orders keep their courier.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-couriers.index');
    }

    private function fill(CourierModel $c, CourierRequest $request): void
    {
        $c->name = $request->name;
        $c->status = $request->status;
        $c->start_time = $request->start_time;
        $c->end_time = $request->end_time;
        foreach (CourierRequest::NUMERIC_FIELDS as $f) {
            $c->$f = (int) $request->input($f);
        }
    }
}
