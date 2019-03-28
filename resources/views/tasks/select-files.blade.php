<div class="col-md-7">
    <div class="panel panel-info">
        <div class="panel panel-body">
            {!! Form::open(['route' => ['tasks.addFiles', $task->slug], 'method' => 'POST', 'files' => 'true', 'class' => 'dropzone', 'id' => 'my-dropzone']) !!}
                <div class="dz-message">
                    Adjuntar archivos de respaldo

                </div>
                <div class="dropzone-previews"></div>
            <div class="dz-preview dz-file-preview">
                <div class="dz-details">
                    <div class="dz-filename"><span data-dz-name></span></div>
                    <div class="dz-size" data-dz-size></div>
                    <img data-dz-thumbnail />
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <div class="dz-success-mark"><span>✔</span></div>
                <div class="dz-error-mark"><span>✘</span></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
            </div>
                <button type="submit" class="btn btn-success" id="submit">Guardar</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
