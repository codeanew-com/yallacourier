{{-- Form automation for content screens:
     [data-slug-source] → [data-slug-target]   slug follows the title until edited by hand
                                                (or never, when the target has data-locked — i.e. editing a live page)
     [data-follow-title]                       fills from the title while left empty / untouched
     [data-follow-slug="https://site/"]        canonical URL follows the slug while untouched
     [data-count="N"]                          live character counter with a recommended length --}}
@push('scripts')
<script>
$(function () {
    function slugify(s) {
        return String(s).toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g, '')
            .replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    }
    $('[data-slug-form]').each(function () {
        var $form = $(this);
        var $title = $form.find('[data-slug-source]');
        var $slug = $form.find('[data-slug-target]');
        var $seo = $form.find('[data-follow-title]');
        var $canon = $form.find('[data-follow-slug]');

        // A field "follows" its source while it is empty or still equals what we generated.
        function follows($el, generated) { return $el.length && ($el.val() === '' || $el.val() === generated); }
        var lastSlug = slugify($title.val()), lastTitle = $title.val();
        var lastCanon = $canon.length ? $canon.data('follow-slug') + $slug.val() : '';
        var slugAuto = $slug.length && !$slug.is('[data-locked]') && follows($slug, lastSlug);
        var seoAuto = follows($seo, lastTitle);
        var canonAuto = follows($canon, lastCanon);

        $slug.on('input', function () { slugAuto = false; });
        $seo.on('input', function () { seoAuto = $seo.val() === ''; });
        $canon.on('input', function () { canonAuto = $canon.val() === ''; });
        $slug.on('blur', function () { $slug.val(slugify($slug.val())).trigger('slug-changed'); });

        $title.on('input', function () {
            if (slugAuto) { $slug.val(slugify($title.val())).trigger('slug-changed'); }
            if (seoAuto) { $seo.val($title.val()).trigger('input-count'); }
        });
        $slug.on('input slug-changed', function () {
            if (canonAuto) { $canon.val($canon.data('follow-slug') + slugify($slug.val())); }
        });
    });

    $('[data-count]').each(function () {
        var $el = $(this), limit = parseInt($el.data('count'), 10);
        var $out = $('[data-counter-for="' + this.id + '"]');
        function update() {
            var n = $el.val().length;
            $out.text(n + ' / ' + limit + ' recommended characters').toggleClass('text-warning', n > limit);
        }
        $el.on('input input-count', update);
        update();
    });
});
</script>
@endpush
