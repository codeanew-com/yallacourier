<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkBusinessLeadRequest;
use App\Models\FormModel;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Business leads inbox (submissions of the public business form).
 * "Read" = opened by an admin; archived leads leave the inbox but are kept.
 */
class BusinessLeadController extends Controller
{
    private const VIEWS = ['inbox', 'unread', 'archived'];

    public function __construct(private ActivityLogger $activity) {}

    public function index(Request $request)
    {
        $view = in_array($request->input('view'), self::VIEWS, true) ? $request->input('view') : 'inbox';
        $q = trim((string) $request->input('q', ''));

        $query = match ($view) {
            'unread' => FormModel::unread(),
            'archived' => FormModel::archived(),
            default => FormModel::inbox(),
        };
        if ($q !== '') {
            $like = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $q).'%';
            $query->where(function ($w) use ($like) {
                foreach (['first_name', 'last_name', 'email', 'phone', 'company_name', 'position', 'current_delivery_partner'] as $col) {
                    $w->orWhere($col, 'like', $like);
                }
                $w->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$like]);
            });
        }

        $leads = $query->orderBy('id', 'DESC')->paginate(25)->withQueryString();

        // Remember where the admin was so "Back to leads" returns to the same tab/page/search.
        Session::put('leads.list_url', $request->fullUrl());

        return view('admin.forms.index', [
            'leads' => $leads,
            'view' => $view,
            'q' => $q,
            'counts' => [
                'inbox' => FormModel::inbox()->count(),
                'unread' => FormModel::unread()->count(),
                'archived' => FormModel::archived()->count(),
            ],
        ]);
    }

    public function show(int $lead)
    {
        $lead = FormModel::findOrFail($lead);

        // Rule: a lead becomes "read" the first time an admin opens its detail page.
        if ($lead->read_at === null) {
            $lead->read_at = now();
            $lead->save();
        }

        // Neighbours within the same list (inbox or archive), newest first.
        $scope = fn () => $lead->archived_at ? FormModel::archived() : FormModel::inbox();

        return view('admin.forms.show', [
            'lead' => $lead,
            'newer' => $scope()->where('id', '>', $lead->id)->orderBy('id')->value('id'),
            'older' => $scope()->where('id', '<', $lead->id)->orderBy('id', 'DESC')->value('id'),
            'backUrl' => $this->listUrl(),
        ]);
    }

    public function archive(int $lead)
    {
        $lead = FormModel::findOrFail($lead);
        $lead->archived_at = now();
        $lead->read_at = $lead->read_at ?? now(); // archiving is handling it, so it no longer counts as unread
        $lead->save();

        return $this->back('Lead from '.$lead->fullName().' archived. You can restore it from the Archived tab.');
    }

    public function restore(int $lead)
    {
        $lead = FormModel::findOrFail($lead);
        $lead->archived_at = null;
        $lead->save();

        return $this->back('Lead from '.$lead->fullName().' restored to the inbox.');
    }

    public function markUnread(int $lead)
    {
        $lead = FormModel::findOrFail($lead);
        $lead->read_at = null;
        $lead->save();

        // Leave the detail page, otherwise reopening it would mark it read again straight away.
        Session::flash('msg', 'Lead from '.$lead->fullName().' marked as unread.');
        Session::flash('class', 'alert-success');

        return redirect($this->listUrl());
    }

    /** Permanent delete — the UI asks for confirmation first, and it is logged. */
    public function destroy(int $lead)
    {
        $lead = FormModel::findOrFail($lead);
        $name = $lead->fullName();
        $this->activity->record('Business lead #'.$lead->id.' ('.$name.', '.$lead->email.', '.$lead->company_name.') permanently deleted');
        $lead->delete();

        Session::flash('msg', 'Lead from '.$name.' permanently deleted.');
        Session::flash('class', 'alert-success');

        return redirect($this->listUrl());
    }

    public function bulk(BulkBusinessLeadRequest $request)
    {
        $query = FormModel::whereIn('id', $request->ids);
        $n = (clone $query)->count();
        switch ($request->action) {
            case 'read':
                $query->whereNull('read_at')->update(['read_at' => now()]);
                $msg = $n.' lead(s) marked as read.';
                break;
            case 'unread':
                $query->update(['read_at' => null]);
                $msg = $n.' lead(s) marked as unread.';
                break;
            case 'archive':
                $query->update(['archived_at' => now()]);
                FormModel::whereIn('id', $request->ids)->whereNull('read_at')->update(['read_at' => now()]);
                $msg = $n.' lead(s) archived.';
                break;
            case 'restore':
                $query->update(['archived_at' => null]);
                $msg = $n.' lead(s) restored to the inbox.';
                break;
            case 'delete':
                $this->activity->record($n.' business lead(s) permanently deleted (ids: '.implode(', ', array_slice($request->ids, 0, 50)).')');
                $query->delete();
                $msg = $n.' lead(s) permanently deleted.';
                break;
        }

        return $this->back($msg);
    }

    private function listUrl(): string
    {
        return Session::get('leads.list_url', route('admin.businessleads'));
    }

    private function back(string $msg)
    {
        Session::flash('msg', $msg);
        Session::flash('class', 'alert-success');

        return redirect()->back();
    }
}
