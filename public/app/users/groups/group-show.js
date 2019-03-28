$(document).ready(function() {
    $('#users').dataTable({
        language: {
            url: 'http://localhost:8000/app/trans/Spanish.json'
        },
        "processing": true
    });
    $('#tasks').dataTable({
        language: {
            url: 'http://localhost:8000/app/trans/Spanish.json'
        },
        "processing": true
    });
} );