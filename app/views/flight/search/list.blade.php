@if(isset($wrapper) && ($wrapper === true))
    <div id="serach-result-container" class="col-md-9 flight-listing">
@endif

@if(isset($tripResult) && ($tripResult->TripGroups != null) && isset($tripResult->TripGroups->Trip))

    @include('flight.search.sortnav')

    <!-- START: FLIGHT LIST VIEW -->
    <div class="flight-list">
        @include('flight.search.loading')

        <div id="FlightTrips">
            @include('flight.search.hotels')

            <?php $flights = is_array($tripResult->TripGroups->Trip) ? $tripResult->TripGroups->Trip : array($tripResult->TripGroups->Trip); ?>
            @foreach($flights as $trip)
                <?php
                    $departureFlights = $returnFlights = array();
                    if($trip->DepartureFlights != null) {
                        $departureFlights = is_array($trip->DepartureFlights->Flight) ? $trip->DepartureFlights->Flight : array($trip->DepartureFlights->Flight);
                    }

                    if($trip->ReturnFlights != null) {
                        $returnFlights = is_array($trip->ReturnFlights->Flight) ? $trip->ReturnFlights->Flight : array($trip->ReturnFlights->Flight);
                    }
                ?>
                @include('flight.search.list.item')
            @endforeach
        </div>
    </div>

    <div class="clearfix"></div>
    <!-- END: FLIGHT LIST VIEW -->

    <div class="navigation-loadmore" style="text-align:center;" data-offset="0" data-total="{{ $tripResult->TotalCount }}">
        <img class="bs-select-hidden" id="flightLoadMoreImage" src="{{ asset('assets/images/loading.gif') }}">
    </div>
@else
    <div class="col-md-12" style="padding: 15px;">
        @include('flight.search.loading')

        <p>Tyvärr hittade vi inga flyg som matchar din sökning.</p>
        <p>Var god ändra dina sökkriterier och försök igen.</p>
    </div>
@endif

@if(isset($wrapper) && ($wrapper === true))
    </div>
@endif