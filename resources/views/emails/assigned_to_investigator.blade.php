<h1>Hola, {{ $user->username}}</h1>
<p>Se te ah asignado como investigador en el proyecto <strong>{{ $project->title }}.</strong></p>
<p>Dirigete al proyecto para mas informacion: {{ link_to_route('projects.show', $title="Click para abrir", $parameters = [$project->getSlug()], $attributes = []) }}</p>