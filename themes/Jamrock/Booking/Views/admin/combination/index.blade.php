@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Extra Combination")}}</h1>
        </div>

        @include('admin.message')
        <div class="row">
            <div class="col-md-12">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        @if(!empty($rows))
                            <form method="post" action="{{ route('combination.admin.bulkedit') }}" class="filter-form filter-form-left d-flex justify-content-start">
                                {{csrf_field()}}
                                <select name="action" class="form-control">
                                    <option value="">{{__(" Bulk Action ")}}</option>
                                    {{-- <option value="publish">{{__(" Publish ")}}</option>
                                    <option value="draft">{{__(" Move to Draft ")}}</option> --}}
                                    <option value="delete">{{__(" Delete ")}}</option>
                                </select>
                                <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                            </form>
                        @endif
                    </div>
                    <div class="col-left">
                        {{-- <form method="get" action="" class="filter-form filter-form-right d-flex justify-content-end" role="search">
                            <input type="text" name="s" value="{{ Request()->s }}" class="form-control" placeholder="{{__("Search by name")}}">
                            <button class="btn-info btn btn-icon btn_search" id="search-submit" type="submit">{{__('Search')}}</button>
                        </form> --}}
                        <a href="{{route('combination.admin.create')}}" class="btn btn-primary">Add new combination</a>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th>{{__("Combination")}}</th>
                                    <th>{{__("Price")}}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( count($rows) > 0)
                                    @foreach($rows as $row)
                                        <tr>
                                            <td><input type="checkbox" name="ids[]" value="{{$row->id}}" class="check-item">
                                            <td>
                                                @foreach($row->option as $option)

                                                    @if(\Themes\Jamrock\Booking\Models\Options::find($option))

                                                        {{\Themes\Jamrock\Booking\Models\Options::find($option)->title}}
                                                    @endif

                                                    @if(!($loop->last))
                                                        -
                                                    @endif
                                                @endforeach
                                            </td>

                                            <td>${{ ucwords($row->price)}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="{{ route('combination.admin.edit', ['id' => $row->id]) }}">Edit</a>
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

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
