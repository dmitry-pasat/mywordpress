
function google_map_initialize() {
    var mapCanvas = document.getElementById('cmpd-map-canvas');
    var cmpd_image = document.getElementById('cmpd_image');
    // var cmpd_product_images_list = document.getElementById('cmpd_product_images_container');
    if (mapCanvas === undefined || mapCanvas === null) {
        return;
    }
    
    //cmpd_product_images_list.width = width + "px";*/

    var current = window["cmpd_map_settings"];
    if (current === undefined) {
        return;
    }

    var address = current.address;
    var title = current.title;
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
                document.getElementById('cmpd-map-canvas').style.display = "none";
                //alert("Geocode was not successful for the following reason: " + status);
            }
        });

    }
}
google.maps.event.addDomListener(window, 'load', google_map_initialize);
