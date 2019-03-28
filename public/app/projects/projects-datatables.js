$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#projects').DataTable({
        language: {
            url: 'http://localhost:8000/app/trans/Spanish.json'
        },
        "processing": true,
        "serverSide": true,
        "ajax": "http://localhost:8000/projects/datatable",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title', title: 'Titulo'},
            {data: 'keyword', name: 'keyword', title: 'Palabra clave'},
            {data: 'user_id', name: 'user_id', title: 'Creado por:'},
            {data: 'group_id', name: 'group_id', title: 'Grupo:'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});