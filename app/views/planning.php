<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Planning des entretiens</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    header {
      background: #2c3e50;
      position: fixed;
      width: 100%;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    #external-events {
      position: fixed;
      left: 300px;
      top: 175px;
      width: 150px;
      padding: 0 10px;
      border: 1px solid #ccc;
      background: #eee;
      text-align: left;
    }

    #external-events h4 {
      font-size: 16px;
      margin-top: 0;
      padding-top: 1em;
    }

    #external-events .fc-event {
      margin: 3px 0;
      cursor: move;
    }

    #external-events p {
      margin: 1.5em 0;
      font-size: 11px;
      color: #666;
    }

    #external-events p input {
      margin: 0;
      vertical-align: middle;
    }

    #calendar {
      max-width: 790px;
      margin: auto;
      margin-left: 215px;
      margin-top: 15%;
    }
  </style>
  <script src="assets/js/index.global.js"></script>
</head>

<body>
  <header>
    <h2>Planning des entretiens</h2>
  </header>
  <div id="wrap">
    <div id="external-events">
      <h4>Candidats</h4>
      <div id="external-events-list">
        <?php if (!empty($data)): ?>
          <?php foreach ($data as $d): ?>
            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
              <div class='fc-even-maint'><?= $d['nom'] . " " . $d['prenom']; ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <p>
          <input type='checkbox' id='drop-remove' />
          <label for='drop-remove'>remove after drop</label>
        </p>
      </div>
    </div>
  </div>
  <div id="calendar-wrap">
    <div id="calendar"></div>
  </div>
  <script src="assets/js/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // Calendrier ======================
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function(arg) {
          // is the "remove after drop" checkbox checked?
          if (document.getElementById('drop-remove').checked) {
            // if so, remove the element from the "Draggable Events" list
            arg.draggedEl.parentNode.removeChild(arg.draggedEl);
          }
        },
        events: '/Recrutement/planning/events' // 🔥 va chercher les données en JSON
      });
      calendar.render();

      // =======================

      var containerEl = document.getElementById('external-events-list');
      new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function(eventEl) {
          return {
            title: eventEl.innerText.trim()
          }
        }
      });
    });
  </script>
</body>

</html>