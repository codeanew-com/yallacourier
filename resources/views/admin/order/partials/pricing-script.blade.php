{{-- Live preview of App\Services\Orders\OrderPricing — keep the two in sync. The
     server recalculates total (always) and commission (in auto mode) on save,
     so this script only saves the admin from doing the maths by hand. --}}
@push('scripts')
<script>
$(function () {
    var RATES = @json($rates);
    var VAT_RATE = {{ \App\Services\Orders\OrderPricing::VAT_RATE }};
    var UAE = ['', 'are', 'ae', 'uae', 'united arab emirates'];

    var $f = function (name) { return $('#f-' + name); };
    function num($el) { var n = parseFloat($el.val()); return isNaN(n) || n < 0 ? 0 : n; }
    // Half-up rounding to 2 decimals without binary float surprises (1.005 → 1.01), like PHP round().
    function round2(n) { return Number(Math.round(Number(n + 'e2')) + 'e-2'); }
    function money(n) { return 'AED ' + round2(n).toFixed(2); }
    function isUae(v) { return UAE.indexOf(String(v || '').trim().toLowerCase()) !== -1; }
    function isIntl() { return !isUae($f('sender_country').val()) || !isUae($f('reciever_country').val()); }
    function courier() { return RATES[$('#f-courier').val()] || null; }
    function basis() { return $('input[name="commission_basis"]:checked').val() === 'document' ? 'document' : 'parcel'; }

    function commissionRate(c) {
        if (!c) { return 0; }
        var intl = isIntl(), doc = basis() === 'document';
        if (intl) { return doc ? c.comission_document_intl : c.comission_intl; }
        return doc ? c.comission_document : c.comission;
    }
    function defaultFee(c) { return c ? (isIntl() ? c.service_fee_intl : c.service_fee) : null; }

    function recalc() {
        var c = courier();
        var subtotal = num($f('subtotal'));

        // Courier quote mirrors the subtotal unless the admin switches that off.
        var quoteSame = $('#quoteSame').is(':checked');
        $f('courier_quote').prop('readonly', quoteSame).toggleClass('adm-computed', quoteSame);
        if (quoteSame) { $f('courier_quote').val(subtotal.toFixed(2)); }

        // Commission from the courier's configured markup %.
        var auto = $('#commissionAuto').is(':checked') && !!c;
        $('#commissionMode').val(auto ? 'auto' : 'manual');
        $('#commissionAutoBadge').toggle(auto);
        $('#commissionBasisWrap').toggle(!!c);
        $f('comission').prop('readonly', auto).toggleClass('adm-computed', auto);
        var rate = commissionRate(c);
        if (auto) {
            var commission = subtotal > 0 && rate > 0 ? round2(subtotal * rate / (100 + rate)) : 0;
            $f('comission').val(commission.toFixed(2));
            $('#commissionHelp').text(c.name + ' ' + basis() + ' rate, ' + (isIntl() ? 'international' : 'domestic') + ': ' + rate + '% markup → subtotal × ' + rate + ' ÷ ' + (100 + rate) + '.');
        } else if (!c) {
            $('#commissionHelp').text('Choose a courier to calculate the commission automatically.');
        } else {
            $('#commissionHelp').text('Entered manually. Switch on "From courier rate" to use ' + c.name + '\'s ' + rate + '% rate.');
        }

        // Service-fee shortcut when it differs from the courier's default.
        var fee = defaultFee(c);
        var $useFee = $('#useDefaultFee');
        if (fee !== null && round2(num($f('service_fee'))) !== round2(fee)) {
            $useFee.prop('hidden', false).text('Use ' + c.name + ' default (' + money(fee) + ')').data('fee', fee);
        } else {
            $useFee.prop('hidden', true);
        }

        var total = round2(subtotal + num($f('vat')) + num($f('service_fee')));
        $f('total').val(total.toFixed(2));
        $('#sumTotal').text(money(total));
        $('#sumPayable').text(money(num($f('courier_quote')) + num($f('courier_vat'))));
        $('#sumProfit').text(money(num($f('comission')) + num($f('service_fee')) + num($f('over_head'))));

        $('#courierHint').text(c ? (isIntl() ? 'International' : 'Domestic') + ' rates: ' + rate + '% commission, ' + money(fee) + ' service fee.' : '');
    }

    function recalcPackages() {
        var pieces = 0, weight = 0;
        $('#packagesTable tbody tr').each(function () {
            var q = parseInt($(this).find('.dim-qty').val(), 10) || 0;
            var w = parseFloat($(this).find('.dim-weight').val()) || 0;
            pieces += q;
            weight += q * w;
            $(this).find('.line-weight').text(round2(q * w) + ' kg');
        });
        $('#pkgPieces').text(pieces);
        $('#pkgWeight').text(round2(weight));
    }

    // When a courier is picked on an unpriced order, pre-fill its default service fee.
    var feeTouched = num($f('service_fee')) > 0;
    $f('service_fee').on('input', function () { feeTouched = true; });
    $('#f-courier').on('change', function () {
        var fee = defaultFee(courier());
        if (!feeTouched && fee !== null) { $f('service_fee').val(fee.toFixed(2)); }
    });

    $('#useDefaultFee').on('click', function () { $f('service_fee').val(Number($(this).data('fee')).toFixed(2)); feeTouched = true; recalc(); markDirty(); });

    $('[data-fill]').on('click', function () {
        var target = $(this).data('fill'), mode = $(this).data('mode'), value = 0;
        recalc(); // make sure commission/quote are current first
        if (mode === 'commission') { value = num($f('comission')) * VAT_RATE / 100; }
        if (mode === 'quote') { value = num($f('courier_quote')) * VAT_RATE / 100; }
        if (mode === 'vat') { value = num($f('vat')); }
        $f(target).val(round2(value).toFixed(2));
        recalc();
        markDirty();
    });

    $('#orderForm').on('input change', '.money, #quoteSame, #commissionAuto, input[name="commission_basis"], #f-courier, [data-country]', recalc);
    $('#packagesTable').on('input', 'input', recalcPackages);

    // Unsaved-changes guard.
    var dirty = false;
    function markDirty() { dirty = true; $('#dirtyNote').prop('hidden', false); }
    $('#orderForm').on('input change', ':input', markDirty);
    window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });

    // Catch an easy mistake before it's saved: progressing an order with no courier.
    $('#orderForm').on('submit', function (e) {
        var status = $('#f-status').val();
        if ($('#f-courier').val() === '0' && ['processing', 'completed', 'delivered'].indexOf(status) !== -1
            && !window.confirm('No courier is assigned, but the status is "' + status + '". Save anyway?')) {
            e.preventDefault();
            e.stopImmediatePropagation();
            return;
        }
        // Older orders may hold a total that was typed in directly; the total is now
        // derived, so saving with an empty subtotal would reset it to zero.
        var storedTotal = {{ (float) $o->total }};
        if (storedTotal > 0 && num($f('total')) === 0
            && !window.confirm('This order currently has a total of AED ' + storedTotal.toFixed(2) + ', but subtotal, VAT and service fee are all 0, so saving will reset the total to AED 0.00. Save anyway?')) {
            e.preventDefault();
            e.stopImmediatePropagation();
            return;
        }
        dirty = false;
    });

    recalc();
    recalcPackages();
});
</script>
@endpush
