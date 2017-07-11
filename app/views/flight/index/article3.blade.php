<?php
    $articleData = array(
        array('city' => 'Stockholm', 'airport' => 'Arlanda', 'slug' => 'stockholm'),
        array('city' => 'Göteborg', 'airport' => 'Landvetter', 'slug' => 'goteborg'),
        array('city' => 'Köpenhamn', 'airport' => 'Kastrup', 'slug' => 'kopenhamn'),
        array('city' => 'Malmö', 'airport' => 'Malmö Airport', 'slug' => 'malmo'),
        array('city' => 'Umeå', 'airport' => 'Umeå Airport', 'slug' => 'umea'),
        array('city' => 'Karlstad', 'airport' => 'Karlstad Airport', 'slug' => '#'),
        array('city' => 'Luleå', 'airport' => 'Luleå Airport', 'slug' => '#'),
        array('city' => 'Åre / Östersund', 'airport' => 'Åre Östersund Airport', 'slug' => '#'),
    );
?>

<div class="row article-part3 margin-bottom">
    <div class="col-sm-6 clear-padding-left xs-clear-padding-right xs-margin-bottom">
        <div class="data-info-table blue-box">
            <h5>Populära avreseorter</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>Stad</th>
                    <th>Flygplats</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articleData as $row)
                    <tr>
                        <td><a href="{{ internal_link_from_slug($row['slug']) }}">{{ $row['city'] }}</a></td>
                        <td>{{ $row['airport'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(count($departureCityFeed) > 0)
    <div class="col-sm-6 clear-padding-right xs-clear-padding-left">
        <div class="data-info-table red-box" style="position:relative">
            <h5>Sista minuten charter</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>Från</th>
                    <th>Till</th>
                    <th>Avresa</th>
                    <th>Pris</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($departureCityFeed as $row)
                        <tr>
                            <td>{{ $row->departure_airport_name }}</td>
                            <td><a href="{{ get_affliate_booking_url($row) }}" target="_blank">{{ $row->dname }}</a></td>
                            <td>{{ mydate('Y-m-d', $row->departure_date) }}</td>
                            <td>{{ $row->price }} kr</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="http://www.sistaminutenresor.com" style="bottom:7px;color:white;font-size:115%;position:absolute;right:20px;">via www.sistaminutenresor.com</a>
        </div>
    </div>
    @endif
</div>