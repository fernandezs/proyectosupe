$('#project_id').on('change', function(event)
{
    //cuando cambiar el selector de grupo se resetea el index del filtro
    $("#filter").prop("selectedIndex", 0);

    var project_id = event.target.value;
    //ajax para obtener todos los usuarios correspondientes al proyecto
    $.get('http://localhost:8000/projects/users-group/'+ project_id +'', function(data){
        $('#user_id').empty();
        //se rellena el selector del select de usuarios
        $.each(data, function(i, item){
            $('#user_id').append(
                '<option value="' + item.id + '">' + item.username + '</option>'
            );
        });
        //cuando filtras un selector
        $('#filter').on('change', function(event){
            $('#user_id').empty();
            var option = event.target.value;
            var filtered = $.grep( data, function( n, i ) {
                return n.role === option;
            });
            $.each(filtered, function(i, item){
                $('#user_id').append(
                    '<option value="' + item.id + '">' + item.username + '</option>'
                );
            });
        });
    });
});

$('#start_date').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    
});
$('#end_date').datepicker({
    format: "dd/mm/yyyy",
    language: "es"
});




