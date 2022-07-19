// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
    datasets: [{
      label: "Asset",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.5)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [1212, 4343, 5453, 2345, 5857, 3744, 7353, 7920, 2343, 8375, 5745, 4758],
    },{
      label: "Liabilitas",
      lineTension: 0.3,
      backgroundColor: "rgba(255, 21, 67, 0.5)",
      borderColor: "rgba(255, 21, 67, 1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(255, 21, 67, 0.8)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(255, 21, 67, 1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [3483, 6463, 4559, 5454, 4334, 4348, 4595, 3056, 9544, 3943, 3943, 3943],
    },{
      label: "Ekuitas",
      lineTension: 0.3,
      backgroundColor: "rgba(61, 209, 67, 0.5)",
      borderColor: "rgba(61, 209, 67, 1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(61, 209, 67, 1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(61, 209, 67, 1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [4294, 4545, 6595, 5605, 4854, 8543, 5945, 3954, 5454, 5963, 9568, 3483],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 10000,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
