@extends('layouts.default')
@section('content')
<div class="create">
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">New Vendor</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3 col-md-4 col-sm-6">
            {{ Form::open(array('url' => $basepath)) }}
                
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
                    {{ Form::text('address[address_1]', Input::old('address_1'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[address_2]', 'Address 2') }}
                    {{ Form::text('address[address_2]', Input::old('address_2'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[city]', 'City') }}
                    {{ Form::text('address[city]', Input::old('city'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[state]', 'State') }}
                    <br>
                    {{ Form::select('address[state]',$states, null, array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('address[zip]', 'Zip') }}
                    {{ Form::text('address[zip]', Input::old('zip'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('phone', 'Phone') }}
                    {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
                </div>
                
                {{ Form::submit('Add Vendor', array('class' => 'btn btn-primary')) }}
    
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop
