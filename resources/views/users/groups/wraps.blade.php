<select name="investigators_selected[]" id="select-investigator" class="form-control select-investigators" multiple>
    @foreach($investigators_all as $investigator)
        @if(in_array($investigator, $investigators->toArray()))
            <option value="{{$investigator['id']}}" selected>{{ $investigator }}</option>
        @else
            <option value="{{ $investigator }}">{{$investigator}}</option>
        @endif
    @endforeach
</select>