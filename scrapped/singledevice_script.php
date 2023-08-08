 
  //TODO:sort station and throughput based on snmp walk response json array
  
  //   // Assuming throughputData is the variable containing the data from element0
//   // WLAN0 Chart
//   new Chart(document.querySelector('#wlan0Chart'), {
//     type: 'line',
//     data: {
//       labels: [],
//       datasets: [
//         {
//           label: 'WLAN0 RX',
//           data: throughputData['throughput WLAN0 RX'],
//           fill: false,
//           borderColor: 'rgb(75, 192, 192)',
//           tension: 0.1
//     },
//         {
//           label: 'WLAN0 TX',
//           data: throughputData['throughput WLAN0 TX'],
//           fill: false,
//           borderColor: 'rgb(192, 75, 192)',
//           tension: 0.1
//     }
//   ]
//     },
//     options: {
//       scales: {
//         y: {
//           beginAtZero: true,
//           suggestedMax: Math.max(...throughputData['throughput WLAN0 RX'], ...throughputData['throughput WLAN0 TX']),
//           ticks: {
//             callback: function (value, index, values) {
//               return formatDataSize(value); // Call a function to format the data size dynamically
//             }
//           }
//         }
//       }
//     }
//   });
//   // LAN0 Chart
//   new Chart(document.querySelector('#lan0Chart'), {
//     type: 'line',
//     data: {
//       labels: [],
//       datasets: [
//         {
//           label: 'LAN0 RX',
//           data: throughputData['throughput LAN0 RX'],
//           fill: false,
//           borderColor: 'rgb(75, 192, 75)',
//           tension: 0.1
//     },
//         {
//           label: 'LAN0 TX',
//           data: throughputData['throughput LAN0 TX'],
//           fill: false,
//           borderColor: 'rgb(192, 75, 75)',
//           tension: 0.1
//     }
//   ]
//     },
//     options: {
//       scales: {
//         y: {
//           beginAtZero: true,
//           suggestedMax: Math.max(...throughputData['throughput LAN0 RX'], ...throughputData['throughput LAN0 TX']),
//           ticks: {
//             callback: function (value, index, values) {
//               return formatDataSize(value); // Call a function to format the data size dynamically
//             }
//           }
//         }
//       }
//     }
//   });

//  });


//   // Function to format data size dynamically
//   function formatDataSize(value) {
//     if (value >= 1e9) {
//       return (value / 1e9).toFixed(2) + ' Gbps';
//     }
//     else if (value >= 1e6) {
//       return (value / 1e6).toFixed(2) + ' Mbps';
//     }
//     else if (value >= 1e3) {
//       return (value / 1e3).toFixed(2) + ' Kbps';
//     }
//     else {
//       return value.toFixed(2) + ' Bps';
//     }
//  }