<?php

namespace App\View\Composers;

use App\Models\FormModel;
use App\Models\OrderModel;
use Illuminate\View\View;

/**
 * Sidebar badges, computed once per admin page render (two indexed COUNTs):
 *  - Orders: shipment requests still in status 'pending' (the status every new
 *    booking starts in, ShipmentBookingService) — soft-deleted excluded.
 *  - Business Leads: inbox leads nobody has opened yet (FormModel::scopeUnread).
 */
class AdminSidebarComposer
{
    public function compose(View $view): void
    {
        $view->with('pendingOrdersCount', OrderModel::where('status', 'pending')->count());
        $view->with('unreadLeadsCount', FormModel::unread()->count());
    }
}
