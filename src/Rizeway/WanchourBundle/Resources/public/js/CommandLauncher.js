var CommandLauncher = function(distribution_select, links) {
    links.click(function(e) {
        e.preventDefault();
        document.location = $(this).attr('href') + (distribution_select.val() == '' ? '' : '?distribution=' + distribution_select.val());
    });
};
