var RizewayAjaxLink = function(link, target) {
    $(link).click(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(link).attr('href'),
            success: function(data) {
                $(target).html(data);
            }
        })
    }); 
};
