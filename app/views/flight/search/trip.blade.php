@if(isset($tripResult) && ($tripResult->TripGroups != null))
    <?php
        $airlines = $tripResult->AirlineResultInfo->AirlineResultInfo;
        $flights = $tripResult->TripGroups->Trip;
    ?>
    
    @include('flight.search.filters')
    @include('flight.search.list', ['wrapper' => true])
    
    <script>
        var requestParameters = new Object();
        requestParameters.sessionId = '<?php echo $tripResult->SessionId; ?>';
        requestParameters.selectedMaxPrice = '<?php echo $tripResult->PriceRange->int[1]; ?>';
        FLIGHT.setParameters(requestParameters);
    </script>
@else
    <div class="col-md-12" style="padding: 15px;">
        <p>Tyvärr hittade vi inga flyg som matchar din sökning.</p>
        <p>Var god ändra dina sökkriterier och försök igen.</p>
    </div>
@endif