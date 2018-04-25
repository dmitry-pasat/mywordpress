jQuery( document ).ready( function ($) {

    var target = $('[data-cmpdid]'),
        url = window.location.href,
        id = target.data("cmpdid"),
        key = target.data("cmpdkey");

    if( url.indexOf('?') >= 0 ) {
        url += '&';
    } else {
        url += '?';
    }
    url += 'cmpdid=' + id;
    url += '&cmpdkey=' + key;
    target.prop( 'href', url );
});