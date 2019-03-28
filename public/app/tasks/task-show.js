$(document).ready(function() {
    $('.reply-link').click(createForm);

    function createForm(e)
    {
        e.preventDefault();

        var form = [];
        form[form.length] = '<form class="reply-form" action="' + $(this).data('url')
 + '" method="post">';
        form[form.length] = '   {!! csrf_field() !!}';
        form[form.length] = '   <div class="form-group">';
        form[form.length] = '       <label for="body">Respuesta</label>';
        form[form.length] = '       <textarea class="form-control" name="body"></textarea>';
        form[form.length] = '   </div>';
        form[form.length] = '   <div class="form-group">';
        form[form.length] = '       <button class="btn btn-default" type="submit">Responder</button>';
        form[form.length] = '   </div>';
        form[form.length] = '</form>';

        $(this).replaceWith(form.join(''));
    }
});