<div class="row location-list">
    <div class="col-sm-6 location-box clear-padding-left xs-clear-padding-right xs-margin-bottom">
        {{ locationTemplate($locations[0], 'blue-box') }}
    </div>
    <div class="col-sm-6 location-box clear-padding-right xs-clear-padding-left">
        {{ locationTemplate($locations[1]) }}
    </div>
</div>
<div class="row location-list">
    <div class="col-sm-6 location-box clear-padding-left xs-clear-padding-left xs-clear-padding-right xs-margin-bottom">
        {{ locationTemplate2($locations[2]) }}
    </div>
    <div class="col-sm-6 location-box clear-padding-right xs-clear-padding-left">
        {{ locationTemplate2($locations[3], 'red-box') }}
    </div>
</div>