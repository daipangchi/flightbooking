<?php

function locationTemplate($location, $color='orange-box') { ?>
    <div class="row">
        <div class="col-xs-8 location-image clear-padding-left">
            <a href="<?php echo internal_link_from_slug(name2slug($location['name'])); ?>"><img src="<?php echo asset('images/location/thumb/'.name2slug($location['name']).'.jpg'); ?>" alt="<?php echo $location['name']; ?>"/></a>
        </div>
        <div class="col-xs-4 location-info <?php echo $color; ?> clear-padding">
            <a href="<?php echo internal_link_from_slug(name2slug($location['name'])); ?>" class="read-more">
                <div class="location-info-sub">
                    <h6><?php echo $location['name']; ?></h6>
                    <span class="from">från</span>
                    <span class="price"><?php echo $location['price']; ?> <span class="currency">SEK</span></span>
                    <!--<a href="/<?php /*echo name2slug($location['name']); */?>" class="read-more">Läs mer</a>-->
                </div>
            </a>
        </div>
    </div>
    <?php
}

function locationTemplate2($location, $color='orange-box') { ?>
    <div class="row">
        <div class="col-xs-4 location-info <?php echo $color; ?> clear-padding">
            <a href="<?php echo internal_link_from_slug(name2slug($location['name'])); ?>" class="read-more">
                <div class="location-info-sub">
                    <h6><?php echo $location['name']; ?></h6>
                    <span class="from">från</span>
                    <span class="price"><?php echo $location['price']; ?> <span class="currency">SEK</span></span>
                    <!--<a href="/<?php /*echo name2slug($location['name']); */?>" class="read-more">Läs mer</a>-->
                </div>
            </a>
        </div>
        <div class="col-xs-8 location-image clear-padding-right">
            <a href="<?php echo internal_link_from_slug(name2slug($location['name'])); ?>"><img src="<?php echo asset('images/location/thumb/'.name2slug($location['name']).'.jpg'); ?>" alt="<?php echo $location['name']; ?>"/></a>
        </div>
    </div>
    <?php
}