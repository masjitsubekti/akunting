// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
    datasets: [{
      label: "Pendapatan",
      backgroundColor: "rgba(255, 214, 67, 0.8)",
      borderColor: "rgba(255, 214, 67, 0.8)",
      data: [4215, 5312, 6251, 7841, 9821, 1234, 1242, 3453, 5467, 7654, 5457, 8654],
    },{
      label: "Laba Bersih",
      backgroundColor: "rgba(61, 209, 67, 1)",
      borderColor: "rgba(61, 209, 67, 1)",
      data: [4353, 5445, 6677, 3546, 2323, 5454, 2844, 5846, 3846, 5736, 3864, 3947],
    }
  ],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 10000,
          maxTicksLimit: 12
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
