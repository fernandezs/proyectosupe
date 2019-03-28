<h1>Hola, {{ $user->username }}</h1>
<p>La tarea <em>"<strong>{{ $task->title }}"</strong></em>, finaliza el <strong>{{ $task->end_date->format('d/m/Y')}}</strong></p>
<br>
<p>Responder a la tarea o deja aqui tus avances: {{ link_to_route('tasks.show', $title="Click para responder", $parameters = [$task->getSlug()], $attributes = []) }}</p>