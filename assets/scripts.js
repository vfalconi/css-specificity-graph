d3.json('./analyze-css.php?included=false', function (error, data) {

	var chart = d3.select('.chart'),
	width = 1000,
	height= 500,
	margins = {
		top: 20,
		right: 20,
		bottom: 20,
		left: 50
	},
	xRange = d3.scale.linear()
		.range([margins.left, width - margins.right])
		.domain([d3.min(data, function (d) { return d.position; }), d3.max(data, function (d) { return d.position; })]),
	yRange = d3.scale.linear()
		.range([height - margins.top, margins.bottom])
		.domain([d3.min(data, function (d) { return d.specificity; }), d3.max(data, function (d) { return d.specificity; })]),
	xAxis = d3.svg.axis()
		.scale(xRange)
		.tickSize(5)
		.tickSubdivide(true),
	yAxis = d3.svg.axis()
		.scale(yRange)
		.tickSize(5)
		.orient('left')
		.tickSubdivide(true);

	chart.attr('width', width)
		.attr('height', height)
		.append('svg:g')
		.attr('class', 'x axis')
		.attr('transform', 'translate(0,' + (height - margins.bottom) + ')')
		.call(xAxis);

	chart.append('svg:g')
		.attr('class', 'y axis')
		.attr('transform', 'translate(' + margins.left + ', 0)')
		.call(yAxis);

	var lineFunc = d3.svg.line()
		.x(function(d) { return xRange(d.position); })
		.y(function(d) { return yRange(d.specificity); })
		.interpolate('linear');

	chart.append('svg:path')
		.attr('d', lineFunc(data))
		.attr('stroke', 'steelblue')
		.attr('stroke-width', 2)
		.attr('fill', 'none');
});