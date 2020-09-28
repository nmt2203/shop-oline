<style>
    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.primary {
        background-color: #007bff;
        color: #FFF;
    }

    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
    }

    .card-counter.success {
        background-color: #66bb6a;
        color: #FFF;
    }

    .card-counter.info {
        background-color: #26c6da;
        color: #FFF;
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 32px;
        display: block;
    }

    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 65px;
        font-style: italic;
        text-transform: capitalize;
        opacity: 0.5;
        display: block;
        font-size: 18px;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {

        var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');

        var data = google.visualization.arrayToDataTable([
            ['Report chart for year <?php $current_year = $this->data["year"];echo $current_year; ?>', 'Sales', 'Orders'],
            <?php
            foreach ($this->data["report_chart"] as $item) {
                foreach ($item as $id => $value) {
                    $column = $id . "/" . $current_year;
                    echo "['" . $column . "'," . $value["sales"] . "," . $value["orders"] . "],";
                }
            }
            ?>
        ]);

        var materialOptions = {
            width: 900,
            chart: {
                title: 'Sales & Revenue',
                // subtitle: 'distance on the left, brightness on the right'
            },
            series: {
                0: {
                    axis: 'Sales'
                }, // Bind series 0 to an axis named 'distance'.
                1: {
                    axis: 'Orders'
                } // Bind series 1 to an axis named 'brightness'.
            },
            axes: {
                y: {
                    Sales: {
                        label: 'Money'
                    }, // Left y-axis.
                    Orders: {
                        side: 'right',
                        label: 'Orders'
                    } // Right y-axis.
                }
            }
        };

        var classicOptions = {
            width: 900,
            series: {
                0: {
                    targetAxisIndex: 0
                },
                1: {
                    targetAxisIndex: 1
                }
            },
            title: 'Report chart for year <?php echo $current_year; ?>',
            vAxes: {
                // Adds titles to each axis.
                0: {
                    title: 'money'
                },
                1: {
                    title: 'orders'
                }
            }
        };

        function drawMaterialChart() {
            var materialChart = new google.charts.Bar(chartDiv);
            materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
            button.innerText = 'Change to Classic';
            button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
            var classicChart = new google.visualization.ColumnChart(chartDiv);
            classicChart.draw(data, classicOptions);
            button.innerText = 'Change to Material';
            button.onclick = drawMaterialChart;
        }

        drawMaterialChart();
    };
</script>
<div class="panel">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card-counter primary">
                    <a style="color: white;font-size : 30px; " href="/DoAnTH02/Admin/book/index/">
                        <span class="glyphicon glyphicon-book"></span>
                        <span class="count-numbers"><?php echo count($this->data["books"]); ?></span>
                        <span class="count-name">Books</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card-counter danger">
                    <a style="color: white;font-size : 30px;" href="/DoAnTH02/Admin/news/index/">
                        <span class="glyphicon glyphicon-comment"></span>
                        <span class="count-numbers"><?php echo count($this->data["news"]); ?></span>
                        <span class="count-name">News</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card-counter success">
                    <a style="color: white;font-size : 30px;" href="/DoAnTH02/Admin/comment/index/">
                        <span class="glyphicon glyphicon-envelope"></span>
                        <span class="count-numbers"><?php echo count($this->data["comments"]); ?></span>
                        <span class="count-name">Feedback</span>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card-counter info">
                    <a style="color: white;font-size : 30px;" href="/DoAnTH02/Admin/order/index/">
                        <span class="glyphicon glyphicon-gift"></span>
                        <span class="count-numbers"><?php echo count($this->data["orders"]); ?></span>
                        <span class="count-name">Orders</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <!-- <div class="container"> -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <form method="POST" class="form-horizontal navbar-form" enctype="multipart/form-data" action="/DoAnTH02/Admin/index/">
                    <div class="form-group ">
                        <input type="number" class="form-control" name="search_year" placeholder="Search year">
                        <button type="submit" name="year" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        <a class="btn-default btn" href="/DoAnTH02/Admin/index/"><span class="glyphicon glyphicon-refresh"></span></a>
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <div id="chart_div" style="width: 800px; height: 500px;"></div>
                <button id="change-chart" class="btn btn-primary">Change to Classic</button>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>
</div>