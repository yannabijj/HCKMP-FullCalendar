<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heaven's Cradle Key Memorial Park</title>

    <link rel="stylesheet" href="{{ asset('path/to/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">

    <!-- FullCalendar v3.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>
<body>

    <div id="calendar"></div>

    <!-- Modal for event creation and update -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="eventForm">
                <input type="hidden" id="eventId" name="id">

                <div class="form-group">
                    <label for="eventTitle">Event Title</label>
                    <input type="text" id="eventTitle" name="title" required list="title-list">
                    <datalist id="title-list">
                        <option value="Grave Maintenance">Grave Maintenance</option>
                        <option value="Cemetery Maintenance">Cemetery Maintenance</option>
                        <option value="Burial Services">Burial Services</option>
                        <option value="Funeral Services">Funeral Services</option>
                        <option value="Memorial Services">Memorial Services</option>
                        <option value="Visitation Hours">Visitation Hours</option>
                        <option value="Cemetery Tours">Cemetery Tours</option>
                        <option value="Plot Allocation">Plot Allocation</option>
                    </datalist>
                </div>

                <div class="form-group">
                    <label for="eventStart">Start Date</label>
                    <input type="datetime-local" id="eventStart" name="start_date" required>
                </div>

                <div class="form-group">
                    <label for="eventEnd">End Date</label>
                    <input type="datetime-local" id="eventEnd" name="end_date" required>
                </div>

                <div class="form-group">
                    <label for="eventColor">Event Color</label>
                    <div class="color-palette">
                        <div class="color-box" data-color="#B79347" style="background-color: #B79347;" title="Dark Orange"></div>
                        <div class="color-box" data-color="#AB915E" style="background-color: #AB915E;" title="Lighter Orange"></div>
                        <div class="color-box" data-color="#A7967D" style="background-color: #A7967D;" title="White"></div>
                        <div class="color-box" data-color="#CBB989" style="background-color: #CBB989;" title="Light Beige"></div>
                        <div class="color-box" data-color="#E8E0B9" style="background-color: #E8E0B9;" title="Light Cream"></div>
                    </div>
                    <input type="hidden" id="eventColor" name="color" value="#895702">
                </div>

                <div class="form-group">
                    <label for="eventStatus">Status</label>
                    <select id="eventStatus" name="status" required>
                        <option value="Scheduled">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="eventRemarks">Remarks</label>
                    <textarea id="eventRemarks" name="remarks"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Save</button>
                    <ion-icon name="trash" class="btn btn-danger" id="deleteEvent">Delete</ion-icon>
                </div>
            </form>
        </div>
    </div>

    <!-- FullCalendar and custom JavaScript -->
    <script>
        var SITEURL = "{{ url('/') }}";

        $(document).ready(function () {
            $('#calendar').fullCalendar({
                editable: true,
                events: SITEURL + "/events",
                selectable: true,
                selectHelper: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                select: function (start, end) {
                    openModal();
                    $('#eventStart').val(moment(start).format('YYYY-MM-DDTHH:mm'));
                    $('#eventEnd').val(moment(end).format('YYYY-MM-DDTHH:mm'));
                },
                eventClick: function (event) {
                    openModal();
                    $('#eventId').val(event.id);
                    $('#eventTitle').val(event.title);
                    $('#eventStart').val(moment(event.start).format('YYYY-MM-DDTHH:mm'));
                    $('#eventEnd').val(moment(event.end).format('YYYY-MM-DDTHH:mm'));
                    $('#eventColor').val(event.color);
                    $('#eventStatus').val(event.status);
                    $('#eventRemarks').val(event.remarks);
                },
                eventDrop: function (event) {
                    updateEvent(event);
                },
                eventResize: function (event) {
                    updateEvent(event);
                }
            });

            // Modal logic
            var modal = document.getElementById("eventModal");
            var span = document.getElementsByClassName("close")[0];

            function openModal() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Form submission logic
            $('#eventForm').on('submit', function (e) {
                e.preventDefault();
                saveEvent();
            });

            $('#deleteEvent').on('click', function () {
                deleteEvent($('#eventId').val());
            });

            function saveEvent() {
                var id = $('#eventId').val();
                var url = id ? SITEURL + '/events/' + id : SITEURL + '/events';
                var method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        title: $('#eventTitle').val(),
                        start_date: $('#eventStart').val(),
                        end_date: $('#eventEnd').val(),
                        color: $('#eventColor').val(),
                        status: $('#eventStatus').val(),
                        remarks: $('#eventRemarks').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        modal.style.display = "none";
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                });
            }

            function deleteEvent(id) {
                if (confirm("Are you sure you want to delete this event?")) {
                    $.ajax({
                        url: SITEURL + '/events/' + id,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function () {
                            modal.style.display = "none";
                            $('#calendar').fullCalendar('refetchEvents');
                        }
                    });
                }
            }

            function updateEvent(event) {
                $.ajax({
                    url: SITEURL + '/events/' + event.id,
                    method: 'PUT',
                    data: {
                        title: event.title,
                        start_date: moment(event.start).format('YYYY-MM-DDTHH:mm'),
                        end_date: moment(event.end).format('YYYY-MM-DDTHH:mm'),
                        color: event.color,
                        status: event.status,
                        remarks: event.remarks,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                });
            }

            // Handle color box clicks
            $('.color-box').on('click', function () {
                var color = $(this).data('color');
                $('.color-box').removeClass('active');
                $(this).addClass('active');
                $('#eventColor').val(color);
            });
        });

</script>
</body>
</html>
