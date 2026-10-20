{{-- One dialog shared by every "Suspend / ban" button on the page. --}}
<div class="modal fade" id="accessModal" tabindex="-1" aria-labelledby="accessModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="" class="modal-content" id="accessForm">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="accessModalTitle">Restrict access: <span data-name></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <fieldset class="mb-3">
                    <legend class="form-label" style="font-size:.8125rem;">Action</legend>
                    @foreach([
                        'suspend' => ['Suspend', 'Temporary. Can end automatically on a date.'],
                        'ban' => ['Ban', 'Permanent, for abuse or fraud.'],
                        'disable' => ['Disable account', 'Switch the account off, e.g. at the customer’s request.'],
                    ] as $val => [$label, $help])
                        <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="action" id="acc-{{ $val }}" value="{{ $val }}" @checked(old('action', 'suspend') === $val)>
                            <label class="form-check-label" for="acc-{{ $val }}"><strong>{{ $label }}</strong> <span class="text-muted small">{{ $help }}</span></label>
                        </div>
                    @endforeach
                </fieldset>
                <div class="mb-3">
                    <label class="form-label" for="acc-reason">Reason <span class="text-danger" aria-hidden="true">*</span></label>
                    <textarea class="form-control @error('reason', 'status') is-invalid @enderror" id="acc-reason" name="reason" rows="3" maxlength="1000" required placeholder="e.g. Repeated chargebacks on orders #1201 and #1207">{{ old('reason') }}</textarea>
                    @error('reason', 'status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Visible to admins on the customer’s profile and in the activity log.</div>
                </div>
                <div class="mb-3" id="acc-until-wrap">
                    <label class="form-label" for="acc-until">Suspended until <span class="text-muted">(optional)</span></label>
                    <input type="datetime-local" class="form-control @error('suspended_until', 'status') is-invalid @enderror" id="acc-until" name="suspended_until" value="{{ old('suspended_until') }}" min="{{ now()->addHour()->format('Y-m-d\TH:i') }}">
                    @error('suspended_until', 'status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="d-flex gap-2 mt-1 small">
                        <span class="text-muted">Quick:</span>
                        <button type="button" class="adm-link-btn" data-days="1">1 day</button>
                        <button type="button" class="adm-link-btn" data-days="7">7 days</button>
                        <button type="button" class="adm-link-btn" data-days="30">30 days</button>
                        <button type="button" class="adm-link-btn" data-days="0">Until reactivated</button>
                    </div>
                </div>
                <div class="alert alert-warning small mb-0">
                    The customer is signed out of every device immediately and cannot log in until reactivated. Their orders, payments and wallet history are kept.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger" id="acc-submit">Suspend account</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
$(function () {
    var $modal = $('#accessModal'), $form = $('#accessForm');
    function sync() {
        var a = $form.find('input[name=action]:checked').val();
        $('#acc-until-wrap').toggle(a === 'suspend');
        if (a !== 'suspend') { $('#acc-until').val(''); }
        $('#acc-submit').text({ suspend: 'Suspend account', ban: 'Ban customer', disable: 'Disable account' }[a]);
    }
    $modal.on('show.bs.modal', function (e) {
        var $btn = $(e.relatedTarget);
        if ($btn.length && $btn.data('url')) {
            $form.attr('action', $btn.data('url'));
            $modal.find('[data-name]').text($btn.data('name'));
        }
        sync();
    }).on('shown.bs.modal', function () { $('#acc-reason').trigger('focus'); });
    $form.on('change', 'input[name=action]', sync);
    $('[data-days]').on('click', function () {
        var d = parseInt($(this).data('days'), 10);
        if (!d) { $('#acc-until').val(''); return; }
        var t = new Date(Date.now() + d * 864e5), p = function (n) { return String(n).padStart(2, '0'); };
        $('#acc-until').val(t.getFullYear() + '-' + p(t.getMonth() + 1) + '-' + p(t.getDate()) + 'T' + p(t.getHours()) + ':' + p(t.getMinutes()));
    });
    // Remember which customer the dialog was for, so it can re-open after a validation error.
    $form.on('submit', function () {
        $form.find('input[name=_status_url], input[name=_status_name]').remove();
        $form.append($('<input type="hidden" name="_status_url">').val($form.attr('action')))
             .append($('<input type="hidden" name="_status_name">').val($modal.find('[data-name]').text()));
    });
    @if($errors->status->any() && preg_match('#^'.preg_quote(url('/admin/customers/'), '#').'\d+/status$#', (string) old('_status_url')))
        $form.attr('action', @json(old('_status_url')));
        $modal.find('[data-name]').text(@json(old('_status_name')));
        bootstrap.Modal.getOrCreateInstance($modal[0]).show();
    @endif
});
</script>
@endpush
