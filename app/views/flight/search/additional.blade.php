<div>
    <input type="hidden" id="txt_Adult" value="Vuxen" />
    <input type="hidden" id="txt_Adults" value="Vuxna" />
    <input type="hidden" id="txt_Child" value="Barn" />
    <input type="hidden" id="txt_Children" value="Barn" />
    <input type="hidden" id="txt_AgeOfChild" value="Barnets ålder" />
</div>

<ul id="suggestion-departure-cities" class="suggestion-cities ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" style="display:none;">
    <li><h5>Förslag på avreseorter</h5></li>
    @foreach($suggestionDepartureCities as $item)
        <?php
            $attrStr = '';
            foreach($item as $key => $value) {
                $attrStr .= ' data-' . strtolower($key) . '="' . $value . '"';
            }
        ?>
        <li class="ui-menu-item" {{ $attrStr }}>
            <h6>{{ $item['ui_display_name'] }} ({{ $item['IATA'] }})</h6>
        </li>
    @endforeach
</ul>

@if(!isset($destinationCity))
<ul id="suggestion-destination-cities" class="suggestion-cities ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" style="display:none;">
    <li><h5>Förslag på destinationer</h5></li>
    @foreach($suggestionDestinationCities as $item)
        <?php
        $attrStr = '';
        foreach($item as $key => $value) {
            $attrStr .= ' data-' . strtolower($key) . '="' . $value . '"';
        }
        ?>
        <li class="ui-menu-item" {{ $attrStr }}>
            <h6>{{ $item['ui_display_name'] }} ({{ $item['IATA'] }})</h6>
        </li>
    @endforeach
</ul>
@endif