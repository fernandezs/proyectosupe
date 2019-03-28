<div class="jumbotron">
	<div class="container">
		<h1>Hola {{ $task->user->username}}</h1>
		<p>Se te ah asignado a una nueva tarea, aqui el detalle:</p>
		<p><em><strong>{{ $task->description }}</strong></em></p>
		<p>tienes tiempo hasta {{ $task->end_date->format('d/m/Y')}} para terminarla, suerte!!</p>
		<p>Link de la tarea: {{ link_to_route('tasks.show', $title="Click para abrir", $parameters = [$task->getSlug()], $attributes = []) }}</p>
	</div>
</div>

