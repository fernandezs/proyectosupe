<div class="pull-right">
	{!! Form::open(['route' => ['projects.destroy', $project->slug], 'method' => 'DELETE']) !!}
<button class="btn btn-danger btn-block" type="submit">
    <i class="fa fa-trash-o"></i> Eliminar proyecto
</button>
{!! Form::close() !!}
</div>