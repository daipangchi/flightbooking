<div class="form-gp">
    <label>Resenärer</label>
    <div class="input-group input-group-t margin-bottom-sm passengers">
        <div>
            <input type="text" name="adult_num" class="form-control adult_num" required value="{{ Input::has('adult_num') ? Input::get('adult_num') : '1' }}" readonly="readonly">
            <span><span id="adult_span">vuxna</span>, </span>
            <input type="text" name="child_num" class="form-control child_num" required value="{{ Input::has('child_num') ? Input::get('child_num') : '0' }}" readonly="readonly">
            <span>barn</span>
        </div>

        <div class="passengers_drop">
            <div class="passengers_item title">Välj resenärer</div>

            <!-- ITEM -->
            <div class="passengers_item passengers_adults">
                <span class="passengers_name" data-text="Vuxen">Vuxna</span>
                <span class="passengers_control">
                    <span class="passengers_mp passengers_minus fa fa-minus"></span>
                    <input class="passengers_value_data" readonly="readonly" name="select-number-adults" autocomplate="off" value="{{ Input::has('adult_num') ? Input::get('adult_num') : '1' }}" type="hidden">
                    <span class="passengers_value">{{ Input::has('adult_num') ? Input::get('adult_num') : '1' }}</span>
                    <span class="passengers_mp passengers_plus fa fa-plus"></span>
                </span>
            </div>
            <hr/>
            <!-- END / ITEM -->

            <!-- ITEM -->
            <div class="passengers_item passengers_child">
                <span class="passengers_name" data-text="Child">Barn</span>
                <span class="passengers_control">
                    <span class="passengers_mp passengers_minus fa fa-minus"></span>
                    <input class="passengers_value_data" name="select-number-children" readonly="readonly" data-maxage="17" autocomplate="off" data-default="0" value="{{ Input::has('child_num') ? Input::get('child_num') : '0' }}" type="hidden">
                    <span class="passengers_value" data-maxage="17">{{ Input::has('child_num') ? Input::get('child_num') : '0' }}</span>
                    <span class="passengers_mp passengers_plus fa fa-plus"></span>
                </span>
            </div>
            <hr/>
            <!-- END / ITEM -->

            <div class="passengers_child-content">
                <?php if(Input::has('child_num')) { ?>
                <?php for($i=1; $i<=Input::get('child_num'); $i++) { ?>
                <?php $age = Input::has('child-age-'.$i) ? Input::get('child-age-'.$i) : 8; ?>
                <div class="passengers_item">
                    <span class="passengers_name" data-text="Child">Barnets ålder <?php echo $i; ?></span>
                        <span class="passengers_control">
                        <span class="passengers_mp passengers_minus fa fa-minus"></span>
                        <input class="passengers_value_data" name="child-age-<?php echo $i; ?>" readonly="readonly" data-maxage="17" autocomplate="off" data-default="0" value="<?php echo $age; ?>" type="hidden">
                        <span class="passengers_value" data-maxage="17"><?php echo $age; ?></span>
                        <span class="passengers_mp passengers_plus fa fa-plus"></span>
                    </span>
                </div>
                <?php } ?>
                <?php } ?>
            </div>

        </div>
    </div>
</div>