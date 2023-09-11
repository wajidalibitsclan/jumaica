<div class="form-group">
    <label>{{__("Title")}} <span class="text-danger"> *</span></label>
    <input type="text" value="{{old('title',$translation->title)}}" placeholder="{{__("Title")}}" name="title" class="form-control">
</div>
<div class="form-group">
    <label class="control-label">{{__("Content")}}</label>
    <div class="">
        <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label">{{__("Category")}}</label>
    <div class="">
        <select name="type" class="form-control">
            <option value="">{{__("-- Please Select --")}}</option>
            <?php
            $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
                foreach ($categories as $category) {
                    $selected = '';
                    if ($row->type == $category->id)
                        $selected = 'selected';
                    printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                    $traverse($category->children, $prefix . '-');
                }
            };
            $traverse($faq_category);
            ?>
        </select>
    </div>
</div>
