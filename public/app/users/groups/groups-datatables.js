$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#groups').DataTable({
        language: {
            url: 'http://localhost:8000/app/trans/Spanish.json'
        },
        "processing": true,
        "serverSide": true,
        "ajax": "http://localhost:8000/users/groups/datatable",
        columns: [
            {data: 'id', name: 'id', 'title': 'ID:'},
            {data: 'name', name: 'name','title':'Nombre:'},
            {data: 'user_id', name: 'user_id','title':'Director:'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});