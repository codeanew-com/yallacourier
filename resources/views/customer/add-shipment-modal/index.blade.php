<div class="customer-titlebar-action">
    <a href="#" class="purple-theme-btn" id="cd-add-shipment-btn"><span>+ Add new shipment</span></a>
</div>

<div class="cd-modal-overlay" id="cd-add-shipment-overlay">
    <div class="cd-modal-box">
        <button type="button" class="cd-modal-close" id="cd-add-shipment-close" aria-label="Close">&times;</button>

        {{-- Step 1+2: a quick 2-question wizard (where to / what) that narrows down to
             exactly one of the quote form's 4 tabs below, instead of showing all 4 at once. --}}
        <div class="cd-wizard" id="cd-wizard">
            <div class="cd-wizard-progress">
                <span class="cd-wizard-dot active" data-step="1">1</span>
                <span class="cd-wizard-progress-line"></span>
                <span class="cd-wizard-dot" data-step="2">2</span>
            </div>

            <div class="cd-wizard-step active" id="cd-wizard-step-1">
                <h3>Where are you sending?</h3>
                <div class="cd-wizard-options">
                    <button type="button" class="cd-wizard-option" data-location="uae">
                        <img src="{{ asset('front_assets/images/Parcels-icon2.svg') }}" alt="">
                        <span>Within UAE</span>
                    </button>
                    <button type="button" class="cd-wizard-option" data-location="intl">
                        <img src="{{ asset('front_assets/images/Parcels-icon1-purple.svg') }}" alt="">
                        <span>Outside UAE</span>
                    </button>
                </div>
            </div>

            <div class="cd-wizard-step" id="cd-wizard-step-2">
                <button type="button" class="cd-wizard-back" id="cd-wizard-back">&larr; Back</button>
                <h3>What are you sending?</h3>
                <div class="cd-wizard-options">
                    <button type="button" class="cd-wizard-option" data-type="parcel">
                        <img src="{{ asset('front_assets/images/ExtraLargebox.svg') }}" alt="">
                        <span>Parcel</span>
                    </button>
                    <button type="button" class="cd-wizard-option" data-type="document">
                        <img src="{{ asset('front_assets/images/icon222.svg') }}" alt="">
                        <span>Document</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Revealed once both wizard questions are answered. The quote form's tab/step
             styling (hiding inactive tabs, purple panel background, etc.) only applies
             under a "section.banner-section" ancestor on the real booking pages, so it's
             reproduced here to make that CSS work inside the modal. --}}
        <div class="cd-ship-form" id="cd-ship-form">
            <button type="button" class="cd-wizard-back" id="cd-ship-form-change">&larr; Change selection</button>
            <section class="banner-section cd-modal-banner-section">
                @include('frontend.searchcourier.index')
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        $('#cd-add-shipment-btn').on('click', function(e){
            e.preventDefault();
            $('#cd-add-shipment-overlay').addClass('open');
            $('body').css('overflow', 'hidden');
        });

        function cdCloseModal() {
            $('#cd-add-shipment-overlay').removeClass('open');
            $('body').css('overflow', '');
        }
        $('#cd-add-shipment-close, #cd-add-shipment-overlay').on('click', function(e){
            if (e.target === this) { cdCloseModal(); }
        });
        $(document).on('keydown', function(e){
            if (e.key === 'Escape') { cdCloseModal(); }
        });

        // ---- Shipment wizard: 2 quick questions, then reveal the matching quote form tab ----
        var cdShipLocation = null;

        function cdGoToStep(step) {
            $('.cd-wizard-step').removeClass('active');
            $('#cd-wizard-step-' + step).addClass('active');
            $('.cd-wizard-dot').removeClass('active').filter('[data-step="' + step + '"]').addClass('active');
        }

        function cdResetWizard() {
            cdShipLocation = null;
            $('#cd-ship-form').removeClass('open');
            $('#cd-wizard').show();
            cdGoToStep(1);
        }
        cdResetWizard();

        $('#cd-wizard-step-1 .cd-wizard-option').on('click', function(){
            cdShipLocation = $(this).data('location');
            cdGoToStep(2);
        });

        $('#cd-wizard-back').on('click', function(){
            cdGoToStep(1);
        });

        $('#cd-wizard-step-2 .cd-wizard-option').on('click', function(){
            var shipType = $(this).data('type');
            var tabIndex;
            if (shipType === 'parcel' && cdShipLocation === 'uae') { tabIndex = 1; }
            else if (shipType === 'parcel' && cdShipLocation === 'intl') { tabIndex = 2; }
            else if (shipType === 'document' && cdShipLocation === 'uae') { tabIndex = 3; }
            else { tabIndex = 4; }

            $('#cd-wizard').hide();
            $('#cd-ship-form').addClass('open');
            $('#cd-ship-form .tab-links li').eq(tabIndex - 1).trigger('click');
        });

        $('#cd-ship-form-change').on('click', cdResetWizard);
    });
</script>
@endpush
