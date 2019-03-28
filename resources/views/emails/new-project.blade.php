<div class="jumbotron">
	<div class="container">
		<h1>Hola {{ $user->username }}</h1>
		<p>Se te ah asignado a un nuevo projecto, aqui el detalle:</p>
		<p><em><strong>{{ $project->description }}</strong></em></p>
		<p>Link del proyecto: {{ link_to_route('projects.show', $title="Click para abrir", $parameters = [$project->getSlug()], $attributes = []) }}</p>
	</div>
</div>
