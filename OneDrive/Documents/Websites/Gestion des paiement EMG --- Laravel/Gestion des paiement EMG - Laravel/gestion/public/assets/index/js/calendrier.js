// JavaScript code for log out button functionality
document.getElementById('logoutBtn').addEventListener('click', function() {
    // Add your log out logic here
    alert('Log out button clicked!');
});


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid' ],
        events: [
            {
                title: 'Mois Payé',
                start: '2024-03-01',
                end: '2024-03-31',
                color: 'green'
            },
            {
                title: 'Mois Non Payé',
                start: '2024-04-01',
                end: '2024-04-30',
                color: 'red'
            }
            // Ajoutez d'autres événements pour les mois payés et non payés selon votre logique
        ]
    });

    calendar.render();
});
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'googleCalendar' ],
        googleCalendarApiKey: 'AIzaSyDLlfUKs2BX3mI0QoMGF41L8UHgCCDv_eI',
        events: {
            googleCalendarId: 'VOTRE_ID_CALENDRIER_GOOGLE@group.calendar.google.com'
        }
    });
    calendar.render();
});
