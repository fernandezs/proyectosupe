$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#tasks').DataTable({
        language: {
            url: 'http://localhost:8000/app/trans/Spanish.json'
        },
        "processing": true,
        "serverSide": true,
        "ajax": "http://localhost:8000/tasks/datatable",
        columns: [
            {data: 'title', name: 'title', 'title': 'Titulo:'},
            {data: 'user_id', name: 'user_id', 'title': 'Perteneciente a:'},
            {data: 'end_date', name: 'end_date', 'title': 'Fecha Limite:'},
            {data: 'status', name: 'status', 'title': 'Estado:'},
            {data: 'project_id', name: 'project_id', 'title': 'Proyecto:'},
            {data: 'action', name: 'action','title':'Acciones:', orderable: false, searchable: false}
        ]
    });
});