@if(isset($tripResult) && ($tripResult->TripGroups != null) && isset($tripResult->TripGroups->Trip))
    
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

@endif