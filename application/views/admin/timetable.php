<div class="container">
	<div class="btn-toolbar">
		<a id="save_button" type="button" class="btn btn-success">
			<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
		</a>
		<span class="btn-separator"></span>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#copyModal">
			<span class="glyphicon glyphicon-copy" aria-hidden="true"></span> Copy schedule...
			<!-- Modal with two calendars -->
		</button>
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete schedules...
			<!-- Modal with selectable days -->
		</button>
		<button type="button" class="btn btn-info">
			<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Reflect to machines...
			<!-- Modal with selectable days -->
		</button>
	</div>
	<hr>
<script>
    function saveData() {
        $.ajax({
            type: "POST",
            url: "timetable_save",
            success: function(data) {
                // return success
                if (data.length > 0) {
                    $('#calendar').fullCalendar('refetchEvents');
                    alert("events fetched!");
                }
            }
        });
    }
    function removeEvent(id) {
        var event = $("#calendar").fullCalendar( 'clientEvents', id)[0];
        var post_data = {
            "id": event.id,
            "assigned": event.assigned,
            "start": moment(event._start).format("YYYY-MM-DD HH:mm:ss"),
            "end": moment(event._end).format("YYYY-MM-DD HH:mm:ss")
        }
        $.ajax({
            type: "POST",
            url: "timetable_remove_slot",
            data: post_data,
            success: function(data) {
                // return success
                if (data.length > 0) {
                    event.color = "#660000";
                    $('#calendar').fullCalendar('updateEvent', event);
                }
            }
        });
    }
    function restoreEvent(id) {
        var post_data = {
            "id": event.id,
            "assigned": event.assigned,
            "start": moment(event.start).format("YYYY-MM-DD HH:mm:ss"),
            "end": moment(event.end).format("YYYY-MM-DD HH:mm:ss")
        }
        $.ajax({
            type: "POST",
            url: "timetable_restore_slot",
            data: post_data,
            success: function(data) {
                // return success
                if (data.length > 0) {
                    event.color = "#000066";
                    $('#calendar').fullCalendar('updateEvent', event);
                }
            }
        });
    }
    
    
    $('#save_button').click(function(){
		saveData();
	});

    //Schedule functions 
    function copySchedules() {
		var sDate = $("#startDate").datepicker( "getDate" );
		var eDate = $("#endDate").datepicker( "getDate" );
		var csDate = $("#copyStartDate").datepicker( "getDate" );
        if ( sDate === null || eDate === null || csDate === null ) {
            alert("Dates cannot be empty.");
            return;
        }
        if ( sDate >= eDate ) {
            alert("Start date must be earlier than end date");
            return;
        }
        if ( eDate >= csDate ) {
            alert("End date must be earlier Copy to date");
            return;
        }
        sDate = moment($("#startDate").datepicker( "getDate" )).format("YYYY-MM-DD");
		eDate = moment($("#endDate").datepicker( "getDate" )).format("YYYY-MM-DD");
		csDate = moment($("#copyStartDate").datepicker( "getDate" )).format("YYYY-MM-DD");
    	var post_data = {
              "startDate" : sDate,
              "endDate" : eDate,
              "copyStartDate" : csDate
        };
		$.ajax({
        	type: "POST",
            url: "schedule_copy",
            data: post_data,
            success: function(data) {
                alert(data);
                $('#calendar').fullCalendar('refetchEvents');
            }
    	});
    }
    function removeSchedules() {
		var sDate = $("#remove_startDate").datepicker( "getDate" );
		var eDate = $("#remove_endDate").datepicker( "getDate" );
        if ( sDate === null || eDate === null) {
            alert("Dates cannot be empty.");
            return;
        }
        if ( sDate >= eDate ) {
            alert("Start date must be earlier than end date");
            return;
        }
        sDate = moment($("#remove_startDate").datepicker( "getDate" )).format("YYYY-MM-DD");
		eDate = moment($("#remove_endDate").datepicker( "getDate" )).format("YYYY-MM-DD");
    	var post_data = {
              "startDate" : sDate,
              "endDate" : eDate
        };
		$.ajax({
        	type: "POST",
            url: "schedule_delete",
            data: post_data,
            success: function(data) {
                alert(data);
                $('#calendar').fullCalendar('refetchEvents');
            }
    	});
    }
    
    
	$(document).ready(function() {

		/* initialize the Datepickers
		-----------------------------------------------------------------*/
		$( ".modaldate" ).datepicker();

		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
                assigned: $.trim($(this).data( "assigned" )),
				stick: false // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
            eventSources: [
            // your event source
                {
                    url: 'timetable_fetch_supervision_sessions', // use the `url` property
                    color: '#006600'  // an option!
                },
                {
                    url: 'timetable_fetch_mod_and_new_sessions', // use the `url` property
                    color: '#000066'  // an option!
                }
            ],
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
            allDaySlot: false,
			allDayDefault: false,
			defaultTimedEventDuration: '08:00:00',
            forceEventDuration: true,
            timeFormat: 'HH:mm',
            axisFormat: 'HH:mm',
			editable: true,
            firstDay: 1,
			droppable: true, // this allows things to be dropped onto the calendar
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			eventClick: function(event, element) {
                $('#modalTitle').html(event.title);
                $('#modalBody').html(event.description);
                $('#event_remove_button').attr('href',"javascript:removeEvent(" + event.id + ")");
                $('#eventUrl').attr('href',event.url);
                $('#eventModal').modal();
				//open modal/tooltip for deletion and manual data entry
				$('#calendar').fullCalendar('updateEvent', event);
			},
			editable: true,
            eventRender: function(event, element){
                var assigned = event.assigned;
            },
			eventResize: function(event, delta, revertFunc) {
                //Resize callback
                var post_data = {
                    "id": event.id,
                    "assigned": event.assigned,
                    "start": moment(event.start).format("YYYY-MM-DD HH:mm:ss"),
                    "end": moment(event.end).format("YYYY-MM-DD HH:mm:ss")
                }
				$.ajax({
                    type: "POST",
                    url: "timetable_modify_slot",
                    data: post_data,
                    success: function(data) {
                        // return success
                        if (data.length > 0) {
                            event.color = "#000066";
                            $('#calendar').fullCalendar('updateEvent', event);
                        }
                    }
                });
			},
            eventDrop: function(event, delta, revertFunc) {
                //move callback
                var post_data = {
                    "id": event.id,
                    "assigned": event.assigned,
                    "start": moment(event.start).format("YYYY-MM-DD HH:mm:ss"),
                    "end": moment(event.end).format("YYYY-MM-DD HH:mm:ss")
                }
				$.ajax({
                    type: "POST",
                    url: "timetable_modify_slot",
                    data: post_data,
                    success: function(data) {
                        // return success
                        if (data.length > 0) {
                            event.color = "#000066";
                            $('#calendar').fullCalendar('updateEvent', event);
                        }
                    }
                });
			},
            eventReceive: function(event){
                //external event drop callback
                console.log(event);
                var post_data = {
                    "start": moment(event.start).format("YYYY-MM-DD HH:mm:ss"),
                    "end": moment(event.end).format("YYYY-MM-DD HH:mm:ss"),
                    "assigned": event.assigned
                }
				$.ajax({
                    type: "POST",
                    url: "timetable_new_slot",
                    data: post_data,
                    success: function(data) {
                        // return success
                        if (data.length > 0) {
                            response = $.parseJSON(data);
                            event.id = response.id;
                        }
                    }
                });
			}
		});
		


	});

</script>
	<!-- Copy Schedule Modal -->
	<div id="copyModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Copy selected schedules</h4>
	      </div>
	      <div class="modal-body">
	        <p>Select start date: <input type="text" class="modaldate" id="startDate"></p>
	        <p>Select end date: <input type="text" class="modaldate" id="endDate"></p>
	        <p>Copy to date and forth: <input type="text" class="modaldate" id="copyStartDate"></p>
	        <p>Remember to save <b>before</b> copying!</p>
	      </div>
	      <div class="modal-footer">
		    <a type="button" class="btn btn-success" onclick="copySchedules();">Copy</a>
	      	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	
	  </div>
	</div>
	<!-- Remove Schedule Modal -->
	<div id="removeModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Remove selected schedules</h4>
	      </div>
	      <div class="modal-body">
	        <p>Select start date: <input type="text" class="modaldate" id="remove_startDate"></p>
	        <p>Select end date: <input type="text" class="modaldate" id="remove_endDate"></p>
	      </div>
	      <div class="modal-footer">
	      	<a type="button" class="btn btn-danger" onclick="removeSchedules();">
            	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
            </a>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	
	  </div>
	</div>
    <!-- Event Modal -->
    <div id="eventModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="event_header">Modal Header</h4>
          </div>
          <div class="modal-body">
            <p>Some text in the modal.</p>
          </div>
          <div class="modal-footer">
                <a id="event_remove_button" type="button" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Remove
                    <!-- Modal with selectable days -->
                </a>
                <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </div>

      </div>
    </div>
	<div class="col-md-2">
		<h4>Supervisors</h4>
		<ul class="list-group" id='external-events'>
		<?php foreach ($admins as $row ) {?>
			<li class='fc-event list-group-item' id="<?php echo $row->id ?>" data-event='1' data-assigned='<?=$row->id?>'><?php echo $row->name; ?>(<?php echo$row->email ?>)</li>
		<?php }?>
		</ul>
	</div>
	<div class="col-md-10" id='calendar'></div>
</div>
