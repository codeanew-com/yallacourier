{{-- New country page: picking the destination pre-fills an empty title (and so the slug). --}}
@push('scripts')
<script>
$(function () {
    var $title = $('[data-slug-form] [data-slug-source]');
    $('[data-country-select]').on('change', function () {
        if ($title.val() === '' || $title.data('autofilled')) {
            $title.val('Ship to ' + $(this).find('option:selected').text().trim()).data('autofilled', true).trigger('input');
        }
    });
    $title.on('keydown', function () { $title.data('autofilled', false); });
});
</script>
@endpush
