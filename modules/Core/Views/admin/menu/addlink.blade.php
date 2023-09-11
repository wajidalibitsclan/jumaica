@extends('admin.layouts.app')
@section('content')
<form action="" method="post" class="dungdt-form" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">Add New Link</h1>
                </div>
            </div>
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('link content')}}</strong></div>
                            <div class="panel-body">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Name')}}</label>
                                    <input type="text" value="" placeholder="Link title" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Link')}}</label>
                                    <input type="text" value="" placeholder="Link" name="link" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Icon')}}</label>
                                    <input type="file" value="" placeholder="Link Icon" name="icon" class="form-control">
                                </div>
                                <button class="btn-info btn btn-icon btn_submit" type="submit">{{__('Submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
