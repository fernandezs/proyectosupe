<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-2">
            <img class="img img-rounded img-responsive" src="{{ asset($comment->user->image)}}"></img>
        </div>
        <p>{{ $comment->body }}</p>
        <small><b>{{ $comment->user->username }}</b> - {{ $comment->created_at }}</small>
    </div>
    @if($comment->user->id != Auth::user()->id)
        @can('answer-task', $task)
            <div class="panel-footer">
                <a class="btn btn-default reply-link" data-url="{{ route('comments.reply', [$comment->id]) }}">Responder tarea</a>
            </div>
        @endcan
    @endif
</div>

@if($comment->hasChildren())
    @foreach($comment->children as $child)
        @include('tasks.partials.comment_child', ['comment' => $child])
    @endforeach
@endif