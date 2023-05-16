<script>

$(document).ready(function() {
    var table = $('#mastdevices').DataTable({

        "ajax": {
            url: "<?php echo base_url("getAllDevices") ?>",
            type: 'POST'
        },
        "columnDefs": [{
                "visible": false,
                "targets": 0
            },
            {
                "targets":[0,1,3,4,5,6],
                "orderable": false 
            },
            {
                "targets": 6,
                "render": function(data, type, row, meta) {
                    if (data == "Online") {
                        return ' <p style="color: green;">' + data + '</p>';
                    } else {
                        return ' <p style="color: red;">' + data + '</p>';
                    }
                }
            }
            

        ],

        order: [
            [2, 'asc']
        ],
        "createdRow": function(row, data, index) {
            // Check if the row is a group header row
            // console.log(row);
            if (data[1] !== "") {
                // Add the "group-header-row" class to the row
                $(row).addClass('bg-info-light');
            }
            // console.log($(row).attr('class'))
        },
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;
            api.column(2, {
                page: 'current'
            }).data().each(function(group, i) {
                if (last !== group) {
                    // console.log(group);
                    $(rows).eq(i).before(
                        '<tr><td>' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        },
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print']
    });

    table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');

    setInterval(function() {
        var currentPage = table.page.info().page;
        table.ajax.reload(function() {
            // Set the current page after data has been reloaded
            table.page(currentPage).draw(false);
            // console.log(currentPage);
        });
    }, 5000);

});



</script>

</body>

</html>