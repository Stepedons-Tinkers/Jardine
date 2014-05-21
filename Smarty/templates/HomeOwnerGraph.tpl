<table border=0 cellspacing=0 cellpadding=0 width=100% align=center>
	<tr>
		<td class="dvInnerHeader">
			<b>Graph</b>
		</td>
	</tr>
	<tr>
		<td class="dvtCellInfo" >
        <script src="include/amcharts/amcharts/amcharts.js" type="text/javascript"></script>    
        <script type="text/javascript">
            var chart;

            var chartData = [{ldelim}
                year: 2000,
                cars: 1587,
                motorcycles: 650,
                bicycles: 121
            {rdelim}, {ldelim}
                year: 1995,
                cars: 1567,
                motorcycles: 683,
                bicycles: 146
            {rdelim}, {ldelim}
                year: 1996,
                cars: 1617,
                motorcycles: 691,
                bicycles: 138
            {rdelim}, {ldelim}
                year: 1997,
                cars: 1630,
                motorcycles: 642,
                bicycles: 127
            {rdelim}, {ldelim}
                year: 1998,
                cars: 1660,
                motorcycles: 699,
                bicycles: 105
            {rdelim}];

            AmCharts.ready(function () {ldelim}
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.pathToImages = "include/amcharts/amcharts/images/";
                chart.zoomOutButton = {ldelim}
                    backgroundColor: "#000000",
                    backgroundAlpha: 0.15
                {rdelim};
                chart.dataProvider = chartData;
                chart.categoryField = "year";

                chart.addTitle("Monthly Dues Per Year", 15);

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 0.07;
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.startOnAxis = true;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "percent"; // this line makes the chart "stacked"
                valueAxis.stackType = "100%";
                valueAxis.gridAlpha = 0.07;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph
                var graph = new AmCharts.AmGraph();
                graph.type = "line"; // it's simple line graph
                graph.title = "Bills";
                graph.valueField = "cars";
                graph.balloonText = "[[value]] ([[percents]]%)";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.6; // setting fillAlphas to > 0 value makes it area graph 
                chart.addGraph(graph);

                // second graph
                var graph = new AmCharts.AmGraph();
                graph.type = "line";
                graph.title = "Payments";
                graph.valueField = "motorcycles";
                graph.balloonText = "[[value]] ([[percents]]%)";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.6;
                chart.addGraph(graph);

                // third graph
                var graph = new AmCharts.AmGraph();
                graph.type = "line";
                graph.title = "Aging";
                graph.valueField = "bicycles";
                graph.balloonText = "[[value]] ([[percents]]%)";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.6;
                chart.addGraph(graph);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                legend.align = "center";
                chart.addLegend(legend);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.zoomable = false; // as the chart displayes not too many values, we disabled zooming
                chartCursor.cursorAlpha = 0;
                chart.addChartCursor(chartCursor);

                // WRITE
                chart.write("chartdiv");
            {rdelim});
        </script>

        <div id="chartdiv" style="width:100%; height:400px;"></div>
		</td>
	</tr>

</table>