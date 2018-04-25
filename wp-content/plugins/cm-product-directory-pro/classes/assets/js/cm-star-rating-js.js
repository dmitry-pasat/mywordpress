(function($){
    $(document).ready(function(){

        $(document).on('click', '.cmsr_delete_rate', function () {
            if (window.window.confirm('Do you really want to delete this rate?')) {
                var data = {
                    action: 'ajaxDeleteRate',
                    rate_id: $(this).data('rate_id'),
                    post_id: $(this).data('post_id')
                };
                $.post(window.cmsr_data.ajaxurl, data, function (response) {
                    $('.manage_ratings_table').html(response);
                });
            }
        });

        $(document).on('click', '.cmsr_add_rate', function(){
            var new_rate = $('input[name="new_rate"]');

            var user_id  = $('input[name="user_id"]');
            var user_ip  = $('input[name="user_ip"]');

            var data = {
                action: 'ajaxAddRate',
                new_rate: new_rate.val(),
                post_id:  $(this).data('post_id'),
                user_id:  user_id.val(),
                user_ip:  user_ip.val()
            };
            $.post(window.cmsr_data.ajaxurl, data, function(response){
                $('.manage_ratings_table').html(response);
            });
        });

    })
})(jQuery);