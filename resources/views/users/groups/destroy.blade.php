<div class="pull-right">
	{!! Form::open(['route' => ['users.groups.destroy', $group->slug], 'method' => 'DELETE']) !!}
	<button class="btn btn-danger btn-block" type="submit">
	    <i class="fa fa-trash-o"></i> Eliminar grupo
	</button>
{!! Form::close() !!}
</div>