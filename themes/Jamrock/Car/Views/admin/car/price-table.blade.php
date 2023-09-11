<div class="form-group-item">
    <label class="control-label">{{__('Pricing Table')}}</label>
    <div class="g-items-header">
        <div class="row">
            <div class="col-md-4">{{__("Google Distance (km)")}}</div>
            <div class="col-md-4">{{__('One Way')}}</div>
            <div class="col-md-3">{{__('Round Trip')}}</div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-4 d-flex align-items-center justify-content-between">
                <div>From KM</div>
                <div>To KM</div>
            </div>
            <div class="col-md-3 d-flex align-items-center justify-content-between">
                <div>Price</div>
                <div>Discount</div>
            </div>
            <div class="col-md-3 d-flex align-items-center justify-content-between">
                <div>Price</div>
                <div>Discount</div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <div class="g-items">
        @if(!empty($row->prices))
            @foreach($row->prices as $key=>$price)
                <div class="item" data-number="{{$key}}">
                    <div class="row">
                        <div class="col-md-4 d-flex">
                            <div><input type="number" min="0" step="1" name="prices[{{$key}}][from]" class="form-control" value="{{$price->from}}" placeholder=""></div>
                            <div><input type="number" min="0" step="1" name="prices[{{$key}}][to]" class="form-control" value="{{$price->to}}" placeholder=""></div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div><input type="number" min="0" step="1" name="prices[{{$key}}][oneway_price]" class="form-control" value="{{$price->oneway_price}}" placeholder=""></div>
                            <div><input type="number" min="0" step="1" name="prices[{{$key}}][oneway_discount]" class="form-control" value="{{$price->oneway_discount}}" placeholder=""></div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div><input type="number" min="0" step="1" name="prices[{{$key}}][roundtrip_price]" class="form-control" value="{{$price->roundtrip_price}}" placeholder=""></div>
                            <div><input type="number" min="0" step="1" name="prices[{{$key}}][roundtrip_discount]" class="form-control" value="{{$price->roundtrip_discount}}" placeholder=""></div>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="text-right">
        <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
    </div>
    <div class="g-more hide">
        <div class="item" data-number="__number__">
            <div class="row">
                <div class="col-md-4 d-flex">
                    <div><input type="number" min="0" step="1" __name__="prices[__number__][from]" class="form-control" placeholder=""></div>
                    <div><input type="number" min="0" step="1" __name__="prices[__number__][to]" class="form-control"  placeholder=""></div>
                </div>
                <div class="col-md-4 d-flex">
                    <div><input type="number" min="0" step="1" __name__="prices[__number__][oneway_price]" class="form-control"  placeholder=""></div>
                    <div><input type="number" min="0" step="1" __name__="prices[__number__][oneway_discount]" class="form-control"  placeholder=""></div>
                </div>
                <div class="col-md-3 d-flex">
                    <div><input type="number" min="0" step="1" __name__="prices[__number__][roundtrip_price]" class="form-control"  placeholder=""></div>
                    <div><input type="number" min="0" step="1" __name__="prices[__number__][roundtrip_discount]" class="form-control" placeholder=""></div>
                </div>
                <div class="col-md-1">
                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
