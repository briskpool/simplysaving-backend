<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Add Trade
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{ route('trades.create') }}">Football</a>
        <a class="dropdown-item" href="{{ route('moto-trades.create') }}">Motorsport</a>
        <a class="dropdown-item" href="{{ route('nrl-trades.create') }}">Rugby</a>
        <a class="dropdown-item" href="{{ route('nfl-trades.create') }}">NFL</a>
        <a class="dropdown-item" href="{{ route('nba-trades.create') }}">NBA</a>
        <a class="dropdown-item" href="{{ route('table-tennis-trades.create') }}">Table Tennis</a>
        <a class="dropdown-item" href="{{ route('tennis-trades.create') }}">Tennis</a>
        {{-- <a class="dropdown-item" href="{{route('ufc-trades.create')}}">UFC</a> --}}
    </div>
</div>
