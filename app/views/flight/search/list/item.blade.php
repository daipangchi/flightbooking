<div class="flight-list-view loaded">
    <!--start departure-->
    <div class="flight-list-depart">
        <div class="flight-list-head">
            <span class="fl-departure-time">Utresa <span class="fl-time">{{ hour2str($trip->DepartureTravelTime) }}</span></span>
            <span class="fl-stops">{{ format_stops(count($departureFlights)) }}</span>
            <span class="fl-airline"><img src="{{ airline_icon($departureFlights[0]->AirlineCode) }}"/> <span title="{{ $departureFlights[0]->AirlineName }}">{{ $departureFlights[0]->AirlineName }}</span></span>
        </div>       
        <table>
            @foreach($departureFlights as $flight)
            <tr>
                <td>
                    <span class="fl-departure-part"><span class="fl-time">{{ $flight->DepartureTime }}</span> <span class="fl-country" title="{{ $flight->DepartureAirportName }}">{{ $flight->DepartureAirportName }}</span> ({{ $flight->DepartureCityCode }})</span>
                    <span class="fl-arrival-part"><span class="fl-time">{{ $flight->ArrivalTime }}</span> <span class="fl-country" title="{{ $flight->ArrivalAirportName }}">{{ $flight->ArrivalAirportName }}</span> ({{ $flight->ArrivalCityCode }})</span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!--end departure-->
    
    @if($tripResult->isOneWay == false && !empty($returnFlights))
    <!--start return-->
    <div class="flight-list-return">
        <div class="flight-list-head">
            <span class="fl-departure-time">Hemresa <span class="fl-time">{{ hour2str($trip->ReturnTravelTime) }}</span></span>
            <span class="fl-stops">{{ format_stops(count($returnFlights)) }}</span>
            <span class="fl-airline"><img src="{{ airline_icon($returnFlights[0]->AirlineCode) }}"/> <span title="{{ $returnFlights[0]->AirlineName }}">{{ $returnFlights[0]->AirlineName }}</span></span>
        </div>       
        <table>
            @foreach($returnFlights as $flight)
            <tr>
                <td>
                    <span class="fl-departure-part"><span class="fl-time">{{ $flight->DepartureTime }}</span> <span class="fl-country" title="{{ $flight->DepartureAirportName }}">{{ $flight->DepartureAirportName }}</span> ({{ $flight->DepartureCityCode }})</span>
                    <span class="fl-arrival-part"><span class="fl-time">{{ $flight->ArrivalTime }}</span> <span class="fl-country" title="{{ $flight->ArrivalAirportName }}">{{ $flight->ArrivalAirportName }}</span> ({{ $flight->ArrivalCityCode }})</span>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!--end departure-->
    @endif
    <div class="clearfix"></div>
    
    <!--start price-->
    <div class="flight-list-price">
        <?php $i = 0; ?>
        <?php $offers = is_array($trip->ResultList->TripAgencyResult) ? $trip->ResultList->TripAgencyResult : array($trip->ResultList->TripAgencyResult); ?>
        @if(count($offers) > 1)
            <div class="fl-show-more-options loaded"><span>Visa fler alternativ</span></div>
        @endif

        @foreach($offers as $offer)
            <div class="fl-list-price-item <?php echo $i == 0 ? 'first' : ''; ?>">
                <span class="fl-agency"><img src="{{ agency_icon($offer->AgencyName) }}"/></span>
                
                @if($i == 0 && count($offers) > 1)
                <div class="fl-show-more-options loaded"><span>Visa fler alternativ</span></div>
                @endif

                <div class="fl-booking">
                    <div class="fl-booking-item">
                        <span class="fl-price">
                            <!--<div class="fl-old-price">3443 SEK</div>-->
                            <a href="{{ $offer->PurchaseUrl }}" target="_blank"><span class="fl-new-price">{{ format_price($offer->Price->TotalPrice) }}</span></a>
                        </span>
                        <a href="{{ $offer->PurchaseUrl }}" onclick="ga('send', 'event', 'Utgaende klick', 'Flygresa', '{{ $offer->AgencyName.' - '.$params['IATAFrom'].' - '.$params['IATATo'] }}', { transport: 'beacon'});" class="fl-booking-link" rel="nofollow" target="_blank">Gå Till Resa</a>
                    </div>  
                </div>
            </div>
            <hr class="clearfix">
            <?php $i++; ?>
        @endforeach
    </div>
    <!--end price-->
    
</div>

{{ save_flight($departureFlights, $returnFlights, $offers[0]->Price->TotalPrice, $params['numAdults'], count($params['children'])) }}

{{ save_direct_flight($departureFlights, $returnFlights) }}