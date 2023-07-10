<script>
   document.addEventListener("DOMContentLoaded", () => {
      //current stations count and history
      var current_stations_count;
      var stations_history;
      $.ajax({
         url: "<?php echo base_url('getallstations'); ?>",
         type: "GET",
         async: false,
         success: function(response) {
            console.log(response);
            current_stations_count = response.data.current_station_count[0].station_count;
            stations_history = response.data.station_history;
            console.log(stations_history); 
         },
         error: function() {
            console.error("Error fetching data for Total Devices");
         }
      });
      //current aps count and history
      var current_aps_count;
      var aps_history;
      $.ajax({
         url: "<?php echo base_url('getallAPs'); ?>",
         type: "GET",
         async: false,
         success: function(response) {
            console.log(response);
            current_aps_count = response.data.current_ap_count[0].ap_count;
            console.log(current_aps_count);
            aps_history = response.data.ap_history;
            console.log(aps_history); 
         },
         error: function() {
            console.error("Error fetching data for Total Devices");
         }
      });
      //current total devices count and history
      var current_total_devices_count;
      var total_devices_history;
      $.ajax({
         url: "<?php echo base_url('getalldevices'); ?>",
         type: "GET",
         async: false,
         success: function(response) {
            console.log(response);
            current_total_devices_count = response.data.total_current_count[0].total_count;
            console.log(current_total_devices_count);
            total_devices_history = response.data.total_count_history;
            console.log(total_devices_history); 
         },
         error: function() {
            console.error("Error fetching data for Total Devices");
         }
      });


//Stations Card
      $('#stations_current').html(current_stations_count);

      // handler to the 'stations_filter_today' button
      $('#stations_filter_today').click(function(e) {
      e.preventDefault();
      $('#stations_current').html(current_stations_count);
      $('#stations_filter_display').text("| Today");
      $('#stations_difference').html('');
      $('#stations_difference_type').html('');
      });
      

      // handler to the 'stations_filter_yesterday' button
      $('#stations_filter_yesterday').click(function(e) {
      e.preventDefault();
      $('#stations_filter_display').text("| Yesterday");

      var station_count_yesterday = null;
      var station_value_yesterday = null;
      var mostRecentEntry = null;

      var currentDate = new Date();
      currentDate.setHours(0, 0, 0, 0);
      var mostRecentEntry = null;
      
      for (var i = 0; i < stations_history.length; i++) {
      var entry = stations_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to today
      if (entryDate.getTime() !== currentDate.getTime()) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      station_count_yesterday = mostRecentEntry.station_count;
      station_count_yesterday_display = mostRecentEntry.station_count;

      if (station_count_yesterday !== null) {
      // Calculate the percentage difference between current_stations_count and station_count_yesterday
      var difference = current_stations_count - station_count_yesterday;
      percent_difference = Math.abs((difference / station_count_yesterday) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         station_value_yesterday = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         station_value_yesterday = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         station_value_yesterday = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#stations_difference').html(station_value_yesterday);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#stations_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference
      
      } else {
         station_value_yesterday = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#stations_current').html(current_stations_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + station_count_yesterday_display + '</span>');
      });
      //End  handler to the 'stations_filter_today' button


      // handler to the 'stations_filter_lastweek' button
      $('#stations_filter_lastweek').click(function(e) {
      e.preventDefault();
      $('#stations_filter_display').text("| Last Week");
      var station_count_lastweek = null;
      var station_value_lastweek = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentWeekNumber = today.getWeek();
      console.log(currentWeekNumber);
      
      for (var i = 0; i < stations_history.length; i++) {
      var entry = stations_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getWeek() !== currentDate.getWeek()) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }
      
      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      station_count_lastweek = mostRecentEntry.station_count;
      station_count_lastweek_display = mostRecentEntry.station_count;

      if (station_count_lastweek !== null) {
      // Calculate the percentage difference between current_stations_count and station_count_yesterday
      var difference = current_stations_count - station_count_lastweek;
      percent_difference = Math.abs((difference / station_count_lastweek) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         station_value_lastweek = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         station_value_lastweek = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         station_value_lastweek = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#stations_difference').html(station_value_lastweek);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#stations_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference
      
      } else {
         station_value_lastweek = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#stations_current').html(current_stations_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + station_count_lastweek_display + '</span>');
      });
      // End handler to the 'stations_filter_lastweek' button

      // handler to the 'stations_filter_lastmonth' button
      $('#stations_filter_lastmonth').click(function(e) {
      e.preventDefault();
      $('#stations_filter_display').text("| Last Month");
      var station_count_lastmonth = null;
      var station_value_lastmonth = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentMonthNumber = today.getMonth();
      console.log(currentMonthNumber);

      for (var i = 0; i < stations_history.length; i++) {
      var entry = stations_history[i];
      var entryDate = new Date(entry.date_created);

        // Check if the entry date is not equal to this week
        if (entryDate.getMonth() !== currentMonthNumber) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }
       // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      station_count_lastmonth = mostRecentEntry.station_count;
      station_count_lastmonth_display = mostRecentEntry.station_count;

      if (station_count_lastmonth !== null) {
      // Calculate the percentage difference between current_stations_count and station_count_yesterday
      var difference = current_stations_count - station_count_lastmonth;
      percent_difference = Math.abs((difference / station_count_lastmonth) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         station_value_lastmonth = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         station_value_lastmonth = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         station_value_lastmonth = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#stations_difference').html(station_value_lastmonth);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#stations_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference
      
      } else {
         station_value_lastmonth = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#stations_current').html(current_stations_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + station_count_lastmonth_display + '</span>');
      });
      // End handler to the 'stations_filter_lastmonth' button

      // handler to the 'stations_filter_lastyear' button
      $('#stations_filter_lastyear').click(function(e) {
      e.preventDefault();
      $('#stations_filter_display').text("| Last Year");
      var station_count_lastyear = null;
      var station_value_lastyear = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentYearNumber = today.getFullYear();
      console.log(currentYearNumber);

      for (var i = 0; i < stations_history.length; i++) {
      var entry = stations_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getFullYear() !== currentYearNumber) {
      if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
         mostRecentEntry = entry;
            }
         }
      }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to this year
      console.log(mostRecentEntry);
      station_count_lastyear = mostRecentEntry.station_count;
      station_count_lastyear_display = mostRecentEntry.station_count;

      if (station_count_lastyear !== null) {
      // Calculate the percentage difference between current_stations_count and station_count_yesterday
      var difference = current_stations_count - station_count_lastyear;
      percent_difference = Math.abs((difference / station_count_lastyear) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         station_value_lastyear = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         station_value_lastyear = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         station_value_lastyear = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }
      console.log(station_value_lastyear);
      $('#stations_difference').html(station_value_lastyear);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#stations_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference
      
      } else {
         station_value_lastyear = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#stations_current').html(current_stations_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + station_count_lastyear_display + '</span>');
      });
      // End handler to the 'stations_filter_lastyear' button
//End Stations Card

//APs Card
      $('#aps_current').html(current_aps_count);

      // handler to the 'aps_filter_today' button
      $('#aps_filter_today').click(function(e) {
      e.preventDefault();
      $('#aps_current').html(current_aps_count);
      $('#aps_filter_display').text("| Today");
      $('#aps_difference').html('');
      $('#aps_difference_type').html('');
      });


      // handler to the 'aps_filter_yesterday' button
      $('#aps_filter_yesterday').click(function(e) {
      e.preventDefault();
      $('#aps_filter_display').text("| Yesterday");

      var aps_count_yesterday = null;
      var aps_value_yesterday = null;
      var mostRecentEntry = null;

      var currentDate = new Date();
      currentDate.setHours(0, 0, 0, 0);
      var mostRecentEntry = null;

      for (var i = 0; i < aps_history.length; i++) {
      var entry = aps_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to today
      if (entryDate.getTime() !== currentDate.getTime()) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      aps_count_yesterday = mostRecentEntry.ap_count;
      aps_count_yesterday_display = mostRecentEntry.ap_count;

      if (aps_count_yesterday !== null) {
      // Calculate the percentage difference between current_stations_count and station_count_yesterday
      var difference = current_aps_count - aps_count_yesterday;
      percent_difference = Math.abs((difference / aps_count_yesterday) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         aps_value_yesterday = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         aps_value_yesterday = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         aps_value_yesterday = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#aps_difference').html(aps_value_yesterday);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#aps_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         aps_value_yesterday = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#aps_current').html(current_aps_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + aps_count_yesterday_display + '</span>');
      });
      //End  handler to the 'aps_filter_yesterday' button


      // handler to the 'aps_filter_lastweek' button
      $('#aps_filter_lastweek').click(function(e) {
      e.preventDefault();
      $('#aps_filter_display').text("| Last Week");
      var aps_count_lastweek = null;
      var aps_value_lastweek = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentWeekNumber = today.getWeek();
      console.log(currentWeekNumber);

      for (var i = 0; i < aps_history.length; i++) {
      var entry = aps_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getWeek() !== currentDate.getWeek()) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      aps_count_lastweek = mostRecentEntry.ap_count;
      aps_count_lastweek_display = mostRecentEntry.ap_count;

      if (aps_count_lastweek !== null) {
      // Calculate the percentage difference between current_aps_count and ap_count_yesterday
      var difference = current_aps_count - aps_count_lastweek;
      percent_difference = Math.abs((difference / aps_count_lastweek) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         aps_count_lastweek = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         aps_count_lastweek = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         aps_count_lastweek = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#aps_difference').html(aps_count_lastweek);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#aps_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         aps_count_lastweek = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#aps_current').html(current_aps_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + aps_count_lastweek_display + '</span>');
      });
      // End handler to the 'aps_filter_lastweek' button

      // handler to the 'aps_filter_lastmonth' button
      $('#aps_filter_lastmonth').click(function(e) {
      e.preventDefault();
      $('#aps_filter_display').text("| Last Month");
      var aps_count_lastmonth = null;
      var aps_value_lastmonth = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentMonthNumber = today.getMonth();
      console.log(currentMonthNumber);

      for (var i = 0; i < aps_history.length; i++) {
      var entry = aps_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getMonth() !== currentMonthNumber) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }
      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      aps_count_lastmonth = mostRecentEntry.ap_count;
      aps_count_lastmonth_display = mostRecentEntry.ap_count;

      if (aps_count_lastmonth !== null) {
      // Calculate the percentage difference between current_aps_count and ap_count_yesterday
      var difference = current_aps_count - aps_count_lastmonth;
      percent_difference = Math.abs((difference / aps_count_lastmonth) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         aps_value_lastmonth = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         aps_value_lastmonth = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         aps_value_lastmonth = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#aps_difference').html(aps_value_lastmonth);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#aps_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         aps_value_lastmonth = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#aps_current').html(current_aps_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + aps_count_lastmonth_display + '</span>');
      });
      // End handler to the 'aps_filter_lastmonth' button

      // handler to the 'aps_filter_lastyear' button
      $('#aps_filter_lastyear').click(function(e) {
      e.preventDefault();
      $('#aps_filter_display').text("| Last Year");
      var aps_count_lastyear = null;
      var aps_value_lastyear = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentYearNumber = today.getFullYear();
      console.log(currentYearNumber);

      for (var i = 0; i < aps_history.length; i++) {
      var entry = aps_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getFullYear() !== currentYearNumber) {
      if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
         mostRecentEntry = entry;
            }
         }
      }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to this year
      console.log(mostRecentEntry);
      aps_count_lastyear = mostRecentEntry.ap_count;
      aps_count_lastyear_display = mostRecentEntry.ap_count;

      if (aps_count_lastyear !== null) {
      // Calculate the percentage difference between aps_stations_count and ap_count_yesterday
      var difference = current_aps_count - aps_count_lastyear;
      percent_difference = Math.abs((difference / aps_count_lastyear) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         aps_value_lastyear = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         aps_value_lastyear = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         aps_value_lastyear = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }
      console.log(aps_value_lastyear);
      $('#aps_difference').html(aps_value_lastyear);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#aps_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         aps_value_lastyear = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#aps_current').html(current_aps_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + aps_count_lastyear_display + '</span>');
      });
      // End handler to the 'aps_filter_lastyear' button
//End APs Card 




//Total Devices Card
      $('#total_devices_current').html(current_total_devices_count);

      // handler to the 'aps_filter_today' button
      $('#total_devices_filter_today').click(function(e) {
      e.preventDefault();
      $('#total_devices_current').html(current_total_devices_count);
      $('#total_devices_filter_display').text("| Today");
      $('#total_devices_difference').html('');
      $('#total_devices_difference_type').html('');
      });


      // handler to the 'total_devices_filter_yesterday' button
      $('#total_devices_filter_yesterday').click(function(e) {
      e.preventDefault();
      $('#total_devices_filter_display').text("| Yesterday");

      var total_devices_count_yesterday = null;
      var total_devices_value_yesterday = null;
      var mostRecentEntry = null;

      var currentDate = new Date();
      currentDate.setHours(0, 0, 0, 0);
      var mostRecentEntry = null;

      for (var i = 0; i < total_devices_history.length; i++) {
      var entry = total_devices_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to today
      if (entryDate.getTime() !== currentDate.getTime()) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      total_devices_count_yesterday = mostRecentEntry.total_count;
      total_devices_count_yesterday_display = mostRecentEntry.total_count;

      if (total_devices_count_yesterday !== null) {
      // Calculate the percentage difference between current_stations_count and station_count_yesterday
      var difference = current_total_devices_count - total_devices_count_yesterday;
      percent_difference = Math.abs((difference / total_devices_count_yesterday) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         total_devices_value_yesterday = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         total_devices_value_yesterday = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         total_devices_value_yesterday = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#total_devices_difference').html(total_devices_value_yesterday);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#total_devices_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         total_devices_value_yesterday = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#total_devices_current').html(current_total_devices_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + total_devices_count_yesterday_display + '</span>');
      });
      //End  handler to the 'total_devices_filter_yesterday' button


      // handler to the 'total_devices_filter_lastweek' button
      $('#total_devices_filter_lastweek').click(function(e) {
      e.preventDefault();
      $('#total_devices_filter_display').text("| Last Week");
      var total_devices_count_lastweek = null;
      var total_devices_value_lastweek = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentWeekNumber = today.getWeek();
      console.log(currentWeekNumber);

      for (var i = 0; i < total_devices_history.length; i++) {
      var entry = total_devices_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getWeek() !== currentDate.getWeek()) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      total_devices_count_lastweek = mostRecentEntry.total_count;
      total_devices_count_lastweek_display = mostRecentEntry.total_count;

      if (total_devices_count_lastweek !== null) {
      // Calculate the percentage difference between current_total_devices_count and total_count_yesterday
      var difference = current_total_devices_count - total_devices_count_lastweek;
      percent_difference = Math.abs((difference / total_devices_count_lastweek) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         total_devices_count_lastweek = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         total_devices_count_lastweek = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         total_devices_count_lastweek = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#total_devices_difference').html(total_devices_count_lastweek);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#total_devices_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         total_devices_count_lastweek = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#total_devices_current').html(current_total_devices_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + total_devices_count_lastweek_display + '</span>');
      });
      // End handler to the 'total_devices_filter_lastweek' button

      // handler to the 'aps_filter_lastmonth' button
      $('#total_devices_filter_lastmonth').click(function(e) {
      e.preventDefault();
      $('#total_devices_filter_display').text("| Last Month");
      var total_devices_count_lastmonth = null;
      var total_devices_value_lastmonth = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentMonthNumber = today.getMonth();
      console.log(currentMonthNumber);

      for (var i = 0; i < total_devices_history.length; i++) {
      var entry = total_devices_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getMonth() !== currentMonthNumber) {
         if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
            mostRecentEntry = entry;
               }
            }
         }
      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to today
      console.log(mostRecentEntry);
      total_devices_count_lastmonth = mostRecentEntry.total_count;
      total_devices_count_lastmonth_display = mostRecentEntry.total_count;

      if (total_devices_count_lastmonth !== null) {
      // Calculate the percentage difference between current_total_devices_count and total_count_yesterday
      var difference = current_total_devices_count - total_devices_count_lastmonth;
      percent_difference = Math.abs((difference / total_devices_count_lastmonth) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         total_devices_value_lastmonth = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         total_devices_value_lastmonth = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         total_devices_value_lastmonth = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }

      $('#total_devices_difference').html(total_devices_value_lastmonth);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#total_devices_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         total_devices_value_lastmonth = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#total_devices_current').html(current_total_devices_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + total_devices_count_lastmonth_display + '</span>');
      });
      // End handler to the 'total_devices_filter_lastmonth' button

      // handler to the 'total_devices_filter_lastyear' button
      $('#total_devices_filter_lastyear').click(function(e) {
      e.preventDefault();
      $('#total_devices_filter_display').text("| Last Year");
      var total_devices_count_lastyear = null;
      var total_devices_value_lastyear = null;
      var mostRecentEntry = null;
      var today = new Date();
      var currentYearNumber = today.getFullYear();
      console.log(currentYearNumber);

      for (var i = 0; i < total_devices_history.length; i++) {
      var entry = total_devices_history[i];
      var entryDate = new Date(entry.date_created);

      // Check if the entry date is not equal to this week
      if (entryDate.getFullYear() !== currentYearNumber) {
      if (!mostRecentEntry || entryDate > mostRecentEntry.date_created) {
         mostRecentEntry = entry;
            }
         }
      }

      // The `mostRecentEntry` variable now holds the most recent entry that is not equal to this year
      console.log(mostRecentEntry);
      total_devices_count_lastyear = mostRecentEntry.total_count;
      total_devices_count_lastyear_display = mostRecentEntry.total_count;

      if (total_devices_count_lastyear !== null) {
      // Calculate the percentage difference between aps_stations_count and total_count_yesterday
      var difference = current_total_devices_count - total_devices_count_lastyear;
      percent_difference = Math.abs((difference / total_devices_count_lastyear) * 100).toFixed(0);
      console.log(difference);
      console.log(percent_difference);
      if (difference > 0) {
         total_devices_value_lastyear = '<span class="text-success small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else if (difference < 0) {
         total_devices_value_lastyear = '<span class="text-danger small pt-1 fw-bold">' + percent_difference + '%</span>';
      } else {
         total_devices_value_lastyear = '<span class="text-muted small pt-1 fw-bold">No Change</span>';
      }
      console.log(total_devices_value_lastyear);
      $('#total_devices_difference').html(total_devices_value_lastyear);

      // Determine the difference type
      difference_type = (difference > 0) ? '<span class="text-muted small pt-2 ps-1">increase</span>' : (difference < 0) ? '<span class="text-muted small pt-2 ps-1">decrease</span>' : '';
      $('#total_devices_difference_type').html(difference_type);
      // Display the previous day's station count and percentage difference

      } else {
         total_devices_value_lastyear = 'N/A';
      }
      // Update the HTML with the station count and difference
      $('#total_devices_current').html(current_total_devices_count + '<span style="color: #899bbd; font-size: 24px; font-weight: 200;"> | ' + total_devices_count_lastyear_display + '</span>');
      });
      // End handler to the 'aps_filter_lastyear' button
//End Total Devices Card
      

//Reports Card
      $.ajax({
         url: 'get_connection_status_history', // Replace with the actual URL of your server endpoint
         type: 'GET',
         success: function(response) {
            var offlineData = response.data.map(function(entry) {
                  return parseInt(entry.offlne_count);
            });

            var onlineData = response.data.map(function(entry) {
                  return parseInt(entry.online_count);
            });

            var chartData = response.data.map(function(entry) {
                  return entry.date_created;
            });

            var chart = new ApexCharts(document.querySelector('#reportsChart'), {
                  series: [{
                     name: 'Offline',
                     data: offlineData,
                  }, {
                     name: 'Online',
                     data: onlineData,
                  }],
                  chart: {
                     height: 350,
                     type: 'area',
                     toolbar: {
                        show: false
                     },
                  },
                  markers: {
                     size: 4
                  },
                  colors: ['#4154f1', '#2eca6a', '#ff771d'],
                  fill: {
                     type: "gradient",
                     gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                     }
                  },
                  dataLabels: {
                     enabled: false
                  },
                  stroke: {
                     curve: 'smooth',
                     width: 2
                  },
                  xaxis: {
                     type: 'datetime',
                     categories: chartData,
                  },
                  tooltip: {
                     x: {
                        format: 'yyyy-MM-dd HH:mm:ss'
                     },
                  }
            });

            chart.render();
         },
         error: function() {
            console.error('Error fetching chart data.');
         }
      });
                  
//End Reports Card



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
                  var singleDeviceRoute = "<?php echo base_url("devices/device/"); ?>" + data;
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
                  var singleDeviceRoute = "<?php echo base_url("devices/device/"); ?>" + data;
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

      //Device Group Chart                  
      var device_group_chart = echarts.init(document.getElementById("MastGroupChart"));
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
      device_group_chart.setOption(options);
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
            device_group_chart.setOption(options);

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

Date.prototype.getWeek = function() {
  var onejan = new Date(this.getFullYear(),0,1);
  var today = new Date(this.getFullYear(),this.getMonth(),this.getDate());
  var dayOfYear = ((today - onejan + 86400000)/86400000);
  return Math.ceil(dayOfYear/7)
};


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