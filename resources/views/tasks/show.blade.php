@extends('adminlte::page')
@section('styles')
    {!! Html::style('src/css/dropzone.css') !!}
@section('title', 'Tarea')
@section('content_header')
    <div class="header">
      <h1>{{ $task->title }}</h1>
    </div>
    <p class="text-muted well">{{ $task->description }}</p>
    <!-- detalle inline de la tarea-->
    <ul class="list-inline">
    	<li>
    		<i class="fa fa-user"> </i><strong> Asignada a: </strong> -{{ $task->user->username }}
    	</li>
    	<li>
    		<i class="fa fa-folder-open"> </i><strong> Proyecto: </strong> -{{ $task->project->title}}
    	</li>
    	<li>
    		<i class="fa fa-clock-o"> </i> <strong>Fecha limite: </strong> -{{ $task->end_date->format('d/m/Y') }}
    	</li>
      <li>
        <i class="fa fa-exclamation "></i> <strong>Estado: </strong> -{{ $task->status }}
      </li>
    </ul>
@endsection
@section('content')
<div class="row">
{{-- solo puede aprovar un investigador o director --}}
@can('approve-task', $task)
  @if($task->status != 'Finalizado')
    @include('tasks.partials.approve_refuse_form')
  @else
    <div class="alert alert-info col-md-6 col-md-offset-1">
      <p class="text-center"><h2>Esta tarea no admite comentarios!</h2></p>
    </div>
  @endif
@endcan
</div>
<div class="row">
	<div class="box box-info">
      <div class="box-header with-border">
          <h3 class="box-title">Archivos: </h3>
              <div class="box-tools pull-right">
                  <button type="button" class="b tn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
      </div>
      <div class="box-body">
     				@can('answer-task', $task)
              @can('owner-task', $task)
                @include('tasks.select-files')
              @endcan
              <div class="col-md-5">
                <table class="table">
                  @foreach($task->files as $file )
                  <tr>
                    <td><i class="fa fa-download"> - {{link_to_route('file.download', $title = $file->original_filename, $parameters=[ $file->filename] , $attributes=[])}}</i></td>
                  </tr>
                  @endforeach
                </table>
              </div>  
            @endcan
      </div>
  </div>
</div>
@can('owner-task', $task)
  <div class="row">
    <div class="col-md-6">
      {{-- Si no esta vencida o finalizada la tarea--}}
        @can('answer-task', $task)
          <h3>Responder</h3>
            @include('tasks.partials.comment_form', ['action' => route('tasks.comment', [$task->slug])])
        @else
          <div class="alert alert-info">
            <p class="text-center"><h2>Esta tarea no admite comentarios!</h2></p>
          </div>
        @endcan
    </div>
  </div>
@endcan
<div class="row">
      <div class="col-md-9 col-md-offset-1">
      <h2>Respuestas</h2>
          @if($task->comments()->count() > 0)
              @foreach($task->comments as $comment)
                  @include('tasks.partials.comment', ['comment' => $comment])
              @endforeach
          @else
              <p>Todavia no hay respuestas!!</p>
          @endif
    </div>
</div>
@endsection
@section('js')
	<script>
$(document).ready(function() {
    $("#select-user").hide();
    $("#select-user-label").hide();
    $("#select-user option").prop("selected", false);        
    $('.reply-link').click(createForm);

    function createForm(e)
    {
        e.preventDefault();

        var form = [];
        form[form.length] = '<form class="reply-form" action="' + $(this).data('url')
 + '" method="post">';
        form[form.length] = '   {!! csrf_field() !!}';
        form[form.length] = '   <div class="form-group">';
        form[form.length] = '   <input type="hidden" name="task" value="{{$task->slug}}">';
        form[form.length] = '       <label for="body">Respuesta:</label>';
        form[form.length] = '       <textarea class="form-control" name="body"></textarea>';
        form[form.length] = '   </div>';
        form[form.length] = '   <div class="form-group">';
        form[form.length] = '       <button class="btn btn-default" type="submit">Responder</button>';
        form[form.length] = '   </div>';
        form[form.length] = '</form>';

        $(this).replaceWith(form.join(''));
    }
        $("#approve-refuse").change(function(){
            if($(this).val() == "3"){
                $("#select-user").show();
                $("#select-user-label").show();
                
            }else{
                $("#select-user").hide();
                $("#select-user-label").hide();
                $("#select-user option").prop("selected", false);
            }
        });

});
</script>
    {!! Html::script('src/js/dropzone.js') !!}
    {!! Html::script('app/tasks/dropzone-script.js') !!}
@endsection