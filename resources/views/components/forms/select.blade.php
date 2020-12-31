<div class="form-group">
    <div class="col-form-label">{{$title}}</div>
    <select class="form-controller select2" style="width: 100%" name="{{$name}}" id="{{$name}}">
            @if(count($options) > 0)
                @foreach ($options as $item)
                    <option value="{{$item->value}}">{{$item->title}}</option>
                @endforeach
            @else
                {{$slot}}
        @endif
    </select>
</div>
