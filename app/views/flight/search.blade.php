@extends('layout.flight')

@section('body')
    <div style="min-height:200px;">

    </div>
@stop

@section('additional-foot-blocks')
    @include('flight.search.progressbar')
    @include('flight.search.additional')
@stop

@section('custom-scripts')
<?php $canSearch = Input::has('departure_iata') && Input::has('destination_iata') && Input::has('departure_date'); ?>
<?php if($canSearch) { ?>

<script>
    var requestParameters = new Object();
    requestParameters.IATAFrom  = '<?php echo Input::get('departure_iata'); ?>';
    requestParameters.IATATo    = '<?php echo Input::get('destination_iata'); ?>';
    requestParameters.start     = '<?php echo mydate('Ymd', Input::get('departure_date')); ?>';
    requestParameters.end       = '<?php echo mydate('Ymd', Input::get('return_date')); ?>';
    requestParameters.numAdults = '<?php echo Input::get('adult_num'); ?>';
    requestParameters.sortOption= '<?php echo get_sort_option(Input::has('sort_by')); ?>';
    requestParameters.oneWay    = '<?php echo Input::get('one_way'); ?>';

    requestParameters.children = [];
    <?php if(Input::has('child_num')) {
        for($i=1; $i<=Input::get('child_num'); $i++) {
            $age = Input::has('child-age-'.$i) ? Input::get('child-age-'.$i) : 8; ?>
            requestParameters.children.push(<?php echo $age; ?>);
        <?php
        }
    } ?>
    FLIGHT.search(requestParameters);
</script>

<?php } ?>
@stop