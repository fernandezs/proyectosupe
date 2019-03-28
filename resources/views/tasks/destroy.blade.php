<div class="pull-right">
	{!! Form::open(['route' => ['tasks.destroy', $task->slug], 'method' => 'DELETE']) !!}
<button class="btn btn-danger btn-block" type="submit">
    <i class="fa fa-trash-o"></i> Eliminar tarea
</button>
{!! Form::close() !!}
</div>