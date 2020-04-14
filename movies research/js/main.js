/*
*    main.js
*    Mastering Data Visualization with D3.js
*    CoinStats
*/

var margin = { left:80, right:100, top:50, bottom:100 },
    height = 500 - margin.top - margin.bottom, 
    width = 800 - margin.left - margin.right;

var svg = d3.select("#chart-area").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom);

var g = svg.append("g")
    .attr("transform", "translate(" + margin.left + 
        ", " + margin.top + ")");

// Time parser for x-scale
var parseTime = d3.timeParse("%d/%m/%Y");
// For tooltip
var bisectDate = d3.bisector(function(d) { return d.date; }).left;

// Scales
var x = d3.scaleLinear().range([0, width]);
var y = d3.scaleLinear().range([height, 0]);

// Axis generators
var xAxisCall = d3.axisBottom().tickFormat(function(d){ return d+'-'+ (d+10);}).tickSize(10,0).tickSize(8);
var yAxisCall = d3.axisLeft()
    .ticks(6)
    .tickFormat(function(d) { return d; });

// Axis groups
var xAxis = g.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")");
var yAxis = g.append("g")
    .attr("class", "y axis")
    

var main = {};
console.log(word_data);

word_data.sort(function(a, b) {
    return a.year - b.year;
});

all_data.sort(function(a, b) {
    return a.year - b.year;
});


console.log(word_data);
console.log(all_data);


update(word_data,all_data);
// var word_data = JSON.parse(word_data);

function update(data,all_data){
    // data.forEach(function(d) {
    //     d.date = parseTime(d.date);
    //     d[reference] = +d[reference];
    //     console.log(d.date + d[reference]);
    // });

    // data = data.filter(point => (point[reference]!= null)); 

    // data.sort(function(a, b) {
    //     return a.year.localeCompare(b.year);
    // });


    g.selectAll("line").remove();

    // Set scale domains
    x.domain([d3.min(data, function(d) { return d.year; }),d3.max(data, function(d) { return d.year; })]);
    y.domain([0 , d3.max(data, function(d) { return d.val; })]);

    // Generate axes once scales have been set
    xAxis.call(xAxisCall.scale(x))
    yAxis.call(yAxisCall.scale(y))

    // Line path generator
    var line = d3.line()
        .curve(d3.curveBasis)
        .x(function(d) { return x(d.year); })
        .y(function(d) { return y(d.val); });

    // Add line to chart
    g.append("path")
        .attr("class", "line")
        .attr("fill", "none")
        .attr("stroke", "grey")
        .attr("stroke-with", "3px")
        .attr("d", line(data));

    // g.append("path")
    //     .attr("class", "line")
    //     .attr("fill", "none")
    //     .attr("stroke", "grey")
    //     .attr("stroke-with", "3px")
    //     .attr("d", line(all_data));

    /******************************** Tooltip Code ********************************/

    // var focus = g.append("g")
    //     .attr("class", "focus")
    //     .style("display", "none");

    // focus.append("line")
    //     .attr("class", "x-hover-line hover-line")
    //     .attr("y1", 0)
    //     .attr("y2", height);

    // focus.append("line")
    //     .attr("class", "y-hover-line hover-line")
    //     .attr("x1", 0)
    //     .attr("x2", width);

    // focus.append("circle")
    //     .attr("r", 7.5);

    // focus.append("text")
    //     .attr("x", 15)
    //     .attr("dy", ".31em");

    // g.append("rect")
    //     .attr("class", "overlay")
    //     .attr("width", width)
    //     .attr("height", height)
    //     .on("mouseover", function() { focus.style("display", null); })
    //     .on("mouseout", function() { focus.style("display", "none"); })
    //     .on("mousemove", mousemove);

    // function mousemove() {
    //     var x0 = x.invert(d3.mouse(this)[0]),
    //         i = bisectDate(data, x0, 1),
    //         d0 = data[i - 1],
    //         d1 = data[i],
    //         d = x0 - d0.year > d1.year - x0 ? d1 : d0;
    //     focus.attr("transform", "translate(" + x(d.date) + "," + y(d[reference]) + ")");
    //     focus.select("text").text(d[reference]);
    //     focus.select(".x-hover-line").attr("y2", height - y(d[reference]));
    //     focus.select(".y-hover-line").attr("x2", -x(d.date));
    // }


    /******************************** Tooltip Code ********************************/

}

