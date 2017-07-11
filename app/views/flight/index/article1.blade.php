<?php
    $articleData = array(
        array('destination' => 'Paris', 'land' => 'Frankrike', 'slug' => 'paris'),
        array('destination' => 'Barcelona', 'land' => 'Spanien', 'slug' => 'barcelona'),
        array('destination' => 'Köpenhamn', 'land' => 'Danmark', 'slug' => 'till-kopenhamn'),
        array('destination' => 'Helsingfors', 'land' => 'Finland', 'slug' => 'helsingfors'),
        array('destination' => 'Malaga', 'land' => 'Spanien', 'slug' => 'malaga'),
        array('destination' => 'Prag', 'land' => 'Tjeckien', 'slug' => 'prag'),
        array('destination' => 'Budapest', 'land' => 'Ungern', 'slug' => 'budapest'),
        array('destination' => 'Alicante', 'land' => 'Spanien', 'slug' => 'alicante'),
    );
?>

<div class="row article-part1 margin-bottom">
    <div class="col-sm-6 clear-padding-left xs-clear-padding-right xs-margin-bottom">
        <div class="data-info-table blue-box">
            <h5>POPULÄRA RESMÅL</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Resmål</th>
                        <th>Land</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articleData as $row)
                    <tr>
                        <td><a href="{{ internal_link_from_slug($row['slug']) }}">{{ $row['destination'] }}</a></td>
                        <td>{{ $row['land'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6 clear-padding-right xs-clear-padding-left">
        <div class="row">
            <div class="col-xs-6 col-xxs-12 clear-padding-left xxs-clear-padding-right xxs-margin-bottom">
                <article>
                    <div class="article-image"><img src="{{ asset('images/article/flygradsla.jpg') }}"/></div>
                    <h5>FLYGRÄDSLA</h5>
                    <p>Att flyga är det absolut säkraste sättet att färdas på idag.</p>
                    <a href="{{ route('page.flygradsla') }}" class="read-more">Läs mer</a>
                </article>
            </div>
            <div class="col-xs-6 col-xxs-12 clear-padding-right">
                <article>
                    <div class="article-image"><img src="{{ asset('images/article/flyger gravid.jpg') }}"/></div>
                    <h5>FLYGER GRAVID</h5>
                    <p>I fjol gjorde svenskarna över 18 miljoner utlandsresor.</p>
                    <a href="{{ route('page.gravid') }}" class="read-more">Läs mer</a>
                </article>
            </div>
        </div>
    </div>
</div>