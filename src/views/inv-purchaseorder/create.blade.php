@extends('layouts.default')
@section('content')
<div class="create">
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">New Purchaseorder</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3 col-md-4 col-sm-6">
            {{ Form::open(array('url' => $basepath)) }}
                
                <div class="form-group">
                    {{ Form::label('vendor_id', 'Vendor') }}<br>
                    {{ Form::select('vendor_id',$vendors, null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('ordered_on', 'Ordered On') }}
                    {{ Form::text('ordered_on', Input::old('ordered_on'), array('class' => 'form-control dateonlypicker')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('due_on', 'Due On') }}
                    {{ Form::text('due_on', Input::old('received_on'), array('class' => 'form-control dateonlypicker')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('disabled', 'Status') }}
                    <br>
                    {{ Form::select('disabled', [
                        0 => 'Active',
                        1 => 'Disabled'
                    ], null, ['class' => 'form-control']) }}
                </div>
        
                {{ Form::submit('Add Purchaseorder', array('class' => 'btn btn-primary')) }}
    
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
