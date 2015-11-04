<div class="container">
	<div class="btn-toolbar">
		<button type="button" class="btn btn-success">
			<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
			<!-- Modal with two calendars -->
		</button>
		<span class="btn-separator"></span>
		<button type="button" class="btn btn-primary">
			<span class="glyphicon glyphicon-copy" aria-hidden="true"></span> Copy schedule...
			<!-- Modal with two calendars -->
		</button>
		<button type="button" class="btn btn-danger">
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

	$(document).ready(function() {


		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true // maintain when user navigates (see docs on the renderEvent method)
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
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			allDayDefault: false,
			defaultTimedEventDuration: '08:00:00',
			editable: true,
			droppable: true, // this allows things to be dropped onto the calendar
			schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
			eventClick: function(event, element) {
				event.title = "CLICKED!";
				//open modal/tooltip for deletion and manual data entry
				$('#calendar').fullCalendar('updateEvent', event);
			},
			editable: true,
			eventResize: function(event, delta, revertFunc) {
				//event resize callback
				alert(event.title + " end is now " + event.end.format());

				if (!confirm("is this okay?")) {
					revertFunc();
				}

			},
			 eventDrop: function(event, delta, revertFunc) {
				//event move callback
				alert(event.title + " was dropped on " + event.start.format());

				if (!confirm("Are you sure about this change?")) {
					revertFunc();
				}

			},
			drop: function(date, jsEvent, ui) {
				//external event drop callback
				alert("Hello!");
			}
		});
		


	});

</script>
	<div class="col-md-2">
		<h4>Supervisors</h4>
		<ul class="list-group" id='external-events'>
		<?php foreach ($admins as $row ) {?>
			<li class='fc-event list-group-item' id="<?php echo $row->id ?>" ><?php echo $row->name; ?>(<?php echo$row->email ?>)</li>
		<?php }?>
		</ul>
	</div>
	<div class="col-md-10" id='calendar'></div>
</div>
