self.onmessage = function (e) {
  console.log("Worker started");
  if (e.data === 'start') {
    setInterval(() => {
      checkDeviceConnectionState((message) => {
        self.postMessage(message);
      });
    }, 120000);
  }
};

function checkDeviceConnectionState(callback) {
  console.log("Checking Device Connection State");
  fetch('checkDeviceConnectionState', {
    method: 'POST',
  })
  .then(response => {
    console.log ("Response: " + response);
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log(data.message);
    callback(data.message);
  })
  .catch(error => {
    console.error('There was a problem with the network request:', error);
  });
}
