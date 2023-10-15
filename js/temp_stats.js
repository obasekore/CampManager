// JavaScript Document
// Morris Bar Chart
Morris.Bar({
    element: 'hero-bar',
    data: [
        {device: '1', sells: 136},
        {device: '3G', sells: 1037},
        {device: '3GS', sells: 275},
        {device: '4', sells: 380},
        {device: '4S', sells: 655},
        {device: '5', sells: 1571}
    ],
    xkey: 'device',
    ykeys: ['sells'],
    labels: ['Sells'],
    barRatio: 0.4,
    xLabelMargin: 10,
    hideHover: 'auto',
    barColors: ["#3d88ba"]
});



// Morris Donut Chart
/*Morris.Donut({
    element: 'hero-donut2',
    data: [
        {label: 'Google', value: 25 },
        {label: 'Yahoo', value: 40 },
        {label: 'Bing', value: 25 },
        {label: 'Yandex', value: 10 }
    ],
    colors: ["#30a1ec", "#76bdee", "#c4dafe"],
    formatter: function (y) { return y + "%" }
});
*/