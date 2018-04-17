jQuery(document).ready(function($) {    

jQuery('#dish').autoComplete({
    source: function(name, response) {
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'wp-admin/admin-ajax.php',
            data: 'action=get_listing_names&name='+name,
            success: function(data) {
                response(data);
            }
        });
    }
});

});