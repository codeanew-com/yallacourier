<div class="form-wrapper">
	
	
							
<iframe src="https://yallashipping.com/iframe-page/" style="border:none" height="800" width="100%" scrolling="no" title="Iframe Example"></iframe>




</div>
@push('scripts')
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocompletes">
    </script>
    <script>

        // Initialize Google Places Autocomplete for the UAE field
        function initAutocompleteUAE() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        let cc=component.long_name
                        $("#sender_state > option").each(function() {
                            if($(this).text()==cc)
                            {
                                city = cc;
                            }
                        })
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        if ($(input).attr('name') === 'shipment_from_1') {
                            
                            if($("#sender_state").find(":selected").val()!=city)
                            {
                                $("#sender_state > option").each(function() {
                                    if($(this).text()==city)
                                    {
                                        $(this).attr("selected","selected");
                                    }
                                }); 
                            }
                        }
                        if ($(input).attr('name') === 'shipment_to_1') {
                            
                            if($("#reciever_state").find(":selected").val()!=city)
                            {
                                $("#reciever_state > option").each(function() {
                                    if($(this).text()==city)
                                    {
                                        $(this).attr("selected","selected");
                                    }
                                }); 
                            }
                        }
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }
        
        // Initialize Google Places Autocomplete for the UAE field
        function initAutocompleteUAEDocument() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete1');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        let cc=component.long_name
                        $("#sender_state2 > option").each(function() {
                            if($(this).text()==cc)
                            {
                                city = cc;
                            }
                        })
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        if ($(input).attr('name') === 'shipment_from_1') {
                            
                            if($("#sender_state2").find(":selected").val()!=city)
                            {
                                $("#sender_state2 > option").each(function() {
                                    if($(this).text()==city)
                                    {
                                        $(this).attr("selected","selected");
                                    }
                                }); 
                            }
                        }
                        if ($(input).attr('name') === 'shipment_to_1') {
                            
                            if($("#reciever_state2").find(":selected").val()!=city)
                            {
                                $("#reciever_state2 > option").each(function() {
                                    if($(this).text()==city)
                                    {
                                        $(this).attr("selected","selected");
                                    }
                                }); 
                            }
                        }
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }
        
        // Initialize Google Places Autocomplete for the UAE Intl field
        function initAutocompleteUAEintl() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete_intl_uae');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        if (component.types.includes('locality')) {
                            city = component.long_name;
                            break;
                        }
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) 
                    {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_from_city").val(city);
                    } 
                    else 
                    {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }
        
        // Initialize Google Places Autocomplete for the UAE Intl field
        function initAutocompleteUAEintl2() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete_intl_uae2');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        if (component.types.includes('locality')) {
                            city = component.long_name;
                            break;
                        }
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) 
                    {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_from_city1").val(city);
                    } 
                    else 
                    {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }

        // $(document).ready(function() { 
        //     $("#shipment_to_country").on("change", function () {
        //         let code = $(this).val();
        //         $(".autocomplete_intl").val("");
        //         initAutocompleteIntl(code);
                
        //     });
        // });
        
        //  $(document).ready(function() { 
        //     $("#shipment_to_country2").on("change", function () {
        //         let code = $(this).val();
        //         $(".autocomplete_intl2").val("");
        //         initAutocompleteIntl1(code);
                
        //     });
        // });
        
        

        // Initialize Google Places Autocomplete for the International field
        function initAutocompleteIntl(countryCode = "BH") {

            console.log("Country Code", countryCode);

            // const input = document.getElementById('autocomplete_intl');
            const inputs = document.getElementsByClassName('autocomplete_intl');
            for (let i = 0; i < inputs.length; i++) {
                
                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: countryCode } // Restrict to International
                };
                
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                        const place = autocomplete.getPlace();
                        let city = '';
                        
                        for (const component of place.address_components) {
                            if (component.types.includes('locality')) {
                                city = component.long_name;
                                break;
                        }
                    }


                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_to_city").val(city);
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
                
                 $(document).on('change','#shipment_to_country',function() {
                        const options = {
                            types: ['geocode', 'establishment'],
                            componentRestrictions: { country: $(this).find(":selected").val() } // Restrict to International
                        };
                        autocomplete.setOptions(options);
                  });
            }
        }
        
        // Initialize Google Places Autocomplete for the International field
        function initAutocompleteIntl1(countryCode = "BH") {

            console.log("Country Code", countryCode);

            // const input = document.getElementById('autocomplete_intl');
            const inputs = document.getElementsByClassName('autocomplete_intl2');
            for (let i = 0; i < inputs.length; i++) {
                
                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: countryCode } // Restrict to International
                };
                
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                        const place = autocomplete.getPlace();
                        let city = '';
                        
                        for (const component of place.address_components) {
                            if (component.types.includes('locality')) {
                                city = component.long_name;
                                break;
                        }
                    }


                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_to_city1").val(city);
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
                
                
                  $(document).on('change','#shipment_to_country2',function() {
                        const options = {
                            types: ['geocode', 'establishment'],
                            componentRestrictions: { country: $(this).find(":selected").val() } // Restrict to International
                        };
                        autocomplete.setOptions(options);
                  });
            }
        }

        // Initialize both autocompletes
        function initAutocompletes() {
            initAutocompleteUAE();
            initAutocompleteUAEDocument();
            initAutocompleteIntl();
            initAutocompleteUAEintl();
            initAutocompleteIntl1();
            initAutocompleteUAEintl2();
        }

    </script>
@endpush