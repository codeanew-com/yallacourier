<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateNotificationSettingsRequest;
use App\Models\Setting;
use App\Services\ActivityLogger;
use App\Services\Leads\BusinessLeadNotifier;
use Illuminate\Support\Facades\Session;

/** Where admin notification emails go (Configuration → Notifications). */
class NotificationSettingsController extends Controller
{
    public function edit()
    {
        return view('admin.setting.notifications.edit', [
            'leadEmails' => BusinessLeadNotifier::recipients(),
        ]);
    }

    public function update(UpdateNotificationSettingsRequest $request, ActivityLogger $activity)
    {
        $before = BusinessLeadNotifier::recipients();
        $after = $request->input('lead_emails', []);

        Setting::put(Setting::BUSINESS_LEAD_EMAILS, implode(', ', $after));

        if ($before !== $after) {
            $activity->record('Business lead notification emails changed: "'.implode(', ', $before).'" → "'.implode(', ', $after).'"');
        }

        Session::flash('msg', $after
            ? 'Saved. New business leads will be emailed to '.implode(', ', $after).'.'
            : 'Saved. Business lead emails are turned off (leads still appear in the admin).');
        Session::flash('class', $after ? 'alert-success' : 'alert-warning');

        return redirect()->route('admin.settings.notifications');
    }
}
