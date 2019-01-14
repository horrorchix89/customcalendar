<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Calendar Display</title>
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>scripts/fullcalendar/fullcalendar.min.css" />
               <script src="<?php echo base_url() ?>scripts/fullcalendar/lib/moment.min.js"></script>
               <script src="<?php echo base_url() ?>scripts/fullcalendar/fullcalendar.min.js"></script>
               <script src="<?php echo base_url() ?>scripts/fullcalendar/gcal.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

    <div class="container">
    <div class="row">
    <div class="col-md-12">

    <h1>Caelndar</h1>
        <div id="calendar">
</div>

        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Calendar Event</h4>
      </div>
      <div class="modal-body">
      <?php echo form_open(site_url("calendar/add_event"), array("class" => "form-horizontal")) ?>
      <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Event Name</label>
                <div class="col-md-8 ui-front">
                    <input type="text" class="form-control" name="name" value="">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Location</label>
                <div class="col-md-8 ui-front">
                    <input type="text" class="form-control" name="location" value="">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Description</label>
                <div class="col-md-8 ui-front">
                    <textarea type="text" class="form-control" name="description"></textarea>
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Start Date</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="start_date">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">End Date</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="end_date">
                </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add Event">
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Calendar Event</h4>
      </div>
      <div class="modal-body">
      <?php echo form_open(site_url("calendar/edit_event"), array("class" => "form-horizontal")) ?>
      <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Event Name</label>
                <div class="col-md-8 ui-front">
                    <input type="text" class="form-control" name="name" value="" id="name">
                </div>
        </div>
          <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Location</label>
                <div class="col-md-8 ui-front">
                    <input type="text" class="form-control" name="location" id="location">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Description</label>
                <div class="col-md-8 ui-front">
                    <textarea type="text" class="form-control" name="description" id="description"></textarea>
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Start Date</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="start_date" id="start_date">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">End Date</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="end_date" id="end_date">
                </div>
        </div>
        <div class="form-group">
                    <label for="p-in" class="col-md-4 label-heading">Delete Event</label>
                    <div class="col-md-8">
                        <input type="checkbox" name="delete" value="1">
                    </div>
            </div>
            <input type="hidden" name="eventid" id="event_id" value="0" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Update Event">
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>
    </div>
    </div>
    </div>

<script type="text/javascript">
    function getColor() {
        return '#'+Math.floor(Math.random()*16777215).toString(16);
    }
</script>
<script type="text/javascript">
$(document).ready(function() {
    var date_last_clicked = null;

$('#calendar').fullCalendar({
    eventSources: [
    {
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: '<?php echo base_url() ?>calendar/get_events',
                dataType: 'json',
                data: {                
                    start: start.unix(),
                    end: end.unix()
                },
                success: function(msg) {
                    var events = msg.events;
                    callback(events);
                }
            });
       }
    },
    ],
    dayClick: function(date, jsEvent, view) {
        date_last_clicked = $(this);
        $(this).css('background-color', '#bed7f3');
        $('#addModal').modal();
    },
});
</script>
    </body>
</html>
