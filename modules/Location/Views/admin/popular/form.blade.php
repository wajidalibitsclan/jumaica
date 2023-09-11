<div class="form-group">
    <label>{{__("Name")}} <span class="text-danger">*</span></label>
    <input type="text" required value="{{$translation->name}}" placeholder="{{__("Location name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Type")}} <span class="text-danger">*</span></label>
    <select name="type" class="form-control">
        <option value="Airports" {{($row['type']) == 'Airports' ? 'selected' : ''}}>Airports</option>
        <option value="Hotels" {{($row['type']) == 'Hotels' ? 'selected' : ''}}>Hotels</option>
        <option value="Ports" {{($row['type']) == 'Ports' ? 'selected' : ''}}>Ports</option>
    </select>
</div>

<div class="form-group">
    <label class="control-label">{{__("The geographic coordinate")}}</label>
    <div class="control-map-group">
        <div id="map_content"></div>
        <input type="text" placeholder="{{__("Search by name...")}}" class="bravo_searchbox form-control" autocomplete="off" onkeydown="return event.key !== 'Enter';">
        <div class="g-control">
            <div class="form-group">
                <label>{{__("Map Latitude")}}:</label>
                <input type="text" required name="map_lat" class="form-control" value="{{$row->map_lat}}">
            </div>
            <div class="form-group">
                <label>{{__("Map Longitude")}}:</label>
                <input type="text" required name="map_lng" class="form-control" value="{{$row->map_lng}}">
            </div>
            <div class="form-group">
                <label>{{__("Map Zoom")}}:</label>
                <input type="text" name="map_zoom" class="form-control" value="{{$row->map_zoom ?? "8"}}">
            </div>
        </div>
    </div>
</div>
