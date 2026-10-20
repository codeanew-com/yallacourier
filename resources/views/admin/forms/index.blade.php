@extends('admin.layouts.master')
@section('title', 'Business leads')
@section('content')
@php
    $tabs = ['inbox' => 'Inbox', 'unread' => 'Unread', 'archived' => 'Archived'];
    $tabUrl = fn ($v) => route('admin.businessleads', array_filter(['view' => $v === 'inbox' ? null : $v, 'q' => $q ?: null]));
@endphp
@include('admin.partials.page-header', [
    'title' => 'Business leads',
    'subtitle' => $counts['unread'] > 0
        ? '<strong>'.$counts['unread'].' unread</strong> · a lead is marked read when you open it.'
        : 'All caught up. A lead is marked read when you open it.',
    'crumbs' => ['Business leads' => null],
    'actions' => '<a href="'.route('admin.settings.notifications').'" class="btn btn-light btn-sm" title="Change who is emailed about new leads"><i class="bx bx-bell me-1"></i>'
        .e(($leadEmails = \App\Services\Leads\BusinessLeadNotifier::recipients()) ? 'Emailed to '.implode(', ', $leadEmails) : 'Lead emails off').'</a>',
])

<nav class="adm-tabs" aria-label="Lead folders">
    @foreach($tabs as $key => $label)
        <a href="{{ $tabUrl($key) }}" class="{{ $view === $key ? 'active' : '' }}" @if($view === $key) aria-current="page" @endif>{{ $label }}<span class="adm-count">{{ number_format($counts[$key]) }}</span></a>
    @endforeach
</nav>

<div class="card">
    <div class="card-body">
        <form method="get" action="{{ route('admin.businessleads') }}" class="adm-filterbar mb-3" role="search">
            @if($view !== 'inbox')<input type="hidden" name="view" value="{{ $view }}">@endif
            <div class="adm-grow">
                <label class="form-label visually-hidden" for="f-q">Search leads</label>
                <input type="search" id="f-q" name="q" value="{{ $q }}" class="form-control" placeholder="Search name, company, email, phone…">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bx bx-search me-1"></i>Search</button>
            @if($q !== '')<a href="{{ $tabUrl($view) }}" class="btn btn-light">Clear</a>@endif
        </form>

        @if($leads->isEmpty())
            <div class="adm-empty">
                <i class="bx {{ $view === 'archived' ? 'bx-archive' : 'bx-envelope-open' }}"></i>
                {{ $q !== '' ? 'No leads match "'.$q.'".' : ($view === 'archived' ? 'No archived leads.' : ($view === 'unread' ? 'No unread leads. You are all caught up.' : 'No leads yet.')) }}
            </div>
        @else
        <form method="post" action="{{ route('admin.businessleads.bulk') }}" id="leadsBulkForm">
            @csrf
            {{-- Same pattern as Orders: bulk actions show above the table when rows are selected. --}}
            <div class="adm-bulkbar" id="bulkBar" role="region" aria-label="Bulk actions" aria-live="polite">
                <div><strong id="bulkCount">0</strong> selected</div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-outline-light" id="bulkClear">Clear selection</button>
                    @if($view === 'archived')
                        <button type="submit" name="action" value="restore" class="btn btn-sm btn-light"><i class="bx bx-undo me-1"></i>Restore</button>
                    @else
                        <button type="submit" name="action" value="read" class="btn btn-sm btn-light">Mark read</button>
                        <button type="submit" name="action" value="unread" class="btn btn-sm btn-light">Mark unread</button>
                        <button type="submit" name="action" value="archive" class="btn btn-sm btn-light"><i class="bx bx-archive-in me-1"></i>Archive</button>
                    @endif
                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" data-bulk-confirm="Permanently delete the selected lead(s)? This cannot be undone. Archive them instead if you may need them later."><i class="bx bx-trash-alt me-1"></i>Delete</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:36px;"><input type="checkbox" class="form-check-input" id="selectAll" aria-label="Select all leads on this page"></th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Received</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($leads as $lead)
                        @php $unread = $lead->isUnread(); @endphp
                        <tr class="{{ $unread ? 'adm-row-unread' : '' }}">
                            <td><input type="checkbox" name="ids[]" value="{{ $lead->id }}" class="form-check-input row-check" aria-label="Select lead from {{ $lead->fullName() }}"></td>
                            <td>
                                <a href="{{ route('admin.businessleads.show', $lead->id) }}" class="d-flex align-items-center gap-2 text-reset">
                                    <span class="adm-unread-dot {{ $unread ? '' : 'invisible' }}" aria-hidden="true"></span>
                                    <span>
                                        <span class="{{ $unread ? 'fw-bold' : 'fw-medium' }}">{{ $lead->fullName() }}</span>
                                        @if($unread)<span class="visually-hidden">(unread)</span>@endif
                                        <span class="d-block small text-muted">{{ $lead->position }}</span>
                                    </span>
                                </a>
                            </td>
                            <td class="{{ $unread ? 'fw-semibold' : '' }}">{{ $lead->subject() }}</td>
                            <td class="small text-muted text-nowrap" title="{{ optional($lead->created_at)->format('d M Y, H:i') }}">{{ optional($lead->created_at)->format('d M Y') }}<br>{{ optional($lead->created_at)->diffForHumans() }}</td>
                            <td>
                                @if($lead->archived_at)
                                    <span class="adm-pill adm-pill-neutral">Archived</span>
                                @elseif($unread)
                                    <span class="adm-pill adm-pill-info">New</span>
                                @else
                                    <span class="adm-pill adm-pill-success">Read</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.businessleads.show', $lead->id) }}" class="btn btn-sm btn-light"><i class="bx bx-show me-1"></i>View</a>
                                @if($lead->archived_at)
                                    <button type="submit" form="restore-{{ $lead->id }}" class="btn btn-sm btn-light"><i class="bx bx-undo me-1"></i>Restore</button>
                                @else
                                    <button type="submit" form="archive-{{ $lead->id }}" class="btn btn-sm btn-light"><i class="bx bx-archive-in me-1"></i>Archive</button>
                                @endif
                                <button type="submit" form="delete-{{ $lead->id }}" class="btn btn-sm btn-outline-danger" aria-label="Delete lead from {{ $lead->fullName() }}"><i class="bx bx-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        {{-- Per-row action forms live outside the bulk form (forms can't be nested); the row buttons point here via form="…". --}}
        @foreach($leads as $lead)
            @if($lead->archived_at)
                <form id="restore-{{ $lead->id }}" method="post" action="{{ route('admin.businessleads.restore', $lead->id) }}" class="d-none">@csrf</form>
            @else
                <form id="archive-{{ $lead->id }}" method="post" action="{{ route('admin.businessleads.archive', $lead->id) }}" class="d-none">@csrf</form>
            @endif
            <form id="delete-{{ $lead->id }}" method="post" action="{{ route('admin.businessleads.destroy', $lead->id) }}" class="d-none"
                  data-confirm="Permanently delete the lead from {{ $lead->fullName() }}? This cannot be undone.{{ $lead->archived_at ? '' : ' Archive it instead if you may need it later.' }}">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <div class="adm-table-footer">
            <div>Showing {{ $leads->firstItem() }}–{{ $leads->lastItem() }} of {{ number_format($leads->total()) }}</div>
            {{ $leads->onEachSide(1)->links() }}
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
$(function () {
    var $checks = $('.row-check');
    function refresh() {
        var n = $checks.filter(':checked').length;
        $('#bulkCount').text(n);
        $('#bulkBar').toggleClass('show', n > 0);
        $('#selectAll').prop('checked', n > 0 && n === $checks.length);
    }
    $('#selectAll').on('change', function () { $checks.prop('checked', this.checked); refresh(); });
    $checks.on('change', refresh);
    $('#bulkClear').on('click', function () { $checks.prop('checked', false); refresh(); });
    // Only the destructive bulk action asks for confirmation.
    $('#leadsBulkForm').on('click', '[data-bulk-confirm]', function (e) {
        if (!window.confirm($(this).data('bulk-confirm'))) { e.preventDefault(); }
    });
});
</script>
@endpush
@endsection
