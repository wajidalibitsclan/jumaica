

<div class="row">
    @foreach($dropdown as $item)
    <div class="col-md-6">
            <div class="form-group">
                <label>{{$item->title}} <span class="text-danger"> *</span></label>
                <select name="option[]" class="form-control">
                    <option value="">Please Select</option>
                    @foreach(\Themes\Jamrock\Booking\Models\Options::where('dropdown_id', $item->id)->get() as $option)
                        <option value="{{$option->id}}" {{(in_array($option->id, $translation->option)) ? 'selected' : ''}}>{{$option->title}}</option>
                    @endforeach
                </select>
            </div>
    </div>
    @endforeach
</div>
   {{-- <div class="col-md-6">
        <div class="form-group">
            <label>{{__("Dropdown")}} <span class="text-danger"> *</span></label>
            <select name="dropdown_id" class="form-control dropdown_list">
                <option value="">Please Select</option>
                @foreach($dropdown as $item)
                    <option value="{{$item->id}}" {{($translation->dropdown_id) == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{__("Options")}} <span class="text-danger"> *</span></label>
            <select name="option_id" class="form-control option_list">
                <option value="">Please Select</option>
                @if(isset($options))
                    @foreach($options as $item)
                        <option value="{{$item->id}}" {{($translation->option_id) == $item->id ? 'selected' : ''}}>{{$item->title}} - {{$item->value}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label>{{__("Person Type")}} <span class="text-danger"> *</span></label>
    <select name="person" class="form-control">
        <option value="adult" {{($translation->person) == 'adult'? 'selected' : ''}}>Adult</option>
        <option value="child" {{($translation->person) == 'child'? 'selected' : ''}}>Child</option>
    </select>
</div>--}}


<div class="form-group">
    <label>{{__("Price")}} <span class="text-danger"> *</span></label>
    <input type="text" required value="{{old('price',$translation->price)}}" placeholder="{{__("price")}}" name="price" class="form-control">
</div>


@push('js')
    <script>
        $(document).ready(function (){
            $('.dropdown_list').on('change', function (){
                var id = $(this).val();
                $.ajax({
                    url: '{{route('combination.admin.options')}}',
                    data: {
                        id: id,
                        _token: "{{csrf_token()}}",
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {
                        let buffer = '';
                        for (var i = 0; i < res.length; i++) {
                            buffer += '<option value='+res[i].id+'>'+res[i].title+' - '+res[i].value+'</option>';
                        }

                        $('.option_list').html(buffer);
                    }
                })
            })
        })

    </script>

@endpush
