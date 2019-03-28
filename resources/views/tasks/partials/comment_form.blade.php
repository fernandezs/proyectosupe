<form action="{{ $action }}" method="POST">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="body">Respuesta:</label>
        <textarea class="form-control" name="body"></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-default" type="submit">Responder</button>
    </div>
</form>