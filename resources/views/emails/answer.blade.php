<h2>Hola {{ $user->username}}</h2>
<p>han respondido a la tarea, checkealo aqui: {{ link_to_route('tasks.show', $title="Click para abrir", $parameters = [$task->getSlug()], $attributes = []) }}</p>