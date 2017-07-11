var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

var FLIGHT = function() {
    var searching = false;

    // start startDate & endDate dateRangePicker
    var datePicker = function() {
        var _hoveringTooltip = true;
        if (isMobile.iOS()) {
            _hoveringTooltip = false;
        }

        //round trip
        var $round_trip = $('#round-trip .gr-date'),
            $date_start = $round_trip.find('.date-start'),
            $date_end = $round_trip.find('.date-end'),
            $mouse_in_end = false,
            $opened_before = false,
            $date_format = 'YYYY-MM-DD';
        $date_end.parent().mouseenter(function () {
            $mouse_in_end = true
        }).mouseleave(function () {
            $mouse_in_end = false;
        });

        $round_trip.dateRangePicker({
            separator: ' to ',
            format: $date_format,
            showTopbar: false,
            showShortcuts: false,
            autoClose: false,
            stickyMonths: true,
            singleDate: false,
            duration: 0,
            responsive: 767,
            hoveringTooltip: _hoveringTooltip,
            language: 'sv',
            getValue: function () {
                if ($date_start.val() && $date_end.val())
                    return $date_start.val() + ' to ' + $date_end.val();
                else
                    return '';
            },
            setValue: function (s, s1, s2) {
                $date_start.val(s1);
                $date_end.val(s2);
            },
            beforeShowDay: function (t) {
                var valid = true,
                    _class = '', _tooltip = '',
                    current_date = new Date();
                current_date.setDate(current_date.getDate() - 1);
                if (current_date > t) {
                    valid = false
                }

                _tooltip = valid ? '' : 'weekends are disabled';

                return [valid, _class, _tooltip];
            }
        }).bind('datepicker-first-date-selected', function (event, obj) {
            $date_end.parent().addClass('active');
            $date_start.parent().removeClass('active');
        }).bind('datepicker-open', function () {
            $('.passengers').removeClass('active');
            if ($mouse_in_end == false) {
                $date_end.parent().removeClass('active');
                $date_start.parent().addClass('active');
            } else {
                $date_end.parent().addClass('active');
            }
        }).bind('datepicker-closed', function () {
            $date_start.parent().removeClass('active');
            $date_end.parent().removeClass('active');
        }).bind('datepicker-opened', function () {
            /* This event will be triggered after date range picker open animation */
            if (($mouse_in_end == true) && ($opened_before == false)) {
                var date = moment($date_start.val(), $date_format).toDate().getTime();
                $("div[time='" + date + "']:visible").trigger('click')
            }

            hideSuggestionBlock();
        });

        // one way
        var $one_way = $('#one-way'),
            $date_start_one = $one_way.find('.date-start');
        var dateObjOneWay = {
            format: $date_format,
            nextText: '<i class="fa fa-caret-right"></i>',
            showShortcuts: false,
            singleMonth: true,
            autoClose: true,
            singleDate: true,
            stickyMonths: true,
            responsive: 767,
            hoveringTooltip: _hoveringTooltip,
            language: 'sv',
            getValue: function () {
                if ($date_start_one.val())
                    return $date_start_one.val();
                else
                    return '';
            },
            setValue: function (s, s1, s2) {
                $date_start_one.val(s1);
            },
            beforeShowDay: function (t) {
                var valid = true,
                    _class = '', _tooltip = '',
                    current_date = new Date();
                current_date.setDate(current_date.getDate() - 1);
                if (current_date > t) {
                    valid = false
                }

                _tooltip = valid ? '' : 'these days are disabled';

                return [valid, _class, _tooltip];
            }
        };
        $date_start_one.dateRangePicker(dateObjOneWay)
            .bind('datepicker-open', function () {
                hideSuggestionBlock();

                $('.passengers').removeClass('active');
                $date_start_one.parent().addClass('active');
            }).bind('datepicker-closed', function () {
            $date_start_one.parent().removeClass('active');
        });
    };
    // end start & end dateRangePicker

    // start from & to autocomplete
    var autoComplete = function() {
        var cache = {};
        //var serviceUrl = '/flights/GetAirportByPrefix';
        var serviceUrl = '/Service/GetAirportByPrefix';
        var $suggestion_city = $('#suggestion-cities');

        // round trip
        var $departure_city = $("#departure_city");
        var $destination_city = $("#destination_city");
        $departure_city.autocomplete({
            autoFocus: IsNotIPhone(),
            minLength: 2,
            delay: 0,
            selectFirst: true,
            position: {
                my: "left top+17",
                of: $departure_city.id,
                collision: "none"
            },
            open: function (event, ui) {
                if (!IsNotIPhone()) {
                    $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
                }

                hideSuggestionBlock($(this));
                $departure_city.parent().addClass('active');
            },
            close: function(event, ui) {
                $departure_city.parent().removeClass('active');
            },
            source: function (request, response) {
                var convertDataToAutoComplete = function (data) {
                    var result = [];
                    $.each(data, function (i, element) {
                        result.push({ label: element.UiDisplayName, value: element.DisplayName, data: element, CityNameEn: element.CityNameEN });
                    });
                    return result;
                };

                var newValue = $("#departure_city").val();
                if (typeof cache[newValue] === "object") {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                    response($.grep(cache[newValue], function (value) {
                        return matcher.test(value.value) || matcher.test(value.CityNameEn);
                    }));

                    return;
                }
                var lastXhr = $.getJSON(serviceUrl, { term: newValue }, function (data, status, xhr) {

                }).done(function (data) {
                    if (data !== null) {
                        var array = convertDataToAutoComplete(data);
                        cache[newValue] = array;

                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                        response($.grep(array, function (value) {
                            return matcher.test(value.value) || matcher.test(value.CityNameEn);
                        }));
                    }
                });
            },
            change: function (event, ui) {
                if (ui.item == null) {
                    var uiAutocompletionWidget = $.data(this).uiAutocomplete,
                        menu = uiAutocompletionWidget.menu,
                        $ul = menu.element,
                        id = $ul.attr('id');
                    $('#' + id + ' > li:first h6').trigger('click');
                }

            },
            select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.data.UiDisplayNameInTextField);

                $("#departure_city_oneway").val(ui.item.data.UiDisplayNameInTextField);
                $("input[name='departure_iata']").val(ui.item.data.IATA);
                $("input[name='departure_display_name']").val(ui.item.data.DisplayName);

                setTimeout(function() {
                    $destination_city.trigger('focus');
                }, 100);
            }
        }).focus(function() {
            showSuggestionBlock($(this));
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var html = '';
            html += '<h6>' + item.label + ' (' + item.data.IATA + ')' + '</h6>';
            return $("<li>").append(html).appendTo(ul);
        };

        $destination_city.autocomplete({
            autoFocus: IsNotIPhone(),
            minLength: 2,
            delay: 0,
            selectFirst: true,
            position: {
                my: "left top+17",
                of: $destination_city.id,
                collision: "none"
            },
            open: function (event, ui) {
                if (!IsNotIPhone()) {
                    $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
                }

                hideSuggestionBlock($(this));
                $destination_city.parent().addClass('active');
            },
            close: function() {
                $destination_city.parent().removeClass('active');
            },
            source: function (request, response) {
                var convertDataToAutoComplete = function (data) {
                    var result = [];
                    $.each(data, function (i, element) {
                        result.push({ label: element.UiDisplayName, value: element.DisplayName, data: element, CityNameEn: element.CityNameEN });
                    });
                    return result;
                };

                var newValue = $("#destination_city").val();
                if (typeof cache[newValue] === "object") {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                    response($.grep(cache[newValue], function (value) {
                        return matcher.test(value.value) || matcher.test(value.CityNameEn);
                    }));

                    return;
                }
                var lastXhr = $.getJSON(serviceUrl, { term: newValue }, function (data, status, xhr) {

                }).done(function (data) {
                    if (data !== null) {
                        var array = convertDataToAutoComplete(data);
                        cache[newValue] = array;

                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                        response($.grep(array, function (value) {
                            return matcher.test(value.value) || matcher.test(value.CityNameEn);
                        }));
                    }
                });
            },
            change: function (event, ui) {
                if (ui.item == null) {
                    var uiAutocompletionWidget = $.data(this).uiAutocomplete,
                        menu = uiAutocompletionWidget.menu,
                        $ul = menu.element,
                        id = $ul.attr('id');
                    $('#' + id + ' > li:first h6').trigger('click');
                }
            },
            select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.data.UiDisplayNameInTextField);

                $("#destination_city_oneway").val(ui.item.data.UiDisplayNameInTextField);
                $("input[name='destination_city']").val(ui.item.data.UiDisplayNameInTextField);
                $("input[name='destination_iata']").val(ui.item.data.IATA);
                $("input[name='destination_display_name']").val(ui.item.data.DisplayName);
                $("input[name='destination_city_id']").val(ui.item.data.CityId);
                $("input[name='destination_city_name']").val(ui.item.data.CityNameEN);
                $("input[name='destination_country_name']").val(ui.item.data.Country);
            }
        }).focus(function() {
            showSuggestionBlock($(this));
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var html = '';
            html += '<h6>' + item.label + ' (' + item.data.IATA + ')' + '</h6>';
            return $("<li>").append(html).appendTo(ul);
        };


        // oneway
        var $departure_city_one = $("#departure_city_oneway");
        var $destination_city_one = $("#destination_city_oneway");
        $departure_city_one.autocomplete({
            autoFocus: IsNotIPhone(),
            minLength: 2,
            delay: 0,
            selectFirst: true,
            position: {
                my: "left top+17",
                of: $departure_city_one.id,
                collision: "none"
            },
            open: function (event, ui) {
                if (!IsNotIPhone()) {
                    $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
                }

                hideSuggestionBlock($(this));
                $departure_city_one.parent().addClass('active');
            },
            close: function (event, ui) {
                $departure_city_one.parent().removeClass('active');
            },
            source: function (request, response) {
                var convertDataToAutoComplete = function (data) {
                    var result = [];
                    $.each(data, function (i, element) {
                        result.push({ label: element.UiDisplayName, value: element.DisplayName, data: element, CityNameEn: element.CityNameEN });
                    });
                    return result;
                };

                var newValue = $("#departure_city_oneway").val();
                if (typeof cache[newValue] === "object") {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                    response($.grep(cache[newValue], function (value) {
                        return matcher.test(value.value) || matcher.test(value.CityNameEn);
                    }));

                    return;
                }
                var lastXhr = $.getJSON(serviceUrl, { term: newValue }, function (data, status, xhr) {

                }).done(function (data) {
                    if (data !== null) {
                        var array = convertDataToAutoComplete(data);
                        cache[newValue] = array;

                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                        response($.grep(array, function (value) {
                            return matcher.test(value.value) || matcher.test(value.CityNameEn);
                        }));
                    }
                });
            },
            change: function (event, ui) {
                if (ui.item == null) {
                    var uiAutocompletionWidget = $.data(this).uiAutocomplete,
                        menu = uiAutocompletionWidget.menu,
                        $ul = menu.element,
                        id = $ul.attr('id');
                    $('#' + id + ' > li:first h6').trigger('click');
                }
            },
            select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.data.UiDisplayNameInTextField);

                $("#departure_city").val(ui.item.data.UiDisplayNameInTextField);
                $("input[name='departure_iata']").val(ui.item.data.IATA);
                $("input[name='departure_display_name']").val(ui.item.data.DisplayName);

                setTimeout(function() {
                    $destination_city_one.trigger('focus');
                }, 100);
            }
        }).focus(function() {
            showSuggestionBlock($(this));
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var html = '';
            html += '<h6>' + item.label + ' (' + item.data.IATA + ')' + '</h6>';
            return $("<li>").append(html).appendTo(ul);
        };

        $destination_city_one.autocomplete({
            autoFocus: IsNotIPhone(),
            minLength: 2,
            delay: 0,
            selectFirst: true,
            position: {
                my: "left top+17",
                of: $destination_city_one.id,
                collision: "none"
            },
            open: function (event, ui) {
                if (!IsNotIPhone()) {
                    $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
                }

                hideSuggestionBlock($(this));
                $destination_city_one.parent().addClass('active');
            },
            close: function (event, ui) {
                $destination_city_one.parent().removeClass('active');
            },
            source: function (request, response) {
                var convertDataToAutoComplete = function (data) {
                    var result = [];
                    $.each(data, function (i, element) {
                        result.push({ label: element.UiDisplayName, value: element.DisplayName, data: element, CityNameEn: element.CityNameEN });
                    });
                    return result;
                };

                var newValue = $("#destination_city_oneway").val();
                if (typeof cache[newValue] === "object") {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                    response($.grep(cache[newValue], function (value) {
                        return matcher.test(value.value) || matcher.test(value.CityNameEn);
                    }));

                    return;
                }
                var lastXhr = $.getJSON(serviceUrl, { term: newValue }, function (data, status, xhr) {

                }).done(function (data) {
                    if (data !== null) {
                        var array = convertDataToAutoComplete(data);
                        cache[newValue] = array;

                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(newValue), "i");
                        response($.grep(array, function (value) {
                            return matcher.test(value.value) || matcher.test(value.CityNameEn);
                        }));
                    }
                });
            },
            change: function (event, ui) {
                if (ui.item == null) {
                    var uiAutocompletionWidget = $.data(this).uiAutocomplete,
                        menu = uiAutocompletionWidget.menu,
                        $ul = menu.element,
                        id = $ul.attr('id');
                    $('#' + id + ' > li:first h6').trigger('click');
                }
            },
            select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.data.UiDisplayNameInTextField);

                $("#destination_city").val(ui.item.data.UiDisplayNameInTextField);
                $("input[name='destination_iata']").val(ui.item.data.IATA);
                $("input[name='destination_display_name']").val(ui.item.data.DisplayName);
                $("input[name='destination_city_id']").val(ui.item.data.CityId);
                $("input[name='destination_city_name']").val(ui.item.data.CityNameEN);
                $("input[name='destination_country_name']").val(ui.item.data.Country);
            }
        }).focus(function() {
            showSuggestionBlock($(this));
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var html = '';
            html += '<h6>' + item.label + ' (' + item.data.IATA + ')' + '</h6>';
            return $("<li>").append(html).appendTo(ul);
        };
    };
    var autoCompleteMisc = function() {
        // when select item in suggestion block
        $('.suggestion-cities li.ui-menu-item').click(function() {
            var $row = $(this);
            var $element = $row.parent().data('element');
            var $element_id = $element.attr('id');
            var $extra = '';
            var $move_focus = false;
            if($element) {
                //$element.val($row.data('ui_display_name_in_text_field'));

                if($element.parents('#one-way').length > 0) {
                    $extra = '_oneway';
                }

                if($element_id == 'departure_city' || $element_id == 'departure_city_oneway') {
                    $("input[name='departure_city']").val($row.data('ui_display_name_in_text_field'));
                    $("input[name='departure_iata']").val($row.data('iata'));
                    $("input[name='departure_display_name']").val($row.data('display_name'));

                    $move_focus = true;
                } else {
                    $("input[name='destination_city']").val($row.data('ui_display_name_in_text_field'));
                    $("input[name='destination_iata']").val($row.data('iata'));
                    $("input[name='destination_display_name']").val($row.data('display_name'));
                    $("input[name='destination_city_id']").val($row.data('city_id'));
                    $("input[name='destination_city_name']").val($row.data('city_name_en'));
                    $("input[name='destination_country_name']").val($row.data('country'));
                }

                // Hide Suggestion Block
                hideSuggestionBlock($element);

                if($move_focus) {
                    // Move focus to destination city
                    setTimeout(function() {
                        $('#destination_city' + $extra).trigger('focus');
                    }, 100);
                }
            }
        });

        // when click anywhere out of suggestion block
        $(document).click(function(event){
            if($('#suggestion-departure-cities').is(':visible')) {
                var $stored_element = $('#suggestion-departure-cities').data('element');
                var $clicked_element = $(event.target);
                if (!$clicked_element.is($stored_element) && !$clicked_element.parents().andSelf().is('#suggestion-departure-cities')) {
                    hideSuggestionBlock();
                }
            } else {
                var $stored_element = $('#suggestion-destination-cities').data('element');
                var $clicked_element = $(event.target);
                if (!$clicked_element.is($stored_element) && !$clicked_element.parents().andSelf().is('#suggestion-destination-cities')) {
                    hideSuggestionBlock();
                }
            }
        });

        //$('#flight-search-form input[type="text"]').blur(function () {
        $('#trip-type-content input[type="text"]').blur(function (event) {
            if ($(this).val() != "") {
                $(this).closest("div").removeClass("errorClass");
            } else {
                var uiAutocompletionWidget = $("#" + $(this).attr("id")).data("ui-autocomplete");
                if (uiAutocompletionWidget != null && uiAutocompletionWidget !== 'undefined') {
                    var menu = uiAutocompletionWidget.menu,
                        $ul = menu.element,
                        id = $ul.attr('id');

                    if($('#' + id + ' > li:first h6').length > 0) {
                        $('#' + id + ' > li:first h6').trigger('click');
                    } else {
                        $(this).val($(this).data('original'));
                    }
                }
            }
        });
    };

    var showSuggestionBlock = function($element) {
        hideSuggestionBlock($element);

        $('.passengers').removeClass('active');
        $('.date-picker-wrapper').hide();
        $('.input-group-t').removeClass('active');

        var offset = $element.offset();
        var element_id = $element.attr('id');
        var suggestion_box_id = '';
        if(element_id == 'departure_city' || element_id == 'departure_city_oneway') {
            suggestion_box_id = '#suggestion-departure-cities';
        } else {
            suggestion_box_id = '#suggestion-destination-cities';
        }

        if($(suggestion_box_id).length > 0) {
            $element.data('original', $element.val());
            $element.val('');
            $element.parent().addClass('active opened');

            $(suggestion_box_id).css('top', offset.top + $element.outerHeight()+17)
                .css('left', offset.left)
                .show()
                .data('element', $element);
        }
    };
    var hideSuggestionBlock = function($element) {
        $('#trip-type-content .input-group-t.input-city').removeClass('active opened');
        $('.suggestion-cities').hide();
    };
    // end from & to autocomplete

    // start passengers
    var passengersDrop = function() {
        //reset data
        $(".passengers_adults .passengers_value").val($(".passengers_adults .passengers_value_data").val());
        $(".passengers_child .passengers_value").val($(".passengers_child .passengers_value_data").val());
        //
        $('.passengers').on('click', function (event) {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).addClass('active');
            }
        });

        // reset data
        $('.passengers input[data-defaultval]').each(function () {
            var _self = $(this),
                _dfval = _self.data("defaultval");
            _self.val(_dfval)
        })


        $('.passengers').on('click', '.passengers_mp', function () {

            var $this = $(this),
                $parent = $this.closest('.passengers'),
                $child = $('.passengers_child', $parent),
                $adult = $('.passengers_adults', $parent),
                $parent_this = $this.closest('.passengers_item'),
                $child_wrap = $('.passengers_child-content', $parent),
                $input_data = $('.passengers_value_data', $parent_this),
                $input = $('.passengers_value', $parent_this),
                $text_name = $('.passengers_name', $parent_this),
                $text_name_data = $text_name.data("text"),
                $text = $('.passengers_text', $parent),
                $input_child = $('.passengers_value', $child),
                $input_child_data = $('.passengers_value_data', $child),
                total_child = parseInt($input_child.val()),
                max_age = 15,
                max_passengers = 9,
                input_value = parseInt($input_data.val()),
                $adultLabel = $('.adult_num', $parent),
                $childLabel = $('.child_num', $parent);
            var childrenCount = $child.find(".passengers_value").html();
            var adultsCount = $adult.find(".passengers_value").html();

            //If the click is minus
            if ($this.hasClass('passengers_minus')) {

                if (input_value > 0) {

                    if ($parent_this.hasClass('passengers_adults')) {
                        if (input_value != 1)
                            input_value--;
                    }
                    else
                        input_value--;

                    $input_data.val(input_value);
                    $input.text(input_value);

                    if ($parent_this.hasClass('passengers_adults')) {
                        $adultLabel.val(input_value);
                    } else if($parent_this.hasClass('passengers_child')) {
                        $childLabel.val(input_value);
                    } else {

                        if (input_value === 0) {
                            var $child_wrapper = $parent_this.parent();

                            // reset number of child
                            if (total_child > 0) {
                                $child_wrapper.find(".passengers_item").each(function (index) {
                                    var _age = index + 1;
                                    $(this).find(".passengers_name").text($('#txt_AgeOfChild').val() + ' ' + _age);
                                })
                            }
                        }
                    }
                }

                if ($parent_this.hasClass('passengers_child')) {
                    if (input_value >= 0) {
                        $('.passengers_item', $child_wrap).last().remove();
                    }

                }

            } else {
                //Needed to add this cause adults, children and children ages are all using the same counter logic below
                var counterMaxValue;

                if ($parent_this.hasClass('passengers_adults') || $parent_this.hasClass('passengers_child')) {
                    counterMaxValue = max_passengers;
                }
                else {
                    counterMaxValue = max_age;
                }
                if (input_value < counterMaxValue) {
                    if (input_value >= 0) {
                        input_value++;
                        $input_data.val(input_value);
                        $input.text(input_value);

                        if ($parent_this.hasClass('passengers_adults')) {
                            $adultLabel.val(input_value);
                        } else if($parent_this.hasClass('passengers_child')) {
                            $childLabel.val(input_value);
                        } else {
                            if (input_value >= max_age) {
                                $input_data.val(max_age);
                                $input.text(max_age);
                            }

                        }

                        if ($parent_this.hasClass('passengers_child')) {

                            var $item_clone = $parent_this.clone(),
                                item_lenght = $('.passengers_item', $child_wrap).length + 1;
                            $('.passengers_name', $item_clone).text($('#txt_AgeOfChild').val() + ' ' + item_lenght);
                            $('.passengers_value_data', $item_clone).val(8);
                            $('.passengers_value_data', $item_clone).attr('name', 'child-age-' + item_lenght);
                            $('.passengers_value', $item_clone).text(8);
                            $item_clone.removeClass('passengers_child');
                            $child_wrap.append($item_clone);
                        }
                    }
                }
            }

            // set Child or Children base on total of child
            if ($parent_this.hasClass('passengers_child')) {
                if (input_value > 1) {
                    //$text_name.text($text_name_data + "ren")
                    $text_name.text($('#txt_Children').val())
                } else {
                    //$text_name.text($text_name_data)
                    $text_name.text($('#txt_Child').val())
                }

            }

            // set Adult or Adults base on total of adult
            if ($parent_this.hasClass('passengers_adults')) {
                if (input_value > 1) {
                    //$text_name.text($text_name_data + "s")
                    $text_name.text($('#txt_Adults').val())

                } else {
                    //$text_name.text($text_name_data)
                    $text_name.text($('#txt_Adult').val())
                }

            }

            return false;

        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.passengers').length) {
                $('.passengers').removeClass('active');
            }
        });
    }
    // end passengers

    // start search
    var filterAnalyticString = '';
    var searchRequestParameters =
    {
        'IATAFrom': '',
        'IATATo': '',
        'start' : '',
        'end': '',
        'oneWay': false,
        'numAdults': 1,
        'children': [],
        'sessionId': null,
        'limit': 10,
        'offset': 0,
        'sortOption': 'price',
        'selectedMaxPrice': 0,
        'selectedDepartureTimeRange': [0, 1439],
        'selectedReturnTimeRange': [0, 1439],
        'selectedFlightStops': 'any',
        'selectedAgencys': [],
        'selectedAirlines': [],
        'widgetId': null
    };
    var resetSearchRequestParameters = function() {
        searchRequestParameters.offset = 0;
        searchRequestParameters.selectedMaxPrice = $('#price-slider').data('max');
        searchRequestParameters.selectedDepartureTimeRange = [0, 1439];
        searchRequestParameters.selectedReturnTimeRange = [0, 1439];
        searchRequestParameters.selectedFlightStops = 'any';
        searchRequestParameters.selectedAgencys = [];
        searchRequestParameters.selectedAirlines = [];
    };

    /**
     * get search result from service by GetTripSearch (call this at first)
     * @param params
     * @constructor
     */
    var getTripSearch = function() {
        // show progress bar
        $('.progress-lb').show();
        $('.progress-box').show();
        $('.progress-box').progressFlightTimed(50);

        searching = true;
        $.ajax({
            type: "POST",
            url: '/flights/GetTripSearch',
            data: searchRequestParameters,
            statusCode: {
                505: function (response) {
                    console.log('error');
                }
            },
            success: function(res){
                searching = false;

                // hide progress bar
                $('.progress-box').hide();
                $('.progress-lb').hide();

                // hide form
                if (isMobile.any() || $(window).width() <= 481) {
                    $('.control-banner').show();
                    $('.control-search.active').trigger('click');
                }

                // update content
                $.when($('#search-result-box').html(res)).done(function() {
                    equalReturnDepart();
                    showAllOptions();
                    filterSection();

                    if(typeof(ga) == "function") {
                        ga('send', 'event', 'Handelse', 'Sokning', 'search-complete', { transport: 'beacon'});
                    }
                });
            }
        });
    };

    /**
     * get filtered search result from service by getTripsWithSessionAndFilters
     * @param reloadPage
     * @param callBackFunction
     * @constructor
     */
    var getTripsWithSessionAndFilters = function(reloadPage, callBackFunction) {
        if(reloadPage == true) {
            $('#progressIitems').show();

            searchRequestParameters.offset = 0;
        } else {
        }

        searching = true;
        $.ajax({
            type: "POST",
            url: '/flights/GetTripSearchWithFilter',
            data: searchRequestParameters,
            success: function(res){
                searching = false;

                if(reloadPage == true) {
                    $.when($('#serach-result-container').html(res)).done(function() {
                        equalReturnDepart();
                        //showAllOptions();

                        $('#progressIitems').hide();
                    });
                } else {
                    $.when($('#FlightTrips').append(res)).done(function() {
                        equalReturnDepart();
                        //showAllOptions();
                    });
                }

                if(isMobile.any()) {
                    $('.control-search.active').trigger('click');
                }

                if(filterAnalyticString != '') {
                    //console.log(filterAnalyticString);
                    ga('send', 'event', 'Handelse', 'Filter', filterAnalyticString, { transport: 'beacon'});
                }

                if(callBackFunction) {
                    callBackFunction();
                }
            }
        });
    };

    var equalReturnDepart = function() {
        if (screen.width >= 500) {  //Check if it's 2 columns
            $('.flight-list-view.loaded').each(function () {
                var _self = $(this),
                    _depart = _self.find('.flight-list-depart'),
                    _return = _self.find('.flight-list-return');
                var heighest = Math.max(_depart.height(), _return.height()) + 1;

                _depart.css('min-height', heighest);
                _return.css('min-height', heighest);

                _self.removeClass('loaded');
            })
        }
    };
    var showAllOptions = function() {
        $(document).on('click', '.fl-show-more-options span', function() {
            var obj = $(this).parents('.flight-list-price');
            if(obj.hasClass('fl-show-all')) {
                $(this).parents('.flight-list-price').removeClass('fl-show-all');
            } else {
                $(this).parents('.flight-list-price').addClass('fl-show-all');
            }
        });
    };
    var filterSection = function() {
        $('.control-banner .control-filter').show();        

        //price ranger
        $("#price-slider").slider({
            range: 'min',
            min: $("#price-slider").data('min'),
            max: $("#price-slider").data('max'),
            value: $('#price-slider').data('max'),
            step: 1,
            create: function (event, ui) {
                var $this = $(this),
                    $handle = $('.ui-slider-handle', $this),
                    $input = $('.range', $this),
                    currecy = $("#currency_code").val(),
                    value = $('.range', $this).val(),
                    $span = $('<span>' + formatPrice(value) + '&nbsp;' + currecy + '</span>');

                $handle.prepend($span);
                $input.val(value);
            },
            slide: function( event, ui ) {
                var $this=$(this),
                    $handle = $('.ui-slider-handle', $this),
                    currecy = $("#currency_code").val(),
                    value=ui.value;
                $('span', $handle).html(formatPrice(ui.value) + '&nbsp;' + currecy);
            },
            change: function( event, ui ) {

                if($("#price-slider").data('search') != false) {
                    filterAnalyticString = 'filter with price';
                    searchRequestParameters.selectedMaxPrice = ui.value;
                    getTripsWithSessionAndFilters(true);
                }
            }
        });

        // departure time range slider
        $("#departure-time-slider").slider({
            range: true,
            values: [0, 1439],
            step: 1,
            max: 1439,
            min: 0,
            create: function (event, ui) {
                var $this = $(this);

                $this.prepend("<label class='label-min'>" + formatMinuteTime(0) + "</label>");
                $this.append("<label class='label-max'>" + formatMinuteTime(1439) + "</label>");
                $input = $('.range', $this);
                var range = [0, 1439];
                $input.val(range);
            },
            slide: function (event, ui) {
                var $this = $(this);
                $this.find('.label-min').text(formatMinuteTime(ui.values[0]));
                $this.find('.label-max').text(formatMinuteTime(ui.values[1]));
                $input = $('.range', $this);
                $input.val(ui.values);
            },
            change: function( event, ui ) {

                if($("#departure-time-slider").data('search') != false) {
                    filterAnalyticString = 'filter with departure time';
                    searchRequestParameters.selectedDepartureTimeRange = ui.values;
                    getTripsWithSessionAndFilters(true);
                }
            }
        });

        // departure time range slider
        $("#return-time-slider").slider({
            range: true,
            values: [0, 1439],
            step: 1,
            max: 1439,
            min: 0,
            create: function (event, ui) {
                var $this = $(this);

                $this.prepend("<label class='label-min'>" + formatMinuteTime(0) + "</label>");
                $this.append("<label class='label-max'>" + formatMinuteTime(1439) + "</label>");
                $input = $('.range', $this);
                var range = [0, 1439];
                $input.val(range);
            },
            slide: function (event, ui) {
                var $this = $(this);
                $this.find('.label-min').text(formatMinuteTime(ui.values[0]));
                $this.find('.label-max').text(formatMinuteTime(ui.values[1]));
                $input = $('.range', $this);
                $input.val(ui.values);
            },
            change: function( event, ui ) {
                if($("#return-time-slider").data('search') != false) {
                    filterAnalyticString = 'filter with return time';
                    searchRequestParameters.selectedReturnTimeRange = ui.values;
                    getTripsWithSessionAndFilters(true);
                }
            }
        });

        $('#airline_all').change(function() {
            var $box = $(this);
            if ($box.is(":checked")) {
                $('.aireline_filter input.airline-filter').prop("checked", false);
                $box.prop("checked", true);

                filterAnalyticString = 'filter with all airlines';
                searchRequestParameters.selectedAirlines = [];
                getTripsWithSessionAndFilters(true);
            } else if($('.aireline_filter input.airline-filter:checked').length == 0) {
                $box.prop("checked", true);
            }
        });
        $('.aireline_filter input.airline-filter').change(function() {
            if($('.aireline_filter input.airline-filter:checked').length > 0) {
                $('#airline_all').prop("checked", false);
            } else {
                $('#airline_all').prop("checked", true);
            }

            airelineCodes = $('.aireline_filter input.airline-filter:checked').map(function() {
                return $(this).val();
            }).get();

            filterAnalyticString = 'filter with airlines';
            searchRequestParameters.selectedAirlines = airelineCodes;
            getTripsWithSessionAndFilters(true);
        });

        $('.stop-filter').change(function() {
            searchRequestParameters.selectedFlightStops = $(this).val();
            getTripsWithSessionAndFilters(true);
        });

        $(document).on('click', '.sort-area .sort', function() {
            $self = $(this);
            if($self.hasClass('selected')) {
                return;
            }

            $('.sort-area .sort.selected').removeClass('selected');
            $self.addClass('selected');

            filterAnalyticString = 'sort by ' + $self.data('sort');
            searchRequestParameters.sortOption = $self.data('sort');
            getTripsWithSessionAndFilters(true);
        });

        $(window).scroll(function() {
            var moreObj = $('.navigation-loadmore');

            if(moreObj.length == 0 || moreObj.data('loading') == true || searching == true) {
                return;
            }

            if ($(window).scrollTop() >= moreObj.offset().top + moreObj.outerHeight() - window.innerHeight) {
                var totalCount = moreObj.data('total');
                var pageLimit = searchRequestParameters.limit;
                var pageOffset = moreObj.data('offset');
                if((pageOffset + pageLimit) >= totalCount) {
                    return;
                }

                moreObj.data('loading', true);
                $("#flightLoadMoreImage").show();

                filterAnalyticString = '';
                searchRequestParameters.offset = pageOffset + pageLimit;
                getTripsWithSessionAndFilters(false, function() {
                    $("#flightLoadMoreImage").hide();
                    moreObj.data('loading', false);
                    moreObj.data('offset', searchRequestParameters.offset);
                });
            }
        });

        $('#FlightResetFilter').click(function(e) {
            e.preventDefault();

            //reset airlines
            $('input.airline-filter-all').attr('checked', 'checked');
            $('input.airline-filter').removeAttr('checked');

            //reset stops
            $('#stop_num_all').attr('checked', 'checked');

            //reset price range
            var priceSlider = $("#price-slider");
            var departureTimeSlider = $("#departure-time-slider");
            var returnTimeSlider = $("#return-time-slider");

            priceSlider
                .data('search', false)
                .slider('value', priceSlider.data('max'))
                .slider('option', 'slide').call(priceSlider, null, {value: priceSlider.data('max')})
            departureTimeSlider
                .data('search', false)
                .slider('values', [0, 1439])
                .slider('option', 'slide').call(departureTimeSlider, null, {values: departureTimeSlider.slider('values')})
            returnTimeSlider
                .data('search', false)
                .slider('values', [0, 1439])
                .slider('option', 'slide').call(returnTimeSlider, null, {values: returnTimeSlider.slider('values')})

            resetSearchRequestParameters();
            getTripsWithSessionAndFilters(true);

            priceSlider.data('search', true);
            departureTimeSlider.data('search', true);
            returnTimeSlider.data('search', true);
        });
    }
    // end search

    // start mobile responsive
    var mobileForm = function() {
        $('.control-search').on('click', function (event) {
            event.preventDefault();
            var _self = $(this);
            if ($('.form-mobile').css('display') == 'none') {
                $('.form-mobile').slideDown(300);
                _self.addClass('active');
            } else {
                $('.form-mobile').slideUp(300);
                _self.removeClass('active');
            }
            var body = $("html, body");
            body.stop().animate({ scrollTop: 0 }, '500', 'swing');
        });

        $(window).resize(function (event) {
            if (window.innerWidth > 991) {
                $('.form-mobile').css('display', '');
            }
        });
    };
    var filterSideBar = function() {
        $('.control-filter').click(function (event) {
            var _mainsidebar = $('.filter-box');
            if (_mainsidebar.hasClass('active')) {
                _mainsidebar.removeClass('active');
                $('.close-sidebar.bg').remove();
                $('body').css('overflow', 'auto');
            } else {
                _mainsidebar.addClass('active');
                _mainsidebar.after('<div class="close-sidebar bg"><div>')
                $('body').css('overflow', 'hidden');
            }
        });

        $('body').on('click', '.close-sidebar', function (event) {
            event.preventDefault();
            $('.filter-box').removeClass('active');
            $('.close-sidebar.bg').remove();
            $('body').css('overflow', 'auto');
        });
    };
    // end mobile responsive

    // Common
    var commonFunctions = function() {
        // newsletter form
        $("#newsletter_submit").click(function(){
            var $emailObj = $("#newsletter_email");
            var $msgObj = $("#newsletter_msg");

            if($emailObj.val() == '') {
                $msgObj.html('Please input email address.');
                return;
            }

            var postdata =  $emailObj.val();
            $.ajax({
                type: 'post',
                url: '/nyhetsbrev',
                data: { email: postdata },
                success: function(result) {
                    if( result == "ok" ){
                        $emailObj.val('');
                        $msgObj
                            .removeClass('alert-danger')
                            .addClass('alert-success')
                            .show()
                            .html('Tack, vi har registrerat dig till vårt nyhetsbrev!');
                    }
                    else{
                        $msgObj
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .show()
                            .html('Du har angett en felaktig epostadress.');
                    }
                }
            })

            return false;
        });
    };

    return {
        init: function () {

            // Common
            commonFunctions();

            // DatePicker
            datePicker();

            // Auto Complete
            autoComplete();
            autoCompleteMisc();
            
            // Passengers Drop
            passengersDrop();

            // Mobile Responsive
            mobileForm();
            filterSideBar();

        },
        search: function(requestedParameters) {
            $.extend(searchRequestParameters, requestedParameters);
            getTripSearch();
        },
        setParameters: function(requestedParameters) {
            $.extend(searchRequestParameters, requestedParameters);
        }
    }
}();

$(function() {
    "use strict";

    FLIGHT.init();

});