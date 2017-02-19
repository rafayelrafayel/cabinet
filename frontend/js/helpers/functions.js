jQuery(function ($) {
    closePopup();
    // injectCounterClock()






});






function getParameterByName(name, url) {
    if (!url)
        url = window.location.href;
    url = url.toLowerCase(); // This is just to avoid case sensitiveness  
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getCurrentLang($translate) {
    var lang = getParameterByName('lang');
    if (null === lang) {
        $translate.use('am');
    } else {
        $translate.use(lang);
    }
}
function getCurrentLangCode() {
    var lang = getParameterByName('lang');
    if (null === lang) {
        return 'am';
    } else {
        return lang;
    }
}
String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function date2days(from, to) {
    var from = from || new Date(),
            oneDay = 24 * 60 * 60 * 1000;
    return Math.round(Math.abs((to.getTime() - from.getTime()) / (oneDay)));
}

function callLoading(show) {
    if (show) {

    } else {

    }
}


function popupOpen(message) {
   
    // console.log(message);return false;
    $('.cabinet_popup_content').html(message);
    $('.cabinet_popup').addClass('open');
}
function popupClose() {
    $('.cabinet_popup_content').html('');
    
    $('.cabinet_popup').removeClass('open');
   
}
function closePopup() {
    $(document).on('click', '.cabinet_popup_close', function () {
        popupClose()
    })
    $(document).on('click', '.cabinet_popup_close__', function () {
        popupClose()
    })
    
}

var scrolled = 0;
function scrollByClick(go) {
    $(".page_text_frame").stop(true, true);
    var max_height = $('.text_inner').height();
    var step = $(".page_text_frame").height() - 20;
    if (go > 0) {
        $('.page_text_up').show();
    } else {
        $('.page_text_down').show();
    }
    scrolled += go * step;
    if (scrolled <= 0) {
        scrolled = 0;
        $('.page_text_up').hide();
    }
    if (scrolled >= max_height - step) {
        scrolled = max_height - step;
        $('.page_text_down').hide();
    }
    $(".page_text_frame").animate({
        scrollTop: scrolled
    });
}
function checkScroll() {
    setTimeout(function () {
        if ($('.page_text_frame').height() > $('.text_inner').height()) {
            $('.page_text_up , .page_text_down').hide();
        } else {
            $('.page_text_up').hide();
        }
    }, 100);

}


function injectCounterClock() {
    var clock = new FlipClock($('.my-clock'), 30, {
        clockFace: 'Counter',
        countdown: true
    });

    setTimeout(function () {
        setInterval(function () {
            clock.decrement();
        }, 1000);
    });

    setTimeout(function () {
        clock.reset();

    }, 10000);
}
