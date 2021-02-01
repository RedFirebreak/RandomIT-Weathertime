<?php require "./pages/header.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="src/js/node_modules/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="src/js/node_modules/chart.js/dist/Chart.js"></script>
    <title>Test Chart</title>
</head>

<body>
    <style>
        table {
            border-collapse: collapse;
            border: 5px solid black;
        }

        th {
            border: 5px solid black;
        }

        td {
            border: 2.5px solid black;
        }
    </style>


    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Temperature</th>
            <th>DewPoint</th>
            <th>StationLevelPressure</th>
            <th>SeaLevelPressure</th>
            <th>Visibility</th>
            <th>WindSpeed</th>
            <th>Percipitation</th>
            <th>SnowDrop</th>
            <th>Freeze</th>
            <th>Rain</th>
            <th>Snow</th>
            <th>Hail</th>
            <th>Thunder</th>
            <th>Tornado</th>
            <th>CloudCoverage</th>
            <th>WindDirection</th>
        </tr>

        <tbody id="myTable">

        </tbody>
    </table>

    <script>
        window.onload = function() {
            console.log("LOADED");

            var updateInterval = 1000;
            var table = document.getElementById('myTable')


            function addData(data) {
                if (data) {
                    var station = data['Station'];
                    var date = data['Date'];
                    var time = data['Time'];
                    var temperature = data['Temperature'];
                    var dewPoint = data['DewPoint'];
                    var stationLevelPressure = data['StationLevelPressure'];
                    var seaLevelPressure = data['SeaLevelPressure'];
                    var visibility = data['Visibility'];
                    var windSpeed = data['WindSpeed'];
                    var percipitation = data['Percipitation'];
                    var snowDrop = data['SnowDrop'];
                    var freeze = data['Freeze'];
                    var rain = data['Rain'];
                    var snow = data['Snow'];
                    var hail = data['Hail'];
                    var thunder = data['Thunder'];
                    var tornado = data['Tornado'];
                    var cloudCoverage = data['CloudCoverage'];
                    var windDirection = data['WindDirection'];

                    var i;
                    table.innerHTML = '';
                    for (i = time.length - 1; i > -1; i--) {
                        var row = `<tr>
                                    <td>${date[i]}</td>
                                    <td>${time[i]}</td>
                                    <td>${temperature[i]}</td>
                                    <td>${dewPoint[i]}</td>
                                    <td>${stationLevelPressure[i]}</td>
                                    <td>${seaLevelPressure[i]}</td>
                                    <td>${visibility[i]}</td>
                                    <td>${windSpeed[i]}</td>
                                    <td>${percipitation[i]}</td>
                                    <td>${snowDrop[i]}</td>
                                    <td>${freeze[i]}</td>
                                    <td>${rain[i]}</td>
                                    <td>${snow[i]}</td>
                                    <td>${hail[i]}</td>
                                    <td>${thunder[i]}</td>
                                    <td>${tornado[i]}</td>
                                    <td>${cloudCoverage[i]}</td>
                                    <td>${windDirection[i]}</td>
                            </tr>`
                        if (!row.includes("undefined")) {
                            table.innerHTML += row;
                        }
                    }
                }
            }

            function updateData() {
                console.log("Update Data");
                $.getJSON("data.php", addData);
                setTimeout(updateData, updateInterval);
            }

            updateData();
        }
    </script>
</body>

</html>