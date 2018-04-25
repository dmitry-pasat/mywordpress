jQuery(document).ready(function () {
    var img_hw = jQuery('.cmpdc_input_img .cmpdc_input').width()
    jQuery('.cmpdc_input_img .cmpdc_preview').width(img_hw);
    jQuery('.cmpdc_input_img .cmpdc_preview').height(img_hw);
    checkVirtualAddress();

    jQuery('#form_address').change(function () {
        google_map_initialize();
    });
    jQuery('#form_cityTown').change(function () {
        google_map_initialize();
    });
    jQuery('#form_country').change(function () {
        google_map_initialize();
    });
    jQuery('#form_postalcode').change(function () {
        google_map_initialize();
    });
    jQuery('#form_add_google_map').change(function () {

        if (!jQuery('#form_add_google_map').attr('checked')) {
            jQuery('#cmpdc-map-canvas').hide("slow");
            return;
        } else {
            jQuery('#cmpdc-map-canvas').show();
            google_map_initialize();
        }
    });

    jQuery( '#form_category' ).change( function()
    {
        var count;
        count = jQuery( '#form_category option:selected' ).length;
        if ( count > $cmpdc.cat_limit )
        {
            jQuery( '#form_category' ).removeAttr( 'selected' );
            alert( 'Maximum number of categories is ' + cmpdc.cat_limit + '.' );
        }
    });
    jQuery( '#form_pricingmodel' ).change( function()
    {
        var count;
        count = jQuery( '#form_pricingmodel option:selected' ).length;
        if ( count > $cmpdc.cat_limit )
        {
            jQuery( '#form_pricingmodel' ).removeAttr( 'selected' );
            alert( 'Maximum number of categories is ' + cmpdc.cat_limit + '.' );
        }
    });
    jQuery( '#form_languagesupport' ).change( function()
    {
        var count;
        count = jQuery( '#form_languagesupport option:selected' ).length;
        if ( count > $cmpdc.cat_limit )
        {
            jQuery( '#form_languagesupport' ).removeAttr( 'selected' );
            alert( 'Maximum number of categories is ' + cmpdc.cat_limit + '.' );
        }
    });
    jQuery( '#form_targetaudience' ).change( function()
    {
        var count;
        count = jQuery( '#form_targetaudience option:selected' ).length;
        if ( count > $cmpdc.cat_limit )
        {
            jQuery( '#form_targetaudience' ).removeAttr( 'selected' );
            alert( 'Maximum number of categories is ' + cmpdc.cat_limit + '.' );
        }
    });
    jQuery('#form_virtual_address').change(function ()
    {
        checkVirtualAddress();
    });

    function checkVirtualAddress()
    {
        if (jQuery('#form_virtual_address').is(':checked'))
        {
            jQuery("#form_address").prop('disabled', true).parent().hide("slow");
            jQuery("#form_cityTown").prop('disabled', true).parent().hide("slow");
            jQuery("#form_stateCounty").prop('disabled', true).parent().hide("slow");
            jQuery("#form_postalcode").prop('disabled', true).parent().hide("slow");
            jQuery("#form_region").prop('disabled', true).parent().hide("slow");
            jQuery("#form_country").prop('disabled', true).parent().hide("slow");
            jQuery("#form_add_google_map").prop('disabled', true).parent().hide("slow");
            jQuery("#cmpdc-map-canvas").hide("slow");
        }
        else
        {
            jQuery("#form_address").prop('disabled', false).parent().show("slow");
            jQuery("#form_cityTown").prop('disabled', false).parent().show("slow");
            jQuery("#form_stateCounty").prop('disabled', false).parent().show("slow");
            jQuery("#form_postalcode").prop('disabled', false).parent().show("slow");
            jQuery("#form_region").prop('disabled', false).parent().show("slow");
            jQuery("#form_country").prop('disabled', false).parent().show("slow");
            jQuery("#form_add_google_map").prop('disabled', false).parent().show("slow");
            if (jQuery("#form_add_google_map").is(':checked'))
            {
                jQuery("#cmpdc-map-canvas").show();
            }
        }
    }
});

function google_map_initialize() {
    var mapCanvas = document.getElementById('cmpdc-map-canvas');
    if (mapCanvas === undefined) {
        return;
    }
    if (!jQuery('#form_add_google_map').attr('checked')) {
        return;
    }
    var width = mapCanvas.offsetWidth - 50 + "px";
    mapCanvas.style.height = width;


    var street_nr = jQuery('#form_address').val();
    var city = jQuery('#form_cityTown').val();
    var country = jQuery('#form_country').val();
    var postalcode = jQuery('#form_postalcode').val();
    var title = jQuery('#communityProduct_title').val();
    if (street_nr === undefined) {
        street_nr = ''
    }
    if (city === undefined) {
        city = ''
    }
    if (country === undefined) {
        country = ''
    }
    if (postalcode === undefined) {
        postalcode = '';
    }
    if (title === undefined) {
        title = ''
    }

    var address = street_nr + ' ' + city + ' ' + country + ' ' + postalcode;


    if (mapCanvas !== undefined) {
        /* first check if user has added a GPS co-ordinate */

        var geocoder = new google.maps.Geocoder();

        var myLatLng = geocoder.geocode({'address': address}, function (results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                wpgm_gps = String(results[0].geometry.location);
                var latlng1 = wpgm_gps.replace("(", "");
                var latlng2 = latlng1.replace(")", "");
                var latlngStr = latlng2.split(",", 2);
                wpgm_lat = parseFloat(latlngStr[0]);
                wpgm_lng = parseFloat(latlngStr[1]);
                var myLatLng = new google.maps.LatLng(wpgm_lat, wpgm_lng);
                var mapOptions = {
                    center: myLatLng, zoom: 14, mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: title
                });
            } else {
//                document.getElementById('cmpdc-map-canvas').style.display = "none";
                console.log("Geocode was not successful for the following reason: " + status);
            }
        });

    }
}
google.maps.event.addDomListener(window, 'load', google_map_initialize);

/* zachowanie map */
jQuery(document).ready(function () {
    var space = jQuery('#with_map').width() - jQuery('.cmpdc_settings_container_inner').width();
    var d = 20;
    //alert(jQuery('#with_map').width() +" - "+jQuery('.cmpdc_settings_container_inner').width() +" = "+space);

    if (space < 320) {
        //alert('a '+space);
        jQuery('.cmpdc-map').css('width', jQuery('#with_map').innerWidth() - d);
        jQuery('.cmpdc-map').css('height', '320px');
    } else {
        //alert('b '+space);
        jQuery('.cmpdc-map').css('width', space - d);
    }

    window.addEventListener("resize", resizewindow);
    function resizewindow() {
        var space = jQuery('#with_map').width() - jQuery('.cmpdc_settings_container_inner').width();
        //alert(jQuery('#with_map').width() +" - "+jQuery('.cmpdc_settings_container_inner').width() +" = "+space);

        if (space < 320) {
            //alert('a '+space);
            jQuery('.cmpdc-map').css('width', jQuery('#with_map').innerWidth() - d);
            jQuery('.cmpdc-map').css('height', '320px');
        } else {
            //alert('b '+space);
            jQuery('.cmpdc-map').css('width', space - d);
        }
    }

});