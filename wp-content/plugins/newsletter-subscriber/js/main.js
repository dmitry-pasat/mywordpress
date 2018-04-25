jQuery(document).ready(function($){
    $('#subscriber-form').submit(function(e){
        e.preventDefault();

       //Serialize Form
        var subscriberData = $('#subscriber-form').serialize();

        //Submit Form
        $.ajax({
            type: 'post',
            url: $('#subscriber-form').attr('action'),
            data: subscriberData
        }).done(function(response){
            //If success
            $('#form-msg').removeClass('error');
            $('#form-msg').addClass('success');

            //Set message text
            $('#form-msg').text(response);

            //Clear field
            $('#name').val('');
            $('#email').val('');
        }).fail(function(data){
            //If error
            $('#form-msg').removeClass('success');
            $('#form-msg').addClass('error');

            if(data.responseText !== ''){
                //Set message text
                $('#form-msg').text(data.responseText);
            } else {
                $('#form-msg').text('Message was not sent');
            }
        });
    });
})