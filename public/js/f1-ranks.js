
    const get_race = {
            "async": true,
            "crossDomain": true,
            "url": "https://api-formula-1.p.rapidapi.com/races?competition=1&season=2022",
            "method": "GET",
            "headers": {
                "x-rapidapi-host": "api-formula-1.p.rapidapi.com",
                "x-rapidapi-key": "5a064d629amsh0e00769af305bdap180755jsnb03e3a7f19f0"
            }
        };
        let race_id;
        $.ajax(get_race).done(function(response) {
            for (var i = 0; i < response.response.length; i++) {
                var race_type = response.response[i].type;
                if (race_type.toLowerCase() == 'race') {
                    race_id = response.response[i].id;
                }
            }
            const race_rankings = {
                "async": true,
                "crossDomain": true,
                "url": "https://api-formula-1.p.rapidapi.com/rankings/races?race=" + race_id,
                "method": "GET",
                "headers": {
                    "x-rapidapi-host": "api-formula-1.p.rapidapi.com",
                    "x-rapidapi-key": "5a064d629amsh0e00769af305bdap180755jsnb03e3a7f19f0"
                }
            };

            $.ajax(race_rankings).done(function(response) {
                rankings = response.response;
                // console.log(rankings)
                standing_table = '<thead>'+
                        '<tr class="">'+
                            '<th class="px-3" style="color: #91288f">Position</th>'+
                            '<th class="px-3" style="color: #91288f">Driver</th>'+
                            '<th class="px-3" style="color: #91288f">Team</th>'+
                            '<th class="px-3" style="color: #91288f">Time</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody id="standings">'+

                    '</tbody>';

                    $('#standing_table').html(standing_table);

             for (i = 0; i < rankings.length; i++) {
                
                position = rankings[i].position;
                driver_name = rankings[i].driver.name;
                // driver_image = rankings[i].driver.image;
                team_name = rankings[i].team.name;
                time = rankings[i].time == null ? '-':rankings[i].time;
                const driver_image = {
                    "async": true,
                    "crossDomain": true,
                    "url": "/get-driver-images/" + driver_name,
                    "method": "GET",
                    "headers": {
                        "x-rapidapi-host": "api-formula-1.p.rapidapi.com",
                        "x-rapidapi-key": "5a064d629amsh0e00769af305bdap180755jsnb03e3a7f19f0"
                    }
                };
                $.ajax(driver_image).done(function(response) {
                    console.log(response)
                });
                

                
                output_standings =
                   
                     '<tr>'+
                    '<td class="align-middle" style="color: rgb(17, 17, 17);">'+position+'</td>'+
                    // '<td class="align-middle" class="align-middle" style="color: rgb(17, 17, 17);">'+
                    // '<img src="'+driver_image+'" alt="" width="40px" />'+
                    // '</td>'+
                    '<td class="align-middle" style="color: rgb(17, 17, 17);">'+driver_name+'</td>'+
                    '<td class="align-middle" style="color: rgb(17, 17, 17);">'+team_name+'</td>'+
                    '<td class="align-middle" style="color: rgb(17, 17, 17);">'+time+'</td>'+                  
                '</tr>';
                $('#standings').append(output_standings);
             }

            });
        });
    
            
