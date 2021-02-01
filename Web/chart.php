<?php //require('data.php'); 
?>
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
    <div class="container">
        <canvas id="Temperature"></canvas>
    </div>
    <div class="container">
        <canvas id="WindSpeed"></canvas>
    </div>
    <div class="container">
        <canvas id="DewPoint"></canvas>
    </div>
    <script>
        window.onload = function() {
            console.log("LOADED");

            var updateInterval = 1000;
            var numberElements = 10;
            var updateCount = 0;

            var temperature = document.getElementById('Temperature').getContext('2d');
            var wind = document.getElementById('WindSpeed').getContext('2d');
            var dew = document.getElementById('DewPoint').getContext('2d');

            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#000';

            var tempChart = new Chart(temperature, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        fill: false,
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 3,
                        borderColor: '#000',
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Temperature',
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 500,
                            bottom: 0,
                            top: 0
                        }
                    }
                }
            });
            var windChart = new Chart(wind, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        fill: false,
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 3,
                        borderColor: '#000',
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'WindSpeed',
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 500,
                            bottom: 0,
                            top: 0
                        }
                    }
                }
            });
            var dewChart = new Chart(dew, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        fill: false,
                        backgroundColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 3,
                        borderColor: '#000',
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'DewPoint',
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 500,
                            bottom: 0,
                            top: 0
                        }
                    }
                }
            });

            function addData(data) {
                if (data) {
                    tempChart.data.labels = data['Time'];
                    tempChart.data.datasets[0].data = data['Temperature'];
                    windChart.data.labels = data['Time'];
                    windChart.data.datasets[0].data = data['WindSpeed'];
                    dewChart.data.labels = data['Time'];
                    dewChart.data.datasets[0].data = data['DewPoint'];
                    //weatherChart.data.datasets[3].data = data['SeaLevelPressure'];
                    //weatherChart.data.datasets[4].data = data['Windspeed'];
                    //updateCount++
                }
                if (updateCount > numberElements) {
                    //weatherChart.data.labels.shift();
                    //weatherChart.data.datasets[0].data.shift();
                }
                tempChart.update();
                windChart.update();
                dewChart.update();
            }

            function updateData() {
                console.log("Update Data");
                //console.log($.getJSON("test.json"));
                //console.log($.getJSON("data.php"));
                $.getJSON("data.php", addData);
                setTimeout(updateData, updateInterval);
            }

            updateData();
        }
    </script>
</body>

</html>