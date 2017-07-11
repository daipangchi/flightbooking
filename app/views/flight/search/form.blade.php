<!-- START: MODIFY SEARCH -->
<div class="row modify-search">
    <div class="container">

        <div class="form-mobile">
            <div class="form-description">
                <h1>
                    Sök billiga flygresor

                    @if(isset($city))
                        @if($city->destination == 1)
                            till {{ $city->name }}
                        @endif
                    @endif
                </h1>
                <p>Vår helt oberoende sajt söker fram de billigaste och snabbaste resorna bland över 70 resesajter och 900 flygbolag.</p>
            </div>

            <ul id="trip-type" class="trip-type clearfix">
                <li class="<?php echo Input::get('one_way') != '1' ? 'active' : ''; ?>"><a href="#round-trip" data-toggle="tab" data-way="false">Tur o Retur</a></li>
                <li class="<?php echo Input::get('one_way') == '1' ? 'active' : ''; ?>"><a href="#one-way" id="one-way-tab" data-toggle="tab" data-way="true">Enkelresa</a></li>
            </ul>
            <div id="trip-type-content" class="tab-content search-detail-content clearfix">
                <div class="tab-pane fade in <?php echo Input::get('one_way') != '1' ? 'active' : ''; ?>" id="round-trip">
                    <form id="flight-search-form" method="get" action="{{ route('flight.search') }}">
                        <div class="col-lg-2 col-sm-5 col-xs-6 col-xxs-12 field-box">
                            <div class="form-gp">
                                <label>Från</label>
                                <div class="input-group-t input-city">
                                    <input type="text" id="departure_city" name="departure_city" class="form-control flight-city-input remove-position" required placeholder="E.g. London" value="{{ Input::has('departure_city') ? Input::get('departure_city') : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-5 col-xs-6 col-xxs-12 field-box">
                            <div class="form-gp">
                                <label>Till</label>
                                <div class="input-group-t input-city">
                                    <input type="text" id="destination_city" name="destination_city" class="form-control flight-city-input remove-position" required placeholder="E.g. New York" value="{{ Input::has('destination_city') ? Input::get('destination_city') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->ui_display_name_in_text_field : '') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-xs-12 col-xxs-12 gr-date lg-clear-padding-left">
                            <div class="col-xs-6 col-xxs-6 field-box">
                                <div class="form-gp">
                                    <label>Avresa</label>
                                    <div class="input-group-t"><input type="text" id="departure_date" name="departure_date" class="form-control datepicker date-start" required readonly="true" placeholder="YYYY-MM-DD" value="{{ Input::has('departure_date') ? Input::get('departure_date') : date('Y-m-d', strtotime('+7 days')) }}" /></div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-xxs-6 field-box">
                                <div class="form-gp">
                                    <label>Hemresa</label>
                                    <div class="input-group-t"><input type="text" id="return_date" name="return_date" class="form-control datepicker date-end" required readonly="true" placeholder="YYYY-MM-DD" value="{{ Input::has('return_date') ? Input::get('return_date') : date('Y-m-d', strtotime('+14 days')) }}" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-4 col-xs-6 col-xxs-12 field-box xs-clear-padding-left">
                            @include('flight.search.form.passenger_drop')
                        </div>
                        <div class="col-sm-1 col-xs-6 field-box form-button-box">
                            <div class="modify-search-button">
                                <button class="btn-sh"><span>Sök</span></button>
                            </div>
                        </div>

                        <input type="hidden" id="one_way" name="one_way" value="0"/>
                        <input type="hidden" id="departure_iata" name="departure_iata" value="{{ Input::has('departure_iata') ? Input::get('departure_iata') : '' }}"/>
                        <input type="hidden" id="departure_display_name" name="departure_display_name" value="{{ Input::has('departure_display_name') ? Input::get('departure_display_name') : '0' }}"/>

                        <input type="hidden" id="destination_iata" name="destination_iata" value="{{ Input::has('destination_iata') ? Input::get('destination_iata') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->IATA : '') }}"/>
                        <input type="hidden" id="destination_display_name" name="destination_display_name" value="{{ Input::has('destination_display_name') ? Input::get('destination_display_name') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->display_name : '') }}"/>
                        <input type="hidden" id="destination_city_id" name="destination_city_id" value="{{ Input::has('destination_city_id') ? Input::get('destination_city_id') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->city_id : '') }}"/>
                        <input type="hidden" id="destination_city_name" name="destination_city_name" value="{{ Input::has('destination_city_name') ? Input::get('destination_city_name') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->city_name_en : '') }}"/>
                        <input type="hidden" id="destination_country_name" name="destination_country_name" value="{{ Input::has('destination_country_name') ? Input::get('destination_country_name') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->country : '') }}"/>
                        <input type="hidden" id="currency_code" value="{{ CURRENCY_CODE }}"/>
                    </form>
                </div>

                <div class="tab-pane fade in <?php echo Input::get('one_way') == '1' ? 'active' : ''; ?>" id="one-way">
                    <form id="flight-search-form-oneway" method="get" action="{{ route('flight.search') }}">
                        <div class="col-lg-2 col-sm-5 col-xs-6 col-xxs-12 field-box">
                            <div class="form-gp">
                                <label>Från</label>
                                <div class="input-group-t input-city">
                                    <input type="text" id="departure_city_oneway" name="departure_city" class="form-control flight-city-input remove-position" required placeholder="E.g. London" value="{{ Input::has('departure_city') ? Input::get('departure_city') : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-5 col-xs-6 col-xxs-12 field-box">
                            <div class="form-gp">
                                <label>Till</label>
                                <div class="input-group-t input-city">
                                    <input type="text" id="destination_city_oneway" name="destination_city" class="form-control flight-city-input remove-position" required placeholder="E.g. New York" value="{{ Input::has('destination_city') ? Input::get('destination_city') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->ui_display_name_in_text_field : '') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-xs-12 col-xxs-12 gr-date lg-clear-padding-left">
                            <div class="col-xs-6 col-xxs-6 field-box">
                                <div class="form-gp">
                                    <label>Avresa</label>
                                    <div class="input-group-t"><input type="text" id="departure_date_oneway" name="departure_date" class="form-control datepicker date-start" required readonly="true" placeholder="YYYY-MM-DD" value="{{ Input::has('departure_date') ? Input::get('departure_date') : date('Y-m-d', strtotime('+7 days')) }}" /></div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-xxs-6 field-box">
                                <div class="form-gp">
                                    <label>Hemresa</label>
                                    <div class="input-group-t"><input type="text" id="return_date_oneway" name="return_date" class="form-control datepicker date-end disabled" required readonly="true" placeholder="YYYY-MM-DD" value="{{ Input::has('departure_date') ? Input::get('departure_date') : date('Y-m-d', strtotime('+14 days')) }}" disabled="disabled"/></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-4 col-xs-6 col-xxs-12 field-box xs-clear-padding-left">
                            @include('flight.search.form.passenger_drop')
                        </div>
                        <div class="col-sm-1 col-xs-6 field-box form-button-box">
                            <div class="modify-search-button">
                                <button class="btn-sh"><span>Sök</span></button>
                            </div>
                        </div>

                        <input type="hidden" id="one_way_oneway" name="one_way" value="1"/>
                        <input type="hidden" id="departure_iata_oneway" name="departure_iata" value="{{ Input::has('departure_iata') ? Input::get('departure_iata') : '' }}"/>
                        <input type="hidden" id="departure_display_name_oneway" name="departure_display_name" value="{{ Input::has('departure_display_name') ? Input::get('departure_display_name') : '0' }}"/>

                        <input type="hidden" id="destination_iata_oneway" name="destination_iata" value="{{ Input::has('destination_iata') ? Input::get('destination_iata') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->IATA : '') }}"/>
                        <input type="hidden" id="destination_display_name_oneway" name="destination_display_name" value="{{ Input::has('destination_display_name') ? Input::get('destination_display_name') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->display_name : '') }}"/>
                        <input type="hidden" id="destination_city_id_oneway" name="destination_city_id" value="{{ Input::has('destination_city_id') ? Input::get('destination_city_id') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->city_id : '') }}"/>
                        <input type="hidden" id="destination_city_name_oneway" name="destination_city_name" value="{{ Input::has('destination_city_name') ? Input::get('destination_city_name') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->city_name_en : '') }}"/>
                        <input type="hidden" id="destination_country_name_oneway" name="destination_country_name" value="{{ Input::has('destination_country_name') ? Input::get('destination_country_name') : (isset($destinationCity) && !is_null($destinationCity) ? $destinationCity->country : '') }}"/>
                        <input type="hidden" id="currency_code" value="{{ CURRENCY_CODE }}"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="control-banner">
            <span class="control-search active">Ändra sökning</span>
            <span class="control-filter" style="display:none;">Filtrera</span>
        </div>

    </div>
</div>
<!-- END: MODIFY SEARCH -->