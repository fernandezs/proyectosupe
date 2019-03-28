@if($tasks_answers->count() == 0)
  <div class="container">
    <div class="jumbotron">
      <h2>Aun no hay respuestas</h2>
    </div>
  </div>
@else
  <table class="table table-striped table-bordered">
  <thead>
    <tr>
      <td>Usuario</td>
      <td>Tarea</td>
      <td>Respuesta</td>
      <td>Responder</td>
    </tr>
    <tbody>
      @foreach( $tasks_answers as $task )
        <tr>
          <td>{{ $task->user->username}}</td>
          <td>{{ $task->title}}</td>
          <td>{{ $task->comments()->first()['body'] }}</td>
          <td>
                <a href="{{ route('tasks.show', ['slug' => $task->slug])}}" data-toggle="tooltip" data-placement="top" title="Responder tarea" class="btn btn-sm btn-info"><i class="fa fa-share"></i></a>
            </td>
        </tr>
      @endforeach
    </tbody>
    </thead>
  </table>
@endif