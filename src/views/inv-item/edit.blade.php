@extends('layouts.default')
@section('content')
<div class="create">
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">Edit Item</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3 col-md-4 col-sm-6">
            {{ Form::model($item, array('route' => array($basepath.'.update', $item->id), 'method' => 'PUT')) }}
                
                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('weight', 'Weight') }}
                    {{ Form::text('weight', Input::old('weight'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('volume', 'Volume') }}
                    {{ Form::text('volume', Input::old('volume'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('inventory_number', 'Inventory Number') }}
                    {{ Form::text('inventory_number', Input::old('inventory_number'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('mfg_sku', 'MFG SKU') }}
                    {{ Form::text('mfg_sku', Input::old('mfg_sku'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('disabled', 'Status') }}
                    <br>
                    {{ Form::select('disabled', [
                        0 => 'Active',
                        1 => 'Disabled'
                    ], null, ['class' => 'form-control']) }}
                </div>
        
                {{ Form::submit('Update Item', array('class' => 'btn btn-primary')) }}
    
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
