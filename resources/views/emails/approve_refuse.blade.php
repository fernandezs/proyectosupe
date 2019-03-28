@if($status == 'assigned')
	@import('emails.reminder')
@else
<h1>Hola, {{ $task->user->username }}</h1>
<p>Tu tarea ah sido {{ $status }}</p>
@endif