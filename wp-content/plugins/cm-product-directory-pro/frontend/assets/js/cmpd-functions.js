
(function ($) {
    $(document).ready(function ($) {
        (function () {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
        (function (d, s, id) {
            var fbAsyncInitCMA = function () {
                // Don't init the FB as it needs API_ID just parse the likebox
                FB.XFBML.parse();
            };
            if (typeof (window.fbAsyncInit) == 'function') {
                var fbAsyncInitOld = window.fbAsyncInit;
                window.fbAsyncInit = function () {
                    fbAsyncInitOld();
                    fbAsyncInitCMA();
                };
            } else {
                window.fbAsyncInit = fbAsyncInitCMA;
            }

            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    });
})(jQuery);

function google_map_initialize() {
    var mapCanvas = document.getElementById('cmpd-map-canvas');
    var width =  mapCanvas.offsetWidth-50 +"px";
    mapCanvas.style.height = width;
    var current = window["cmpd_map_settings"];
    if (current === undefined) {
        return;
    }

    var address = current.address;
    var title = current.title;
    if (mapCanvas !== undefined) {
        /* first check if user has added a GPS co-ordinate */
        checker = address.split(",");
        var wpgm_lat = "";
        var wpgm_lng = "";
        wpgm_lat = checker[0];
        wpgm_lng = checker[1];
        checker1 = parseFloat(checker[0]);
        checker2 = parseFloat(checker[1]);
        if ((wpgm_lat.match(/[a-zA-Z]/g) === null && wpgm_lng.match(/[a-zA-Z]/g) === null) && checker.length === 2 && (checker1 != NaN && (checker1 <= 90 || checker1 >= -90)) && (checker2 != NaN && (checker2 <= 90 || checker2 >= -90))) {
            var myLatLng = new google.maps.LatLng(wpgm_lat, wpgm_lng);
        } else {
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
                        center: myLatLng,
                        zoom: 14,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }
                    var map = new google.maps.Map(mapCanvas, mapOptions);
                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                        title: title
                    });
                } else {
                    //alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
    }
}
google.maps.event.addDomListener(window, 'load', google_map_initialize);
