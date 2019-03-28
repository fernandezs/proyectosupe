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




/*var project_id = $('#project_id').val();

$.get('http://localhost:8000/projects/'+ project_id +'/tasks', function(data) {
    $('#task_id').empty();
    //se rellena el selector del select de usuarios
    $.each(data, function(i, item){
        $('#task_id').append(
            '<option value="' + item.id + '">' + item.title + '</option>'
        );

    });
    
    $('#filter').on('change', function(event){
        $('#task_id').empty();
        var option = event.target.value;
        var filtered = $.grep( data, function( n, i ) {
            return n.state === option;
        });
        $.each(filtered, function(i, item){
            $('#task_id').append(
                '<option value="' + item.id + '">' + item.title + '</option>'
            );
        });
    });
});


$('#select-user').chosen(
    {
        no_results_text: "No se encontro al usuario!",
        placeholder_text_multiple: "Seleccione un usuario"
    }
);
$('#select-task').chosen(
    {
        no_results_text: "No se encontro al usuario!",
        placeholder_text_multiple: "Seleccione un usuario"
    }
);
*/