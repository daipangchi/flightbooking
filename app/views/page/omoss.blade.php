@extends('layout.flight')

@section('title')
<title>Om oss, kontaktuppgifter - {{ DOMAIN_NAME }}</title>
@stop

@section('body')
    <div class="inner">
        <article class="entry">

            <header class="header"><h1>Om oss</h1></header>

            <p>
                Vi på flygresor.com tycker inte att man skall betala mer än man behöver. Därför samlar vi alla ledande flygbolags olika kampanjer och presenterar dom på sajten.
                Allt för att du som konsument skall komma undan så billigt som möjligt när det gäller pris på flygresorna. Du kan också söka fram de billigaste sista minuten flygen på sajten.
            </p>
            <p>Bakom Flygresor.com står bolaget Westcoast Digital AB som är ett webbutvecklingsföretag baserat i Trollhättan. Företaget driver även sajterna <a href="http://www.sistaminutenresor.com">www.sistaminutenresor.com</a> och <a href="http://www.allacharterresor.se">www.allacharterresor.se</a>.</p>
            
            <h2 class="zelta">Annonsera</h2>
            <p>
                Nå ut till våra ressugna besökare!<br/><br/>
                <a href="http://annonswebb.qualityunlimited.com/sv-se/brands/flygresor-com-1693" target="_blank">Läs mer på våran annonswebb</a>.
            </p>

            <h2 class="zelta">Kontaktuppgifter</h2>
            <p>
                Westcoast Digital AB<br/>
                Strandgatan 28<br/>
                461 30 Trollhättan<br/>
                0520-14000<br/>
                <a href="mailto:info@wd.se">info@wd.se</a><br/>
                <a href="http://www.wd.se/">www.wd.se</a>
            </p>

            <p>Det går också bra att kontakta oss via e-post: <a href="mailto:info@flygresor.com">info@flygresor.com</a></p>

        </article>
    </div>
@stop

@section('additional-foot-blocks')
    @include('flight.search.additional')
@stop