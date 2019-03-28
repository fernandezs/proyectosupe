var project_id = $('#project_id').val();
var user_id = $('#user').val();

$.get('http://localhost:8000/projects/users-group/'+ project_id +'', function(data) {
    $('#user_id').empty();
    //se rellena el selector del select de usuarios
    $.each(data, function(i, item){
        $('#user_id').append(
            '<option value="' + item.id + '">' + item.username + '</option>'
        );

    });
    $('#user_id > option[value = "'+ user_id +'"]').attr('selected', 'selected');
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

$('#project_id').on('change', function(event)
{
    project_id = $('#project_id').val();
    console.log(project_id);
    //cuando cambiar el selector de projecto se resetea el index del filtro
    $("#filter").prop("selectedIndex", 0);

    var group_id = event.target.value;
    //ajax para obtener todos los usuarios correspondientes al grupo
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
    todayHighlight: true,
    autoclose: true
});
$('#end_date').datepicker({
    format: "dd/mm/yyyy",
    language: "es"
});