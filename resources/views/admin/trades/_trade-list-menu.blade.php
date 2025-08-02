<select id="trades" class="form-control col-xl-3 col-12">
    <option value="/trades" {{ Route::current()->getName() == 'trades.index' ? 'selected' : '' }}>Football Trades
    </option>
    <option value="/moto-trades" {{ Route::current()->getName() == 'moto-trades.index' ? 'selected' : '' }}>Motorsport
        Trades
    </option>
    <option value="/nrl-trades" {{ Route::current()->getName() == 'nrl-trades.index' ? 'selected' : '' }}>Rugby Trades
    </option>
    <option value="/nfl-trades" {{ Route::current()->getName() == 'nfl-trades.index' ? 'selected' : '' }}>NFL Trades
    </option>
    <option value="/nba-trades" {{ Route::current()->getName() == 'nba-trades.index' ? 'selected' : '' }}>NBA Trades
    </option>
    <option value="/table-tennis-trades"
        {{ Route::current()->getName() == 'table-tennis-trades.index' ? 'selected' : '' }}>Table Tennis Trades
    </option>
    <option value="/tennis-trades" {{ Route::current()->getName() == 'tennis-trades.index' ? 'selected' : '' }}>
        Tennis Trades
    </option>
    {{-- <option value="/ufc-trades" {{Route::current()->getName()=='ufc-trades.index'?'selected':''}}>UFC Trades</option> --}}
    {{-- <option value="/football-markets/laliga" {{Route::current()->getName()=='LaLiga'?'selected':''}}>La Liga</option> --}}
</select>
