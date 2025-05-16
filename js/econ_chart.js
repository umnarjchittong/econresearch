function genChartGauge(objId, chartTitle, dataValue, targetValue, barColor = "#1f8657") {
    // let chartTitle = "จำนวนเงินวิจัย งปม. 2565<br>(หน่วย:ล้านบาท)";
    // let objId = "myDiv";
    // let dataValue = 5.2;
    // let targetValue = 4;
    let chartValue = targetValue;
    if (dataValue > targetValue) {
        chartValue = dataValue;
    }
    var data = [{
        domain: {
            x: [0, 1],
            y: [0, 1]
        },
        align: "center",
        value: dataValue,
        // title: {
        //     text: chartTitle,
        //     font: {
        //         size: 15
        //     }
        // },
        type: "indicator",
        mode: "gauge+number",
        gauge: {
            axis: {
                range: [null, chartValue],
                tickwidth: 1,
                tickcolor: "darkblue"
            },
            bar: {
                color: barColor
            },
            bgcolor: "whith",
            borderwidth: 2,
            bordercolor: "gray",
            // steps: [{
            //     range: [0, 5],
            //     color: "yellow"
            // }, {
            //     range: [5, 8],
            //     color: "green"
            // }, {
            //     range: [8, 10],
            //     color: "blue"
            // }],
            threshold: {
                line: {
                    color: "red",
                    width: 4
                },
                thickness: 0.75,
                value: targetValue
            }
        }
    }];
    var layout = {
        height: 300,
        width: 250,
        // autosize: true,
        margin: {
            t: 0,
            b: 0,
            l: 32,
        }
    };
    Plotly.newPlot(objId, data, layout);
}