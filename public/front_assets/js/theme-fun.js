$(function () {
    
    $('.banner-section .tabbing-wrapper .tab-links li').click(function () {
        $('.banner-section .tabbing-wrapper .tab-links li').removeClass('active');
        $('.banner-section .tabbing-wrapper .tab-content').removeClass('active');
        $(this).addClass('active');
        var tab_id = $(this).index();
        tab_id += 1;
        $('.banner-section .tabbing-wrapper .tab-content:nth-child(' + tab_id + ')').addClass('active');

    });
    $('.banner-section .tabbing-wrapper .tab-links li:first-child').addClass('active');
    $('.banner-section .tabbing-wrapper .tab-content:first-child').addClass('active');

    	 // Footer Accordion
	if ($(window).width() < 768) {
			$(document).on('click', '.accordiandeliverynew h3', function () {
				$this = $(this);
				$this.parent().toggleClass('open');
				$thisToggelBody = $this.parent().find('.mob-acc-checkout');
				if ($this.parent().hasClass('open')) {
					$thisToggelBody.slideDown();
				} else {
					$thisToggelBody.slideUp();
				}
			});
	}

    $('.testimonialwrapper').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 500,
        pauseOnHover: false,
        vertical: false,
        verticalSwiping: false,
        verticalReverse: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                    draggable: true,
                    swipe: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    draggable: true,
                    swipe: true,
                }
            }
        ]
    });


    $('.continuosorderslider').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        pauseOnHover: false,
        vertical: false,
        verticalSwiping: false,
        verticalReverse: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    draggable: true,
                    swipe: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    draggable: true,
                    swipe: true,
                }
            }
        ]
    });

    $('.collapsible-header').click(function () {
        var content = $(this).next('.collapsible-content');
        var arrow = $(this).find('.arrow');

        content.slideToggle(300);
        arrow.toggleClass('expanded');

        if (arrow.hasClass('expanded')) {
            arrow.css('transform', 'rotate(180deg)');
        } else {
            arrow.css('transform', 'rotate(0deg)');
        }
    });



    // Faqs Accordion 
    $(".accordion__item:first-child").addClass("active");
    $(".accordion__item:first-child .accordion__title").addClass("accordion-active");
    $(".accordion__item:first-child .accordion__content").slideDown(400);
    $('.accordion__item:first-child .accordion__arrow').addClass('accordion__active');
    $(".accordion__title").on("click", function (e) {
        e.preventDefault();
        var $this = $(this);

        if (!$this.hasClass("accordion-active")) {
            $(".accordion__content").slideUp(400);
            $(".accordion__title").parent().removeClass("active");
            $(".accordion__title").removeClass("accordion-active");
            $('.accordion__arrow').removeClass('accordion__active');
        }

        $this.parent().toggleClass("active");
        $this.toggleClass("accordion-active");
        $this.next().slideToggle();
        $('.accordion__arrow', this).toggleClass('accordion__active');
    });



    // Event handler for the "Next" button
    // $("#nxt-btn").on("click", function () {
    //     // Custom validation for fields in the first tab
    //     // var isValid = validateTab1Fields();

    //     // if (!isValid) {
    //     //   // If validation fails, let the browser handle default validation
    //     //   return;
    //     // }

    //     // Switch to the next tab
    //     $("[data-toggle-fade='tgl-1']").hide();
    //     $("[data-toggle-fade='tgl-2']").show();
    // });

    // $("#prev-btn").on("click", function () {
    //     // Custom validation for fields in the first tab
    //     //   var isValid = validateTab1Fields();

    //     //   if (!isValid) {
    //     //     // If validation fails, let the browser handle default validation
    //     //     return;
    //     //   }

    //     // Switch to the next tab
    //     $("[data-toggle-fade='tgl-2']").hide();
    //     $("[data-toggle-fade='tgl-1']").show();
    // });

    // Function to validate fields in the first tab
    function validateTab1Fields() {
        var field1Value = $("#searchadd").val();
        var field2Value = $("#manualaddresscollection").val();
        var field3Value = $("#searchdeladd").val();
        var field4Value = $("#manualaddressdelivery").val();
        var field5Value = $("#collectionaddress").val();
        var field6Value = $("#valueparcel").val();
        var field7Value = $("#agreeterm").val();

        // Add your custom validation logic here
        // For example, you can check if fields are not empty
        if (field1Value == '') {

        }
        if (field1Value === "" || field2Value === "" || field3Value === "" || field4Value === "" || field5Value === "" || field6Value === "" || field7Value === "") {
            alert("Fields in the first tab are required!");
            return false;
        }

        // Additional validation logic can be added based on your requirements

        return true; // Return true if validation passes
    }



    // for modal
    modalFn()
    function modalFn() {
        // close modal
        $('body').on("click", "[close-modal]", function () {
            var modal = $(this).attr('close-modal');
            closeModal(modal)
        });
        // open modal
        $('body').on("click", "[open-modal]", function () {
            $('body').addClass('overflow-h')
            var modal = $(this).attr('open-modal');
            openModal(modal)
        });
        // *********************
        // close modals when click outside
        // *********************
        $('body').on("click", "[modal-body],[open-modal],[to-open]", function (e) {
            e.stopPropagation();
        });
        $(window).click(function (e) {
            var currentModal = $("body[opened-modal]").attr("opened-modal");
            if (currentModal) {
                closeModal(currentModal)
            }
        });
    }

    function openModal(modal) {
        $('[modal-name="' + modal + '"]').addClass('active').removeClass('out')
        $('body').addClass('overflow-hidden')
        if ($('body').attr('opened-modal') == undefined || $('body').attr('opened-modal') == '')
            $('body').attr('opened-modal', modal)
        else if ($('body').attr('opened-modal').includes(modal)) {

        } else
            $('body').attr('opened-modal', $('body').attr('opened-modal') + ',' + modal)

    }
    function closeModal(modal) {

        $('[modal-name="' + modal + '"]').removeClass('active');
        if (document.querySelector('[modal-name="' + modal + '"]').hasAttribute('has-video')) {
            $('[modal-name="' + modal + '"] [target]').html('')
        }
        $('body').removeClass('overflow-hidden')
        var openedModals = $('body').attr('opened-modal').split(',')
        openedModals = openedModals.slice(0, openedModals.length - 1)

        $('body').attr('opened-modal', openedModals.join())

    }

    var scrollToTopBtn = $('#scrollToTopBtn');

    // Show or hide the button when scrolling
    $(window).scroll(function () {
        var scrollPercent = $(window).scrollTop() / ($(document).height() - $(window).height());

        if (scrollPercent > 0.60) {
            scrollToTopBtn.fadeIn();
        } else {
            scrollToTopBtn.fadeOut();
        }
    });

    // Smooth scroll to top when button is clicked
    scrollToTopBtn.click(function () {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        return false;
    });

    // tabing

    $('.tabing-sec .main-tabing .tab-nav  ul li').click(function () {
        $('.tabing-sec .main-tabing .tab-nav  ul li').removeClass('active');
        $('.tabing-sec .main-tabing .tab-contents').removeClass('active');
        $(this).addClass('active');
        var tab_id = $(this).index();
        tab_id += 1;
        $('.tabing-sec .main-tabing .tab-contents:nth-child(' + tab_id + ')').addClass('active');

    });
    $('.tabing-sec .main-tabing .tab-nav  ul li:first-child').addClass('active');
    $('.tabing-sec .main-tabing .tab-contents:first-child').addClass('active');

    $('.form-check-input').on('change', function () {
        // Remove 'active' class from all .form-check divs
        $('.form-check').removeClass('active');

        // Add 'active' class to the parent div of the checked radio button
        if ($(this).is(':checked')) {
            $(this).closest('.form-check').addClass('active');
        }
    });

    const listItems = document.querySelectorAll('#my-list li');

    // Add click event to each list item
    listItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove active class from all items
            listItems.forEach(li => li.classList.remove('active'));

            // Add active class to the clicked item
            item.classList.add('active');

        });
    });
     
     
    
    // Home Page Banner Form Compare And Book Parcel Form
     
    function updateRemoveButtons() {
        var parcelCount = $('#parcelsForm .parcel-wrapper').length;
         console.log(parcelCount);
        if (parcelCount > 1) {
            $('.remove-parcel').show();  
        } else {
            $('.remove-parcel').hide(); 
        }
    }

    $('#bookParcelDeliveryServicesBtn').click(function() {
        var newParcel = $('#bookParcelDeliveryServices:first').clone();  
        newParcel.find('input').val(''); 
        $('#bookParcelDeliveryServices:last').after(newParcel); 
        updateRemoveButtons(); 
    });
 
    $(document).on('click', '.remove-parcel', function() {
        if ($('#parcelsForm .parcel-wrapper').length > 1) {
            $(this).closest('.parcel-wrapper').remove(); 
            updateRemoveButtons();
        }
    }); 
    updateRemoveButtons();
    
    
    // Home Page Banner Form Compare And Book Docuemnt Form
     
    function updateDDRemoveButtons() {
        var parcelCount = $('#documentDeliveryServicesForm .parcel-wrapper').length;
        // console.log(parcelCount);
        if (parcelCount > 1) {
            $('.remove-parcel').show();  
        } else {
            $('.remove-parcel').hide(); 
        }
    }

    $('#documentDeliveryServicesBtn').click(function() {
        var newParcel = $('#documentDeliveryServices:first').clone();  
        newParcel.find('input').val(''); 
        $('#documentDeliveryServices:last').after(newParcel); 
        updateDDRemoveButtons(); 
    });
 
    $(document).on('click', '.remove-parcel', function() {
        if ($('#documentDeliveryServicesForm .parcel-wrapper').length > 1) {
            $(this).closest('.parcel-wrapper').remove(); 
            updateDDRemoveButtons();
        }
    });

    updateDDRemoveButtons();
    
    // Intl Documents
    
        // Home Page Banner Form Compare And Book Docuemnt Form
     
    function updateDDRemoveButtons1() {
        var parcelCount = $('#documentDeliveryServicesForm1 .parcel-wrapper').length;
        // console.log(parcelCount);
        if (parcelCount > 1) {
            $('.remove-parcel').show();  
        } else {
            $('.remove-parcel').hide(); 
        }
    }

    $('#documentDeliveryServicesBtn1').click(function() {
        var newParcel = $('#documentDeliveryServices1:first').clone();  
        newParcel.find('input').val(''); 
        $('#documentDeliveryServices1:last').after(newParcel); 
        updateDDRemoveButtons1(); 
    });
 
    $(document).on('click', '.remove-parcel', function() {
        if ($('#documentDeliveryServicesForm1 .parcel-wrapper').length > 1) {
            $(this).closest('.parcel-wrapper').remove(); 
            updateDDRemoveButtons1();
        }
    });

    updateDDRemoveButtons1();
 
    $('#documentType').change(function() {
        if ($(this).val() === 'Custom size') {
            $('.documentDeliveryServices').show();  
            $('#documentDeliveryServicesBtn').show();
            // $(this).closest('.row.no-gutters').find('.folders-env').show();
        } else {
            $('.documentDeliveryServices').hide();  
            $('#documentDeliveryServicesBtn').hide(); 
            // $(this).closest('.row.no-gutters').find('.folders-env').hide();
        }
    });
 
    $('#documentType').trigger('change');
    
    
    $('#documentType1').change(function() {
        if ($(this).val() === 'Custom size') {
            $('.documentDeliveryServices1').show();  
            $('#documentDeliveryServicesBtn1').show(); 
            // $(this).closest('.row.no-gutters').find('.folders-env').show();
        } else {
            $('.documentDeliveryServices1').hide();  
            $('#documentDeliveryServicesBtn1').hide(); 
            // $(this).closest('.row.no-gutters').find('.folders-env').hide();
        }
    });
    
 
    $('#documentType1').trigger('change');
    
    
    // Home Page Banner Form Yalla Rapid
     
    function updateYRRemoveButtons() {
        var parcelCount = $('#yallaRapidForm .parcel-wrapper').length;
        // console.log(parcelCount);
        if (parcelCount > 1) {
            $('.remove-parcel').show();  
        } else {
            $('.remove-parcel').hide(); 
        }
    }

    $('#yallaRapidDeliveryBtn').click(function() {
        var newParcel = $('#yallaRapidDelivery:first').clone();  
        newParcel.find('input').val(''); 
        $('#yallaRapidDelivery:last').after(newParcel); 
        updateYRRemoveButtons(); 
    });
 
    $(document).on('click', '.remove-parcel', function() {
        if ($('#yallaRapidForm .parcel-wrapper').length > 1) {
            $(this).closest('.parcel-wrapper').remove(); 
            updateYRRemoveButtons();
        }
    });

    updateYRRemoveButtons();
    
    
    // Home Page Banner Form International
     
    function updateIntRemoveButtons() {
        var parcelCount = $('#internationalDelivery .parcel-wrapper').length;
        // console.log(parcelCount);
        if (parcelCount > 1) {
            $('.remove-parcel').show();  
        } else {
            $('.remove-parcel').hide(); 
        }
    }

    $('#internationaldeliveryBtn').click(function() {
        var newParcel = $('#internationalDeliveryServices:first').clone();  
        newParcel.find('input').val(''); 
        $('#internationalDeliveryServices:last').after(newParcel); 
        updateIntRemoveButtons(); 
    });
 
    $(document).on('click', '.remove-parcel', function() {
        if ($('#internationalDelivery .parcel-wrapper').length > 1) {
            $(this).closest('.parcel-wrapper').remove(); 
            updateIntRemoveButtons();
        }
    });

    updateIntRemoveButtons();
    
    
    // Parcel Size Guide Popup
    function PsOpenPopup() {
        $('.ps-pop').addClass('active');
        // $('body').addClass('overflow-hidden');
        hwClosePopup();

    }

    function PrOpenPopup() {
        $('.pr-pop').addClass('active');
        // $('body').addClass('overflow-hidden');
        hwClosePopup();

    }

    function PsClosePopup() {
        $('.ps-pop').removeClass('active');
        // $('body').removeClass('overflow-hidden');
    }
    function PrClosePopup() {
        $('.pr-pop').removeClass('active');
        // $('body').removeClass('overflow-hidden');
    }

    $('.parcel-size-guide-btn').click(function () {
        PsOpenPopup();
    });

    $('.printer-btn').click(function () {
        PrOpenPopup();
    });


    $('.ps-pop .close-btn').click(function () {
        PsClosePopup();
    });

    $('.pr-pop .close-btn').click(function () {
        PrClosePopup();
    });


    
    
    // How It Works Popup
    function hwOpenPopup() {
        $('.how-it-works-popup').addClass('active');
        // $('body').addClass('overflow-hidden');
        PsClosePopup(); 
    }

    function hwClosePopup() {
        $('.how-it-works-popup').removeClass('active');
        // $('body').removeClass('overflow-hidden');
    }

    $('.how-it-works-btn').click(function () {
        hwOpenPopup();
    });

    $('.how-it-works-popup .close-btn').click(function () {
        hwClosePopup();
    });
    
    // Prohibited Items / Restricted Items Popup
    function ProhibitedOpenPopup() {
        $('.prohibited-items-popup').addClass('active');
        // $('body').addClass('overflow-hidden');

    }

    function ProhibitedClosePopup() {
        $('.prohibited-items-popup').removeClass('active');
        // $('body').removeClass('overflow-hidden');
    }

    $('.prohibited-popup-btn').click(function () {
        ProhibitedOpenPopup();
    });

    $('.prohibited-items-popup .prohibited-close-btn').click(function () {
        ProhibitedClosePopup();
    });
    
    
    // Mobile Header
    function mobilePopup() {
        $('.mobile-navbar').addClass('active');
        $('.bg-overlay').addClass('active');
        // $('body').addClass('overflow-hidden');

    }

    function mobileClosePopup() {
        $('.mobile-navbar').removeClass('active');
        $('.bg-overlay').removeClass('active');
        // $('body').removeClass('overflow-hidden');
    }

    $('.mobile-navbar-btn').click(function () {
        mobilePopup();
    });

    $('.mobile-navbar .close-btn').click(function () {
        mobileClosePopup();
    });
    $('.bg-overlay').click(function () {
        mobileClosePopup();
    });
    
    
     // How Shipping Rates Calculated Popup
    function hsrcOpenPopup() {
        $('.how-shipping-rates-calculated-popup').addClass('active');
        // $('body').addClass('overflow-hidden'); 
    }

    function hsrcClosePopup() {
        $('.how-shipping-rates-calculated-popup').removeClass('active');
        // $('body').removeClass('overflow-hidden');
    }

    $('.how-shipping-rates-calculated-button').click(function () {
        hsrcOpenPopup();
    });

    $('.how-shipping-rates-calculated-popup  .close-btn').click(function () {
        hsrcClosePopup();
    });
    
    
    
function reorderFields(containerId) {
  const container = $(`#${containerId} .row.no-gutters`);
  const quantityField = container.find("select[name='shipment_qty[]']").closest('div[class^="col-"]');
  const weightField = container.find("input[name='shipment_weight[]']").closest('div[class^="col-"]');
  const lengthField = container.find("input[name='shipment_length[]']").closest('div[class^="col-"]');
  const widthField = container.find("input[name='shipment_width[]']").closest('div[class^="col-"]');
  const heightField = container.find("input[name='shipment_height[]']").closest('div[class^="col-"]');

  // Detect screen size
  const isMobile = $(window).width() <= 767;

  // Check and update only if necessary
  if (isMobile) {
    if (!quantityField.hasClass('col-6')) {
      quantityField.removeClass('col-4').addClass('col-6');
      weightField.removeClass('col-4').addClass('col-6');
      lengthField.removeClass('col-6').addClass('col-4');
      widthField.removeClass('col-6').addClass('col-4');

      container.append(quantityField, weightField, lengthField, widthField, heightField);
    }
  } else {
    if (!lengthField.hasClass('col-6')) {
      quantityField.removeClass('col-6').addClass('col-4');
      weightField.removeClass('col-6').addClass('col-4');
      lengthField.removeClass('col-4').addClass('col-6');
      widthField.removeClass('col-4').addClass('col-6');

      container.append(lengthField, widthField, heightField, quantityField, weightField);
    }
  }
}

// Initial call
reorderFields('bookParcelDeliveryServices');
reorderFields('internationalDeliveryServices');
reorderFields('documentDeliveryServices');
reorderFields('documentDeliveryServices1');

// Search Page Tabbing
$('.searchresults .search-tabbing-main .search-tab-links li').click(function () {
        $('.searchresults .search-tabbing-main .search-tab-links li').removeClass('active');
        $('.searchresults .search-tabbing-main .search-tabbing-content .search-tab-content').removeClass('active');
        $(this).addClass('active');
        var tab_id = $(this).index();
        tab_id += 1;
        $('.searchresults .search-tabbing-main .search-tabbing-content .search-tab-content:nth-child(' + tab_id + ')').addClass('active');

    });
    $('.searchresults .search-tabbing-main .search-tab-links li:first-child').addClass('active');
    $('.searchresults .search-tabbing-main .search-tabbing-content .search-tab-content:first-child').addClass('active');

    
    
});


