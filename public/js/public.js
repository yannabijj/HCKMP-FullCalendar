$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
      schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                  nowIndicator: true,
                  editable: true,
                  selectable: true,
                  navLinks: true,
                  timeZone: 'Asia/Manila',  // Set timezone to Philippine timezone
                  locale: 'en',  // Set locale to English
                  initialView: 'dayGridMonth',  // Set initial view to Month
                  eventColor: '#FFC0CB',
                  eventTextColor: '#808080',
                  eventBackgroundColor: '#808080',
                  headerToolbar: {
                      left: 'prev,next today',
                      center: 'title',
                      right: 'dayGridMonth,resourceTimeGridWeek,resourceTimeGridDay'
                  },
      events: '/events', // Fetch events from server
      eventClick: function(event) {
        $('#update_event_id').val(event.id);
        $('#update_title').val(event.title);
        $('#update_start_date').val(event.start.format('YYYY-MM-DD'));
        $('#update_end_date').val(event.end.format('YYYY-MM-DD'));
        $('#update_event_color').val(event.color || '#ffffff');
        $('#update_status').val(event.status || 'pending');
        $('#update_remarks').val(event.remarks || '');
        $('#updateEventModal').show();
      }
    });
  
    $('#openModal').click(function() {
      $('#event_id').val('');
      $('#title').val('');
      $('#start_date').val('');
      $('#end_date').val('');
      $('#event_color').val('#ffffff');
      $('#status').val('pending');
      $('#remarks').val('');
      $('#eventModal').show();
    });
  
    $('#closeModal, #closeUpdateModal').click(function() {
      $('#eventModal, #updateEventModal').hide();
    });
  
    $('#eventForm').submit(function(event) {
      event.preventDefault();
  
      var title = $('#title').val();
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      var event_color = $('#event_color').val();
      var status = $('#status').val();
      var remarks = $('#remarks').val();
  
      if (title && start_date && end_date) {
        $.ajax({
          url: '/events',
          method: 'POST',
          data: {
            title: title,
            start_date: start_date,
            end_date: end_date,
            event_color: event_color,
            status: status,
            remarks: remarks,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            $('#calendar').fullCalendar('refetchEvents');
            $('#eventModal').hide();
          }
        });
      }
    });
  
    $('#updateEventForm').submit(function(event) {
      event.preventDefault();
  
      var id = $('#update_event_id').val();
      var title = $('#update_title').val();
      var start_date = $('#update_start_date').val();
      var end_date = $('#update_end_date').val();
      var event_color = $('#update_event_color').val();
      var status = $('#update_status').val();
      var remarks = $('#update_remarks').val();
  
      if (id && title && start_date && end_date) {
        $.ajax({
          url: '/events/' + id,
          method: 'PUT',
          data: {
            title: title,
            start_date: start_date,
            end_date: end_date,
            event_color: event_color,
            status: status,
            remarks: remarks,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            $('#calendar').fullCalendar('refetchEvents');
            $('#updateEventModal').hide();
          }
        });
      }
    });
  
    $('#deleteEvent').click(function() {
      var id = $('#update_event_id').val();
  
      if (id) {
        $.ajax({
          url: '/events/' + id,
          method: 'DELETE',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            $('#calendar').fullCalendar('refetchEvents');
            $('#updateEventModal').hide();
          }
        });
      }
    });
  });
  
  