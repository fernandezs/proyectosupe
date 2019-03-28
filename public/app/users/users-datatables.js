$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#users').DataTable({
        language: {
            url: 'http://localhost:8000/app/trans/Spanish.json'
        },
        "processing": true,
        "serverSide": true,
        "ajax": "http://localhost:8000/users/datatable",
        columns: [
            {data: 'id', name: 'id', title: 'ID'},
            {data: 'username', name: 'username', title: 'Nombre'},
            {data: 'email', name: 'email', title: 'Email'},
            {data: 'role', name: 'role', title: 'Rol'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});