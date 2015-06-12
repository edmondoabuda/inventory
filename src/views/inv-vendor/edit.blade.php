@extends('layouts.default')
@section('content')
<div class="create">
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">Edit Vendor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3 col-md-4 col-sm-6">
            {{ Form::model($vendor, array('route' => array($basepath.'.update', $vendor->id), 'method' => 'PUT')) }}
                
                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('email', 'Email') }}
                    {{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('address[address_1]', 'Address 1') }}
                    {{ Form::text('address[address_1]', null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[address_2]', 'Address 2') }}
                    {{ Form::text('address[address_2]', null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[city]', 'City') }}
                    {{ Form::text('address[city]', null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[state]', 'State') }}
                    <br>
                    {{ Form::select('address[state]',$states, null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[zip]', 'Zip') }}
                    {{ Form::text('address[zip]', null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('phone', 'Phone') }}
                    {{ Form::text('phone', Input::old('address[phone]'), array('class' => 'form-control')) }}
                </div>
                
                {{ Form::submit('Update Vendor', array('class' => 'btn btn-primary')) }}
    
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
