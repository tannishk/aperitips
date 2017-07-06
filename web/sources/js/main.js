var app = {};

var onScroll = function(){
    var scrollPos = jQuery(document).scrollTop();
    app.anchor.nav.each(function () {
        var currLink = jQuery(this);
        var refElement = jQuery(currLink.attr('href'));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            app.anchor.nav.removeClass(app.anchor.class);
            currLink.addClass(app.anchor.class);
        }
        else{
            currLink.removeClass(app.anchor.class);
        }
    });

    if( jQuery(this).scrollTop() > app.sticky.height ) {
        app.sticky.addClass(app.sticky.class);
    } else {
        app.sticky.removeClass(app.sticky.class);
    }
};

jQuery(document).ready(function () {
    app.sticky = jQuery('header');
    app.sticky.class = 'sticky';
    app.sticky.height = jQuery('#push').height() + 50;

    app.anchor = jQuery('a[href^="#"]');
    app.anchor.class = 'active';
    app.anchor.nav = jQuery('#nav').find('a');

    jQuery(document).on('scroll', onScroll);

    app.anchor.on('click', function (e) {
        e.preventDefault();
        jQuery(document).off('scroll');

        jQuery('a').each(function () {
            jQuery(this).removeClass(app.anchor.class);
        });
        jQuery(this).addClass(app.anchor.class);

        var target = this.hash;
        var targetElement = jQuery(target);
        jQuery('html, body').stop().animate({
            'scrollTop': targetElement.offset().top+2
        }, 500, 'swing', function () {
            window.location.hash = target;
            jQuery(document).on('scroll', onScroll);
        });
    });
});
