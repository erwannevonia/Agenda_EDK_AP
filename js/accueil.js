document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {

    initialView: 'dayGridMonth', // Vue par défaut : affichage mensuel
    locale: 'fr', // Met le calendrier en français (optionnel)
    
    // Récupère les événements depuis le script PHP
    events: '../inc/affichageEvenements.php', // Charge les devoirs enregistrés en base de données
    
    eventColor: '#007bff', // Couleur par défaut des événements (optionnel)

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    initialDate: '2024-11-01',
    editable: true,
    selectable: true,
  });
  calendar.render();
});

