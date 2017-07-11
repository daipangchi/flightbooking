<!-- START: SORT AREA -->
<div class="sort-area col-md-12 clearfix">
    <div class="col-xs-4 sort cheapest-option <?php echo (!Input::has('sortOption') || Input::get('sortOption') == 'price') ? 'selected' : ''; ?>" data-sort="price">
        <div class="sort-area-title">Billigast</div>
        <div class="sort-area-price">{{ format_price($tripResult->CheapestPrice, 'SEK') }}</div>
        <div class="sort-area-time">{{ hour2timerange($tripResult->CheapestAvgTime) }}</div>
    </div>
    <div class="col-xs-4 sort fastest-option <?php echo (Input::get('sortOption') == 'time') ? 'selected' : ''; ?>" data-sort="time">
        <div class="sort-area-title">Snabbast</div>
        <div class="sort-area-price">{{ format_price($tripResult->QuickestPrice, 'SEK') }}</div>
        <div class="sort-area-time">{{ hour2timerange($tripResult->QuickestAvgTime) }}</div>
    </div>
    <div class="col-xs-4 sort best-option <?php echo (Input::get('sortOption') == 'best') ? 'selected' : ''; ?>" data-sort="best">
        <div class="sort-area-title">Bästa Valet</div>
        <div class="sort-area-price">{{ format_price($tripResult->BestPrice, 'SEK') }}</div>
        <div class="sort-area-time">{{ hour2timerange($tripResult->BestAvgTime) }}</div>
    </div>
</div>
<!-- END: SORT AREA -->
<div class="clearfix"></div>