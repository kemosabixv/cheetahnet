<script>
   document.addEventListener("DOMContentLoaded", () => {

      //Stations Card
      var stations_current = document.getElementById("stations-current");
      $.ajax({
         url: "<?php echo base_url('getallstations'); ?>",
         type: "GET",
         success: function(response) {
            console.log(response);
            stations_current.innerHTML = response;
         },
         error: function() {
            console.error("Error fetching data for stations");
         }
      });

      //APs Card
      var aps_current = document.getElementById("aps-current");
      $.ajax({
         url: "<?php echo base_url('getallAPs'); ?>",
         type: "GET",
         success: function(response) {
            console.log(response);
            aps_current.innerHTML = response;
         },
         error: function() {
            console.error("Error fetching data for APs");
         }
      });

      //Total Devices Card
      var total_devices_current = document.getElementById("total-devices-current");
      $.ajax({
         url: "<?php echo base_url('getalldevices'); ?>",
         type: "GET",
         success: function(response) {
            console.log(response);
            total_devices_current.innerHTML = response;
         },
         error: function() {
            console.error("Error fetching data for Total Devices");
         }
      });

      //recent_activity_items card
      $.ajax({
         url: "<?php echo base_url('get_recent_activity_items'); ?>",
         type: "GET",
         success: function(response) {
            var recentActivityList = response.data;

            // Clear the existing activity list
            $('#recent_activity_list').empty();

            // Iterate through each activity item and create the corresponding HTML
            recentActivityList.forEach(function(item) {
               var iconClass;
               if (item.operation === 'insert') {
                  iconClass = 'bi-circle-fill activity-badge text-success align-self-start';
               } else if (item.operation === 'delete') {
                  iconClass = 'bi-circle-fill activity-badge text-danger align-self-start';
               } else {
                  iconClass = 'bi-circle-fill activity-badge text-primary align-self-start';
               }

               var type = item.type;
               var deviceName = item.device_name;
               var mastName = item.mast_name;
               var operation;

               if (item.operation === 'insert') {
                  operation = 'added';
               } else if (item.operation === 'delete') {
                  operation = 'deleted';
               } else {
                  operation = 'updated';
               }

               var dateTime = calculateTimeAgo(item.timestamp);

               var recentActivityItem = `
        <div class="activity-item d-flex">
          <div class="activite-label">${dateTime}</div>
          <i class="bi ${iconClass}"></i>
          <div class="activity-content">
            ${type === 'Mast' ? mastName : deviceName} has been ${operation}.
          </div>
        </div>
      `;

               // Append the recent activity item to the recent_activity_list
               $('#recent_activity_list').append(recentActivityItem);
            });
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
         }
      });


      //End of recent_activity_items card

      //recent disconnections datatable

      // handler to the 'yesterday_filter' button
      $('#recent_disconnections_table_filter_yesterday').click(function(e) {
         e.preventDefault();

         $('#recent_disconnections_table_filter').text("| Yesterday");

         // Get the current date
         var currentDate = new Date();

         // Calculate the date for yesterday
         var yesterday = new Date();
         yesterday.setDate(currentDate.getDate() - 1);

         // Format the date for the filter (assuming 'recent_disconnections_table' is the DataTable)
         var formattedDate = formatDate(yesterday);

         // Apply the filter to the DataTable
         recent_disconnections_table.search(formattedDate).draw();
      });

      // Add a click handler to the 'today_filter' button
      $('#recent_disconnections_table_filter_today').click(function(e) {
         e.preventDefault();

         $('#recent_disconnections_table_filter').text("| Today");

         // Get the current date
         var currentDate = new Date();

         // Format the current date for filtering
         var formattedDate = formatDate(currentDate);

         // Apply the filter to the DataTable
         recent_disconnections_table.search(formattedDate).draw();
      });


      var recent_disconnections_table = $('#recent_disconnections_table').DataTable({
         "ajax": {
            "url": "<?php echo base_url('get_recent_disconnections'); ?>",
            "type": "POST",
            "dataSrc": "data"
         },
         "columns": [{
               "data": "device_name"
            },
            {
               "data": "ip",
               "render": function(data, type, row, meta) {
                  var singleDeviceRoute = "<?php echo base_url("
                  devices / device / "); ?>" + data;
                  let ahref = '<a href="' + singleDeviceRoute + '" target="_blank">' + data + '</a>';
                  return ahref;
               }
            },
            {
               "data": "model"
            },
            {
               "data": "date"
            },
            {
               "data": "current_status",
               "render": function(data, type, row, meta) {
                  if (data === "Online") {
                     return '<span class="badge bg-success">' + data + '</span>';
                  } else {
                     return '<span class="badge bg-danger">' + data + '</span>';
                  }
               }
            }
         ],
         "columnDefs": [{
            "targets": [0, 1, 2, 3, 4],
            "orderable": false
         }, ],
         "order": [
            [3, "desc"]
         ],
      });
      $('#recent_disconnections_table_filter').text("| Today");

      // Get the current date
      var currentDate = new Date();

      // Format the current date for filtering
      var formattedDate = formatDate(currentDate);

      // Apply the filter to the DataTable
      recent_disconnections_table.search(formattedDate).draw();

      //End of recent disconnections datatable

      //connections_per_ap_table datatable

      var connections_per_ap_table = $('#connections_per_ap_table').DataTable({
         "ajax": {
            "url": "<?php echo base_url('get_connections_per_ap'); ?>",
            "type": "POST",
            "dataSrc": "data",
         },
         "columns": [{
               "data": "img"
            },
            {
               "data": "device_name"
            },
            {
               "data": "ipaddress",
               "render": function(data, type, row, meta) {
                  var singleDeviceRoute = "<?php echo base_url("
                  devices / device / "); ?>" + data;
                  let ahref = '<a href="' + singleDeviceRoute + '" target="_blank">' + data + '</a>';
                  return ahref;
               }
            },
            {
               "data": "model"
            },
            {
               "data": "connection_count"
            },
         ],
         "columnDefs": [{
            "targets": [0, 1, 2, 3],
            "orderable": false
         }, ],
         "order": [
            [4, "desc"]
         ]
      });
      //End of connections_per_ap_table datatable




      //Mast Group Chart                  
      var chart = echarts.init(document.getElementById("MastGroupChart"));
      // Configure the chart options
      var options = {
         tooltip: {
            trigger: 'item'
         },
         legend: {
            orient: 'vertical',
            left: 10,
            top: 10, // Adjust the top value to increase the vertical spacing between legends
            align: 'left'
         },
         series: [{
            name: 'Devices',
            type: 'pie',
            radius: ['40%', '70%'],
            center: ['75%', '50%'],
            avoidLabelOverlap: true,
            label: {
               show: false,
               position: 'center'
            },
            emphasis: {
               label: {
                  show: true,
                  fontSize: '18',
                  fontWeight: 'bold'
               }
            },
            labelLine: {
               show: false
            },
            data: [] // Placeholder for the dynamic data
         }]
      };

      // Set the chart options
      chart.setOption(options);
      // Make an AJAX request to fetch the data for the chart
      $.ajax({
         url: "<?php echo base_url('getmastdevicescount'); ?>",
         type: "GET",
         success: function(response) {
            console.log(response);
            // Prepare the data for the chart
            var chartData = response.data.map(function(item) {
               return {
                  value: item.count,
                  name: item.mast_name
               };
            });

            // Update the chart options with the new data
            options.series[0].data = chartData;

            // Update the chart with the new data
            chart.setOption(options);

         },
         error: function() {
            console.error("Error fetching data for chart");
         }
      });
      // End of Mast Group Chart


   });

function formatDate(date) {
   var year = date.getFullYear();
   var month = (date.getMonth() + 1).toString().padStart(2, '0');
   var day = date.getDate().toString().padStart(2, '0');

   return year + '-' + month + '-' + day;
}

function calculateTimeAgo(timestamp) {
   var currentDate = new Date(); // Current date/time
   var targetDate = new Date(timestamp); // Target date/time

   // Calculate the time difference in milliseconds
   var timeDiff = currentDate - targetDate;

   // Calculate the number of minutes, hours, and days
   var minutes = Math.floor(timeDiff / (1000 * 60));
   var hours = Math.floor(timeDiff / (1000 * 60 * 60));
   var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

   // Determine the time unit and value based on the greatest value
   var timeUnit, timeValue;
   if (days > 0) {
      timeUnit = 'day';
      timeValue = days;
   } else if (hours > 0) {
      timeUnit = 'hr';
      timeValue = hours;
   } else {
      timeUnit = 'min';
      timeValue = minutes;
   }

   // Append 's' to the time unit if the value is greater than 1
   if (timeValue > 1) {
      timeUnit += 's';
   }

   // Format the time value and unit
   var formattedTime = timeValue + ' ' + timeUnit;

   return formattedTime; // Return the formatted time
}




</script>