<div class="pull-right">
	{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
    <button class="btn btn-danger" type="submit">
        <i class="fa fa-trash-o"></i> Eliminar usuario
    </button>
	{!! Form::close() !!}
</div>