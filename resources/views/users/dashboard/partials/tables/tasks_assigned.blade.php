<table class="table table-striped table-bordered" id="users">
    <thead>
        <tr>
            <td>Titulo</td>
            <td>Proyecto</td>
            <td>Fecha Limite</td>
            <td>Estado</td>
        </tr>
        </thead>
        <tbody>
        @foreach( $tasks_assigned as $task )
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->project->title }}</td>
                <td>{{ $task->end_date->format('d/m/Y') }}</td>
                <td>{{ $task->status }}</td>
                <td>
                    <a href="{{ route('tasks.show', ['slug' => $task->slug])}}" data-toggle="tooltip" data-placement="top" title="Responder tarea" class="btn btn-sm btn-info"><i class="fa fa-share"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
</table>