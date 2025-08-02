<script>
    const get_race = {
        "async": true,
        "crossDomain": true,
        "url": "https://api-formula-1.p.rapidapi.com/races?competition=1&season=2023",
        "method": "GET",
        "headers": {
            "x-rapidapi-host": "api-formula-1.p.rapidapi.com",
            "x-rapidapi-key": "4274329b66msh81b9ec238ff6156p10407djsn73fa00a38654"
        }
    };
    let race_id;
    $.ajax(get_race).done(function(response) {
        for (var i = 0; i < response.response.length; i++) {
            var race_type = response.response[i].type;
            if (race_type.toLowerCase() == 'race') {
                race_id = response.response[i].id;
                competition_name = response.response[i].competition.name;
                $('#competition_name').text(competition_name)
            }
        }

        const race_rankings = {
            "async": true,
            "crossDomain": true,
            "url": "https://api-formula-1.p.rapidapi.com/rankings/races?race=" + race_id,
            "method": "GET",
            "headers": {
                "x-rapidapi-host": "api-formula-1.p.rapidapi.com",
                "x-rapidapi-key": "4274329b66msh81b9ec238ff6156p10407djsn73fa00a38654"
            }
        };
        $.ajax(race_rankings).done(function(response) {
            rankings = response.response;
            //console.log(rankings)

            if (rankings.length == 0) {
                output_standings =
                    '<tbody>' +
                    '<tr>' +
                    '<td colspan="5" class="align-middle text-center" style="color: rgb(17, 17, 17);">Coming Soon</td>' +
                    '</tr>' +
                    '</tbody>';
                $('#standing_table').html(output_standings);
            } else {
                standing_table = '<thead>' +
                    '<tr class="">' +
                    '<th class="px-3" style="color: #91288f">Position</th>' +
                    '<th class="px-3" style="color: #91288f" colspan=2>Driver</th>' +
                    '<th class="px-3" style="color: #91288f">Team</th>' +
                    '<th class="px-3" style="color: #91288f">Time</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody id="standings">' +
                    '</tbody>';
                // $('#standings').css('font-family', 'Roboto');
                $('#standing_table').html(standing_table);
                for (i = 0; i < 20; i++) {

                    position = rankings[i].position;
                    driver_name = rankings[i].driver.name;
                    // console.log(driver_name)
                    driver_image = rankings[i].driver.image;
                    if (driver_name == 'Yuki Tsunoda') {
                        driver_image = "{{asset('images/1617101457751.jpg')}}";
                    } else if (driver_name == 'Sergio Perez') {
                        driver_image = "{{asset('images/Sergio_Pérez.jpg')}}";
                    } else if (driver_name == 'Nicholas Latifi') {
                        driver_image = "{{asset('images/Nicholas Latifi.jpg')}}";
                    } else if (driver_name == 'Mick Schumacher') {
                        driver_image = "{{asset('images/Mick-Schumacher.jpg')}}";
                    } else if (driver_name == 'Nikita Mazepin') {
                        driver_image = "{{asset('images/Nikita Mazepin.jpg')}}";
                    }
                    team_name = rankings[i].team.name;

                    time = rankings[i].time == null ? 'Scheduled' : rankings[i].time;
                    output_standings =

                        '<tr>' +
                        '<td class="align-middle" style="color: rgb(17, 17, 17);">' + position + '</td>' +
                        '<td class="align-middle" class="align-middle" style="color: rgb(17, 17, 17);">' +
                        '<img src="' + driver_image + '" alt="" width="40px" />' +
                        '</td>' +
                        '<td class="align-middle" style="color: rgb(17, 17, 17);">' + driver_name + '</td>' +
                        '<td class="align-middle" style="color: rgb(17, 17, 17);">' + team_name + '</td>' +
                        '<td class="align-middle" style="color: rgb(17, 17, 17);">' + time + '</td>' +
                        '</tr>';

                    // console.log(output_standings);
                    $('#standings').append(output_standings);
                }
            }
        });
    });
</script>
