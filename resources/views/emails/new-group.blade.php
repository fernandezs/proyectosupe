<h1>Hola, {{ $user->username }}</h1>
<p>Has sigo asignado a un nuevo grupo de investigacion</p>
<p>Link del grupo: {{ link_to_route('users.groups.show', $title="Click para abrir", $parameters = [$group->getSlug()], $attributes = []) }}</p>