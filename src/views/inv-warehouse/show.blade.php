@extends('layouts.default')
@section('content')
<div class="show">
    <div class="row">
        <div class="col-md-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">{{ $warehouse->name }}</h1>
            @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
                <div class="page-actions">
                    <div class="btn-group" id="record-options">
                        <a class="btn btn-default" href="{{ url($basepath.'/'.$warehouse->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
                        @if ($warehouse->disabled == 0)
                            {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'DISABLE')) }}
                                <input type="hidden" name="ids[]" value="{{ $warehouse->id }}">
                                <button class="btn btn-default active" title="Currently enabled. Click to disable.">
                                    <i class="fa fa-eye"></i>
                                </button>
                            {{ Form::close() }}
                        @else
                            {{ Form::open(array('url' => $basepath.'/enable', 'method' => 'ENABLE')) }}
                                <input type="hidden" name="ids[]" value="{{ $warehouse->id }}">
                                <button class="btn btn-default" title="Currently disabled. Click to enable.">
                                    <i class="fa fa-eye"></i>
                                </button>
                            {{ Form::close() }}
                        @endif
                        {{ Form::open(array('url' => $basepath.'/' . $warehouse->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this warehouse? This cannot be undone.");')) }}
                            <button class="btn btn-default" title="Delete">
                                <i class="fa fa-trash" title="Delete"></i>
                            </button>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        </div><!-- col -->
    </div><!-- row -->
    <div class="row">
        <div class="col col-md-6 center">
        </div>
        <div class="col col-md-6">
            <table class="table">
                <tr>
                    <th>ID:</th>
                    <td>{{ $warehouse->id }}</td>
                </tr>
                <tr>
                    <th>Address 1:</th>
                    <td>{{ $warehouse->address->address_1 }}</td>
                </tr>
                <tr>
                    <th>Address 2:</th>
                    <td>{{ $warehouse->address->address_2 }}</td>
                </tr>
                <tr>
                    <th>City:</th>
                    <td>{{ $warehouse->address->city }}</td>
                </tr>
                <tr>
                    <th>State:</th>
                    <td>{{ $warehouse->address->state }}</td>
                </tr>
                <tr>
                    <th>Zip:</th>
                    <td>{{ $warehouse->address->zip }}</td>
                </tr>
                @if ($warehouse->name != '')
                    <tr>
                        <th>Name:</th>
                        <td>{{ $warehouse->name }}</td>
                    </tr>
                @endif
                
                <tr>
                    <th>Status:</th>
                    <td>{{ $warehouse->disabled  ? "Disabled": "Active"}}</td>
                </tr>
                
            </table>
        </div>
    </div>dsfgsdfgdsfgsdf
    <div class='row'>
        <table class='table table-bordered'>
            <tr>
                <td>Items</td>
                <td>Quantity</td>
                <td>Address</td>
            </tr> 
            @foreach($w_inventories as $w_inventory)
            <tr>
                <td>{{$w_inventory->item->name}}</td>
                <td>{{$w_inventory->quantity}}</td>
                <td>{{$w_inventory->address->address_1}}</td>
            </tr>  
            @endforeach         
        </table>        
    </div>
</div>
@stop