@extends('admin.layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Faq")}}</h1>
        </div>
        @include('admin.message')
        <div class="row">
            <div class="col-md-12">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        @if(!empty($rows))
                            <form method="post" action="{{ route('faq.admin.bulkedit') }}" class="filter-form filter-form-left d-flex justify-content-start">
                                {{csrf_field()}}
                                <select name="action" class="form-control">
                                    <option value="">{{__(" Bulk Action ")}}</option>
                                    <option value="delete">{{__(" Delete ")}}</option>
                                </select>
                                <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                            </form>
                        @endif
                    </div>
                    <div class="col-left">
                        <a href="{{ route('faq.admin.create') }}" class="btn btn-primary">Add new faq</a>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th>{{__("Title")}}</th>
                                    <th width="200px"> {{ __('Category') }}</th>
                                    <th class="date">{{__("Date")}}</th>
                                    <th style="width: 150px">{{ __("Actions") }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( count($rows) > 0)
                                    @foreach($rows as $row)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{$row->id}}" class="check-item">
                                        <td class="title">
                                            <a href="{{ route('faq.admin.edit', $row->id) }}">{{$row->title}}</a>
                                        </td>
                                        <td>{{ $row->category->name }}</td>
                                        <td>{{ display_date($row->updated_at)}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('faq.admin.edit', ['id' => $row->id]) }}">Edit</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{__("No data")}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            {{$rows->appends(request()->query())->links()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
