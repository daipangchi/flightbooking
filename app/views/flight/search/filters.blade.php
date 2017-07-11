<div class="col-md-3 clear-padding filter-box">
    <div class="close-sidebar"><i class="fa fa-close"></i></div>

    <div class="filter-head text-center">
		<h4>Vi hittade {{ $tripResult->TotalCount }} resor</h4>
	</div>
	<div class="filter-area">
        <div class="price_filter filter">
			<h5>Max pris</h5>
            <hr/>
            <div id="price-slider" class="price-slider slider-ui" data-min="{{ $tripResult->PriceRange->int[0] }}" data-max="{{ $tripResult->PriceRange->int[1] }}">
                <input type="text" class="range" value="{{ $tripResult->PriceRange->int[1] }}" data-currecy="SEK"/>
            </div>
		</div>
        <!--<div class="time_filter filter">
            <h5>Total restid</h5>
            <hr/>
            <p><input type="text" class="total_time_filter" id="total_time_range" data-slider-id="total_time_range_slider" data-slider-min="{{ $tripResult->TravelTimeRange->int[0] }}" data-slider-max="{{ $tripResult->TravelTimeRange->int[1] }}" data-slider-value="{{ $tripResult->TravelTimeRange->int[1] }}" data-slider-step="10"></p>
        </div>-->

        <div class="departure_time_filter filter">
            <h5>Avgångstid utresa</h5>
            <hr/>         
            <div id="departure-time-slider" class="departure-time-slider slider-ui time-range-slider">
                <input type="text" class="range" value="1439"/>
            </div>                                                                                                                                                                      
        </div>

        <div class="arival_time_filter filter">
            <h5>Avgångstid hemresa</h5>
            <hr/>
            <div id="return-time-slider" class="return-time-slider slider-ui time-range-slider">
                <input type="text" class="range" value="1439"/>
            </div>
        </div>

        <div class="stop_filter filter">
            <h5>Antal stopp</h5>
            <hr/>
            <ul>
                <li><input type="radio" class="icheck stop-filter" id="stop_num_direct" name="stop_num" value="direct"/><label for="stop_num_direct">Endast direktflyg</label></li>
                <li><input type="radio" class="icheck stop-filter" id="stop_num_one" name="stop_num" value="one-or-less"/><label for="stop_num_one">Max 1 byte</label></li>
                <li><input type="radio" class="icheck stop-filter" id="stop_num_all" name="stop_num" value="any" checked="checked"/><label for="stop_num_all">Alla</label></li>
            </ul>
        </div>

        <div class="aireline_filter filter">
            <h5>Flygbolag</h5>
            <hr/>
            <ul>
                <li><input type="checkbox" class="icheck airline-filter-all" id="airline_all" value="all" checked="checked"/><label for="airline_all">Alla</label></li>
                @foreach($airlines as $al)
                <li><input type="checkbox" class="icheck airline-filter" id="airline_{{ $al->AirlineCode }}" value="{{ $al->AirlineCode }}"/><label for="airline_{{ $al->AirlineCode }}">{{ $al->AirlineName }}</label></li>
                @endforeach
            </ul>
        </div>

        <div class="aireline_filter filter">
            <h5>Återställ filter</h5>
            <hr/>
            <a id="FlightResetFilter" href="javascript:void(0);">Rensa alla filter</a>
        </div>

        @if(count($destinationFeed))
        <div class="destination_feed filter">
            <h5>Charterflyg</h5>
            <hr/>

            @foreach($destinationFeed as $row)
                <div class="row">
                    <div class="col-xs-6 clear-padding">
                        {{ $row->departure_airport_name }}<br/>
                        &rightarrow; <a href="{{ get_affliate_booking_url($row) }}" target="_blank">{{ $row->dname }}</a>
                    </div>

                    <div class="col-xs-6 clear-padding text-right">
                        {{ mydate('Y-m-d', $row->departure_date) }}<br/>
                        <span style="color:red;">{{ $row->price }} kr</span>
                    </div>
                </div>
                <hr style="border-style:dotted;margin:5px;"/>
            @endforeach

            <div class="text-right">
                via <a href="http://sistaminutenresor.com" target="_blank"><b>Sistaminutenresor.com</b></a>
            </div>
        </div>
        @endif
	</div>
</div>
<!-- END: FILTER AREA -->
