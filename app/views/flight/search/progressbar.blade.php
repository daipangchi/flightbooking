<!--start progress bar-->
<?php 
$agencyList = array('BravoFly', 'QatarAirways', 'Ticket', 'Travelfinder', 'Sembo', 
    'Wegolo', 'Flightfinder', 'TravelPartner', 'AOBTravel', 'Travellink',
    'SuperSaver', 'Budjet', 'Travelstart', 'Mytrip', 'Tripsta',
    'Kiwi', 'Flygvaruhuset', 'SkyTours', 'Flygcity',
    'Kilroy', 'Mrjet', 'Seat24', 'Opodo', 'Expedia',
    'Flygpoolen', 'Flyhi');
?>
<div>
    <div class="progress-lb"></div>
    <div class="progress-box">
        <div class="progress-wrapper">
            <div class="progress-label">Vi söker nu igenom alla resebyråerna och flygbolagen för bästa möjliga pris på din resa. Det tar maximalt 30 sekunder! </div>
            <div class="progress">
                <div class="progress-bar active" role="progressbar" aria-valuemin="0" aria-valuemax="100"><div id="indicator" class="indicator"></div></div>
            </div>
            <ul class="progress-agents clearfix">
                @foreach($agencyList as $agency)
                    <li><img src="{{ agency_icon($agency) }}" alt=""></li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
<!--end progress bar-->