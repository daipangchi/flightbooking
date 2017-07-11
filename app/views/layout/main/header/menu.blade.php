<ul class="nav navbar-nav navbar-left">
    <li>
        <a href="#"><i class="fa fa-home"></i> HEM</a>
    </li>
    <li class="dropdown mega">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-map-marker"></i> Populära resmål <i class="fa fa-caret-down"></i></a>
        <div class="dropdown-menu mega-menu">
            @foreach($popularDestinations as $row)
                <ul class="destinations-list clearfix">
                    @foreach($row as $letter => $items)
                    <li class="left letter-holder links">
                        <h5>{{ $letter }}</h5>
                        <ul>
                            @foreach($items as $item)
                            <li><a href="{{ internal_link_from_slug($item->slug) }}">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
        <div class="clearfix"></div>
    </li>
    <li class="dropdown mega">
        <a href="{{ internal_link_from_url(route('page.omoss')) }}"><i class="fa fa-envelope"></i> Om oss</a>
    </li>
</ul>