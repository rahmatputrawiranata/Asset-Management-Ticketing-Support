<div class="form-group">
    <div class="col-form-label">{{$title}}</div>
    <select class="form-controller select2" style="width: 100%" name="{{$name}}" id="{{$name}}">
        @foreach ($options as $item)
            <option value="{{$item->value}}">{{$item->title}}</option>
        @endforeach
    </select>
</div>
