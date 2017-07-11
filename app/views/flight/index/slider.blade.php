<?php
    $locationGroup = array(
        'popular' => array(
            array('name' => 'Mallorca', 'price' => 2140),
            array('name' => 'Bangkok', 'price' => 5443),
            array('name' => 'Miami', 'price' => 8420),
            array('name' => 'Dubai', 'price' => 5443)
        ),
        'sun' => array(
            array('name' => 'Phuket', 'price' => 2140),
            array('name' => 'Mallorca', 'price' => 5443),
            array('name' => 'Las Palmas', 'price' => 2140),
            array('name' => 'Krabi', 'price' => 2140)
        ),
        'shopping' => array(
            array('name' => 'New York', 'price' => 2140),
            array('name' => 'London', 'price' => 2140),
            array('name' => 'Istanbul', 'price' => 2140),
            array('name' => 'Barcelona', 'price' => 2140)
        ),
        'city' => array(
            array('name' => 'Amsterdam', 'price' => 2140),
            array('name' => 'Rom', 'price' => 2140),
            array('name' => 'Los Angeles', 'price' => 2140),
            array('name' => 'Paris', 'price' => 2140)
        ),
        'family' => array(
            array('name' => 'Berlin', 'price' => 2140),
            array('name' => 'Orlando', 'price' => 2140),
            array('name' => 'Köpenhamn', 'price' => 2140),
            array('name' => 'Wien', 'price' => 2140)
        ),
        'romantic' => array(
            array('name' => 'Nice', 'price' => 2140),
            array('name' => 'Lissabon', 'price' => 2140),
            array('name' => 'Florens', 'price' => 2140),
            array('name' => 'Venedig', 'price' => 2140)
        ),
    );
?>

<div class="slider-container margin-bottom">
    <ul class="view-scope-type">
        <li class="active"><a href="#most-popular-view" data-toggle="tab">MEST POPULÄRA</a></li>
        <li><a href="#sun-bath-view" data-toggle="tab">SOL OCH BAD</a></li>
        <li><a href="#shopping-view" data-toggle="tab">SHOPPING</a></li>
        <li><a href="#city-view" data-toggle="tab">STORSTAD</a></li>
        <li><a href="#family-view" data-toggle="tab">FAMILJEVÄNLIGT</a></li>
        <li><a href="#romance-view" data-toggle="tab">ROMANTIK</a></li>
    </ul>

    <div class="tab-content view-scope-content">
        <div class="tab-pane fade in active" id="most-popular-view">
            @include('flight.index.slider.popular', array('locations' => $locationGroup['popular']))
        </div>
        <div class="tab-pane fade in" id="sun-bath-view">
            @include('flight.index.slider.popular', array('locations' => $locationGroup['sun']))
        </div>
        <div class="tab-pane fade in" id="shopping-view">
            @include('flight.index.slider.popular', array('locations' => $locationGroup['shopping']))
        </div>
        <div class="tab-pane fade in" id="city-view">
            @include('flight.index.slider.popular', array('locations' => $locationGroup['city']))
        </div>
        <div class="tab-pane fade in" id="family-view">
            @include('flight.index.slider.popular', array('locations' => $locationGroup['family']))
        </div>
        <div class="tab-pane fade in" id="romance-view">
            @include('flight.index.slider.popular', array('locations' => $locationGroup['romantic']))
        </div>
    </div>
</div>