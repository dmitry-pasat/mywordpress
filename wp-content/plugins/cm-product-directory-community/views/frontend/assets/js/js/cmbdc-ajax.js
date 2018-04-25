jQuery(document).ready(function ()
{
    jQuery('#cmpdc_bemail_contact_submit').on('click', function (event)
    {
        event.preventDefault();
        jQuery('#send_email_login').show();
        var fd = new FormData();
        var data = jQuery('#bemail_contact').val(); // for multiple files
        var post_id = jQuery('#bemail_contact_post_id').val(); // for multiple files
        if (data != 'undefined')
        {
            fd.append("form_send_email_login", data);
            fd.append("form_send_post_id", post_id);
            fd.append("action", 'cmpdc_ajax');
            if (typeof (cmpdc_data) != 'undefined')
            {
                jQuery.ajax({
                    url: cmpdc_data['ajaxurl'],
                    data: fd,
                    action: 'cmpdc_ajax',
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (response)
                    {
                        response = jQuery.parseJSON(response);
                        jQuery('#communityProduct_msg').html('<div class="alert alert-' + response.status + '">' + response.msg + '</div>');
                        jQuery('#communityProduct_msg').show();

                        if (response.status == 'success')
                        {
                            // code...
                        }

                        if (response.status == 'warning')
                        {
                            // code...
                        }
                        jQuery(location).attr('href', "#mtmsg");
                        return true;
                    }
                });
            }
            return false;
        }
    });
});