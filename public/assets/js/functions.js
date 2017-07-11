(function($){
    $.fn.progressFlightTimed = function(seconds){

        var _self = this,
            _speed = seconds * 1000;

        _self.find('.progress-bar').animate(
            {width:'100%'},
            {
                duration: _speed,
                /*step: function(now, fx) {
                },*/
                /*complete: function() {
                }*/
            }
        );

        if (_self.find('.progress-agents li')) {
            var _imglist = _self.find('.progress-agents li'),
                _delay = 200,
                _step = 500;
            _step = _speed / _imglist.length;

            _imglist.each(function(){
                $(this).delay(_delay).fadeIn();
                _delay = _delay + _step;
            })
        }

    };
})(jQuery);

IsNotIPhone = function () {
    if (navigator.userAgent.match(/iPhone|iPad|iPod/i) != null) {
        //console.log("its Iphone");
        return false;
    } else {
        //console.log("its not Iphone");
        return true;
    }
}

function formatPrice(n, lang, sep) {
    var sRegExp = new RegExp('(-?[0-9]+)([0-9]{3})'), sValue = n + '';
    if (lang == 'AR' || lang == 'EN') {
        sep = ',';
    }
    if (sep === undefined) { sep = ' '; }
    while (sRegExp.test(sValue)) {
        sValue = sValue.replace(sRegExp, '$1' + sep + '$2');
    }

    return sValue;
}

function timeStringPadded(time) {
    if (time < 10) {
        time = "0" + time.toString();
    }

    return time.toString();
}

function formatMinuteTime(min) {
    var hh = Math.floor(min / 60);
    var mm = min % 60;

    return timeStringPadded(hh) + ':' + timeStringPadded(mm);
}