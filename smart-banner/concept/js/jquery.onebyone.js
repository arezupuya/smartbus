(function (_0x12a3x1) {
    var _0x12a3x2 = ['fadeIn'];
    var _0x12a3x3 = _0x12a3x2['length'];
    _0x12a3x1['fn']['oneByOne'] = function (_0x12a3x4) {
        var _0x12a3x5 = {
            className: 'oneByOne',
            sliderClassName: 'oneByOne_item',
            easeType: 'fadeIn',
            width: 900,
            height: 350,
            delay: 500,
            tolerance: 0.25,
            enableDrag: false,
            showArrow: true,
            showButton: true,
            slideShow: true,
            slideShowDelay: 3000
        };
        if (_0x12a3x4) {
            _0x12a3x1['extend'](_0x12a3x5, _0x12a3x4);
        };
        var _0x12a3x6;
        var _0x12a3x7;
        var _0x12a3x8 = -1;
        var _0x12a3x9 = _0x12a3x5['width'];
        var _0x12a3xa = _0x12a3x5['height'];
        var _0x12a3xb = 0;
        var _0x12a3xc = false;
        var _0x12a3xd = false;
        var _0x12a3xe = [];
        var _0x12a3xf;
        var _0x12a3x10 = [];
        var _0x12a3x11 = 0;
        var _0x12a3x12 = 0,
            _0x12a3x13, _0x12a3x14, _0x12a3x15;
        _0x12a3x7 = this;
        _0x12a3x7['wrap']('<div class="' + _0x12a3x5['className'] + '"/>');
        _0x12a3x6 = _0x12a3x7['parent']();
        _0x12a3x6['css']('overflow', 'hidden');
        _0x12a3x7['find']('.' + _0x12a3x5['sliderClassName'])['each'](function (_0x12a3x16) {
            _0x12a3x1(this)['hide']();
            _0x12a3x11++;
            _0x12a3x1(this)['css']('left', _0x12a3x9 * _0x12a3x16);
            _0x12a3x10[_0x12a3x16] = _0x12a3x1(this);
        });
        _0x12a3x7['bind']('touchstart', function (_0x12a3x16) {
            _0x12a3x16['preventDefault']();
            var _0x12a3x17 = _0x12a3x16['originalEvent']['touches'][0] || _0x12a3x16['originalEvent']['changedTouches'][0];
            if (!_0x12a3xc) {
                _0x12a3xc = true;
                this['mouseX'] = _0x12a3x17['pageX'];
            };
            if (_0x12a3x14) {
                _0x12a3x14['fadeIn']();
            };
            if (_0x12a3x15) {
                _0x12a3x15['fadeIn']();
            };
            return false;
        });
        _0x12a3x7['bind']('touchmove', function (_0x12a3x16) {
            _0x12a3x16['preventDefault']();
            var _0x12a3x17 = _0x12a3x16['originalEvent']['touches'][0] || _0x12a3x16['originalEvent']['changedTouches'][0];
            if (_0x12a3xc) {
                _0x12a3xb = _0x12a3x17['pageX'] - this['mouseX'];
                _0x12a3x7['css']('left', -_0x12a3x8 * _0x12a3x9 + _0x12a3xb);
                if (_0x12a3x5['slideShow']) {
                    _0x12a3x1f();
                };
            };
            return false;
        });
        _0x12a3x7['bind']('touchend', function (_0x12a3x17) {
            var _0x12a3x16 = _0x12a3x8;
            _0x12a3x17['preventDefault']();
            var _0x12a3x18 = _0x12a3x17['originalEvent']['touches'][0] || _0x12a3x17['originalEvent']['changedTouches'][0];
            _0x12a3xc = false;
            if (!_0x12a3xb) {
                return false;
            };
            var _0x12a3x19 = parseInt(_0x12a3x5['width']);
            var _0x12a3x1a = _0x12a3x19 / 2;
            if (-_0x12a3xb > _0x12a3x1a - _0x12a3x19 * _0x12a3x5['tolerance']) {
                _0x12a3x16++;
                _0x12a3x16 = _0x12a3x16 >= _0x12a3x11 ? _0x12a3x11 - 1 : _0x12a3x16;
                _0x12a3x1e(_0x12a3x16);
            } else {
                if (_0x12a3xb > _0x12a3x1a - _0x12a3x19 * _0x12a3x5['tolerance']) {
                    _0x12a3x16--;
                    _0x12a3x16 = _0x12a3x16 < 0 ? 0 : _0x12a3x16;
                    _0x12a3x1e(_0x12a3x16);
                } else {
                    _0x12a3x1e(_0x12a3x16);
                    if (_0x12a3x5['slideShow']) {
                        _0x12a3x20();
                    };
                };
            };
            _0x12a3xb = 0;
            if (_0x12a3x14) {
                _0x12a3x14['delay'](400)['fadeOut']();
            };
            if (_0x12a3x15) {
                _0x12a3x15['delay'](400)['fadeOut']();
            };
            return false;
        });
        if (_0x12a3x5['enableDrag']) {
            _0x12a3x7['mousedown'](function (_0x12a3x16) {
                if (!_0x12a3xc) {
                    _0x12a3xc = true;
                    this['mouseX'] = _0x12a3x16['pageX'];
                };
                return false;
            });
            _0x12a3x7['mousemove'](function (_0x12a3x16) {
                if (_0x12a3xc) {
                    _0x12a3xb = _0x12a3x16['pageX'] - this['mouseX'];
                    _0x12a3x7['css']('left', -_0x12a3x8 * _0x12a3x9 + _0x12a3xb);
                    if (_0x12a3x5['slideShow']) {
                        _0x12a3x1f();
                    };
                };
                return false;
            });
            _0x12a3x7['mouseup'](function (_0x12a3x17) {
                _0x12a3xc = false;
                var _0x12a3x16 = _0x12a3x8;
                if (!_0x12a3xb) {
                    return false;
                };
                var _0x12a3x19 = parseInt(_0x12a3x5['width']);
                var _0x12a3x1a = _0x12a3x19 / 2;
                if (-_0x12a3xb > _0x12a3x1a - _0x12a3x19 * _0x12a3x5['tolerance']) {
                    _0x12a3x16++;
                    _0x12a3x16 = _0x12a3x16 >= _0x12a3x11 ? _0x12a3x11 - 1 : _0x12a3x16;
                    _0x12a3x1e(_0x12a3x16);
                } else {
                    if (_0x12a3xb > _0x12a3x1a - _0x12a3x19 * _0x12a3x5['tolerance']) {
                        _0x12a3x16--;
                        _0x12a3x16 = _0x12a3x16 < 0 ? 0 : _0x12a3x16;
                        _0x12a3x1e(_0x12a3x16);
                    } else {
                        _0x12a3x1e(_0x12a3x16);
                        if (_0x12a3x5['slideShow']) {
                            _0x12a3x20();
                        };
                    };
                };
                _0x12a3xb = 0;
                return false;
            });
            _0x12a3x7['mouseleave'](function (_0x12a3x16) {
                _0x12a3x1(this)['mouseup']();
            });
        };
        _0x12a3x6['mouseover'](function (_0x12a3x16) {
            if (_0x12a3x14) {
                _0x12a3x14['fadeIn']();
            };
            if (_0x12a3x15) {
                _0x12a3x15['fadeIn']();
            };
        });
        _0x12a3x6['mouseleave'](function (_0x12a3x16) {
            if (_0x12a3x14) {
                _0x12a3x14['fadeOut']();
            };
            if (_0x12a3x15) {
                _0x12a3x15['fadeOut']();
            };
        });
        if (_0x12a3x5['showButton']) {
            _0x12a3x13 = _0x12a3x1('<div class="buttonArea"><div class="buttonCon"></div></div>');
            _0x12a3x6['append'](_0x12a3x13);
            _0x12a3x14 = _0x12a3x13['find']('.buttonCon');
            for (var _0x12a3x1b = 0; _0x12a3x1b < _0x12a3x11; _0x12a3x1b++) {
                _0x12a3x14['append']('<a class="theButton" rel="' + _0x12a3x1b + '">' + (_0x12a3x1b + 1) + '</a>')['css']('cursor', 'pointer');
            };
            _0x12a3x1('.buttonCon a:eq(' + _0x12a3x8 + ')', _0x12a3x13)['addClass']('active');
            _0x12a3x1('.buttonCon a', _0x12a3x13)['bind']('click', function (_0x12a3x17) {
                if (_0x12a3x1(this)['hasClass']('active')) {
                    return false;
                };
                var _0x12a3x16 = _0x12a3x1(this)['attr']('rel');
                _0x12a3x1e(_0x12a3x16);
            });
        };
        if (_0x12a3x5['showArrow']) {
            _0x12a3x15 = _0x12a3x1('<div class="arrowButton"><div class="prevArrow"></div><div class="nextArrow"></div></div>');
            _0x12a3x6['append'](_0x12a3x15);
            var _0x12a3x1c = _0x12a3x1('.nextArrow', _0x12a3x15)['bind']('click', function (_0x12a3x16) {
                _0x12a3x21();
            });
            var _0x12a3x1d = _0x12a3x1('.prevArrow', _0x12a3x15)['bind']('click', function (_0x12a3x16) {
                _0x12a3x22();
            });
        };
        if (_0x12a3x14) {
            _0x12a3x14['hide']();
        };
        if (_0x12a3x15) {
            _0x12a3x15['hide']();
        };
        _0x12a3x1e(0);
        if (_0x12a3x5['slideShow']) {
            slideShowInt = setInterval(function () {
                _0x12a3x21();
            }, _0x12a3x5['slideShowDelay']);
            _0x12a3x7['data']('interval', slideShowInt);
        };

        function _0x12a3x1e(_0x12a3x16) {
            if (_0x12a3x5['slideShow']) {
                _0x12a3x1f();
            };
            _0x12a3x7['stop'](true, true)['animate']({
                left: -_0x12a3x16 * _0x12a3x9
            }, _0x12a3x5['delay'], function () {
                if (_0x12a3x16 != _0x12a3x8) {
                    _0x12a3x12 = _0x12a3x8;
                    if (_0x12a3x10[_0x12a3x12]) {
                        if (!(_0x12a3x1['browser']['msie'] || _0x12a3x1['browser']['opera'])) {
                            _0x12a3x10[_0x12a3x12]['fadeOut']();
                        };
                        _0x12a3x1('.buttonArea a:eq(' + _0x12a3x12 + ')', _0x12a3x6)['removeClass']('active');
                    };
                    _0x12a3x1('.buttonArea a:eq(' + _0x12a3x16 + ')', _0x12a3x6)['addClass']('active');
                    if (_0x12a3x5['easeType']['toLowerCase']() != 'random') {
                        _0x12a3x10[_0x12a3x16]['show']()['children']()['each'](function (_0x12a3x19) {
                            if (_0x12a3x1(this)['hasClass'](_0x12a3x5['easeType'])) {
                                _0x12a3x1(this)['removeClass'](_0x12a3x5['easeType']);
                                _0x12a3x1(this)['hide']();
                            };
                            var _0x12a3x17 = _0x12a3x19;
                            _0x12a3x1(this)['show']()['addClass']('animate' + _0x12a3x17 + ' ' + _0x12a3x5['easeType']);
                        });
                    } else {
                        _0x12a3xf = _0x12a3x2[Math['floor'](Math['random']() * _0x12a3x3)];
                        _0x12a3xe[_0x12a3x16] = _0x12a3xf;
                        if (_0x12a3x10[_0x12a3x12]) {
                            _0x12a3x10[_0x12a3x12]['children']()['each'](function (_0x12a3x17) {
                                if (_0x12a3x1(this)['hasClass'](_0x12a3xe[_0x12a3x12])) {
                                    _0x12a3x1(this)['removeClass'](_0x12a3xe[_0x12a3x12]);
                                    _0x12a3x1(this)['hide']();
                                };
                            });
                        };
                        _0x12a3x10[_0x12a3x16]['show']()['children']()['each'](function (_0x12a3x19) {
                            var _0x12a3x17 = _0x12a3x19;
                            _0x12a3x1(this)['show']()['addClass']('animate' + _0x12a3x17 + ' ' + _0x12a3xf);
                        });
                    };
                    _0x12a3x7['delay'](_0x12a3x10[_0x12a3x16]['children']()['length'] * 200)['queue'](function () {
                        if (_0x12a3x5['slideShow']) {
                            _0x12a3x20();
                        };
                    });
                    if (_0x12a3x15) {
                        _0x12a3x15['css']('cursor', 'pointer');
                    };
                    _0x12a3x8 = _0x12a3x16;
                };
            });
        };

        function _0x12a3x1f() {
            clearInterval(_0x12a3x7['data']('interval'));
        };

        function _0x12a3x20() {
            clearInterval(_0x12a3x7['data']('interval'));
            slideShowInt = setInterval(function () {
                _0x12a3x21();
            }, _0x12a3x5['slideShowDelay']);
            _0x12a3x7['data']('interval', slideShowInt);
        };

        function _0x12a3x21() {
            var _0x12a3x16 = _0x12a3x8;
            _0x12a3x16++;
            _0x12a3x16 = _0x12a3x16 >= _0x12a3x11 ? 0 : _0x12a3x16;
            _0x12a3x1e(_0x12a3x16);
        };

        function _0x12a3x22() {
            var _0x12a3x16 = _0x12a3x8;
            _0x12a3x16--;
            _0x12a3x16 = _0x12a3x16 < 0 ? _0x12a3x11 - 1 : _0x12a3x16;
            _0x12a3x1e(_0x12a3x16);
        };
        return this;
    };
})(jQuery);