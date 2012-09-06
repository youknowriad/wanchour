var RizewayLoader = function() {
    
    var _loading;
    
    return {
        
        initLoading: function(loadingDiv) {
            _loading = loadingDiv;
        },
        
        addLoading: function(target) {
            if (_loading !== undefined) {
                if ($(target)[0].nodeName.toLowerCase() !== 'div')
                {
                    target = $(target).parents('div:first');
                }
                
                if ($('.loading', target).length == 0)
                {
                    $(target).css('position', 'relative');
                    $(target).append(_loading.html());

                    $('.loading', target).height(target.height()).css('opacity', '0.6').css('z-index', '100');
                    var margin = target.height() / 2 - $('.loading img', target).height()/2;
                    $('.loading img', target).css('margin-top', margin)

                }
            }
        },
        
        removeLoading: function(target) {
            if ($(target)[0].nodeName.toLowerCase() !== 'div')
            {
                target = $(target).parents('div:first');
            }
            $('.loading', target).remove();
        }
    }
    
}();
