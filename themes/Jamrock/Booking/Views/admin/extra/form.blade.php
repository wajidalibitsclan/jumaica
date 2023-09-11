<div class="form-group">
    <label>{{__("Title")}} <span class="text-danger"> *</span></label>
    <input type="text" required value="{{old('title',$translation->title)}}" placeholder="{{__("title")}}" name="title" class="form-control">
</div>

<div class="form-group">
    <label>{{__("Image")}} </label>
    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
</div>
<div class="form-group">
    <label>{{__("Youtube Video URL")}}</label>
    <input type="text" value="{{old('video_url',$translation->video_url)}}" placeholder="" name="video_url" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Price")}}</label>
    <input type="number" min="0" step="any" value="{{old('price',$row->price)}}" placeholder="" name="price" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Display Order")}}</label>
    <input type="number" min="1" value="{{old('display_order',$row->display_order)}}" placeholder="" name="display_order" class="form-control">
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="form-group">
    <label>{{__("Dropdown")}} <span class="text-danger"> *</span></label>
    <select name="dropdown[]" class="form-control select2" multiple>
        <option value="">Please Select</option>
            @foreach(\Themes\Jamrock\Booking\Models\Dropdown::all() as $item)
                <option value="{{$item->id}}" {{(in_array($item->id, $translation->dropdown)) ? 'selected' : ''}}>{{$item->title}}</option>
            @endforeach
    </select>
</div>
@include('Booking::admin.extra.include-exclude')



@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2();
        })
    </script>

@endpush
