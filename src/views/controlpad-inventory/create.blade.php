@extends('layouts.default')
@section('content')
<div class="create">
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">New Inventory</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3 col-md-4 col-sm-6">
            {{ Form::open(array('url' => $basepath)) }}
            
                {{ Form::hidden('inv-model','inventory')}}
        
                <div class="form-group">
                    {{ Form::label('warehouse_id', 'Warehouse') }}<br>
                    {{ Form::select('warehouse_id', $warehouses, null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('item_id', 'Item') }}<br>
                    {{ Form::select('item_id', $items, null, array('class' => 'form-control')) }}
                </div>
                               
                <div class="form-group">
                    {{ Form::label('quantity', 'Quantity') }}
                    {{ Form::number('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
                </div>
                                
                <div class="form-group">
                    {{ Form::label('address', 'Address') }}
                    {{ Form::text('address', Input::old('address'), array('class' => 'form-control')) }}
                </div>
                                
                <div class="form-group">
                    {{ Form::label('disabled', 'Status') }}
                    <br>
                    {{ Form::select('disabled', [
                        0 => 'Active',
                        1 => 'Disabled'
                    ], null, ['class' => 'form-control']) }}
                </div>
        
                {{ Form::submit('Add Inventory', array('class' => 'btn btn-primary')) }}
    
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
