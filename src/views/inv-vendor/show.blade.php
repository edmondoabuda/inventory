@extends('layouts.default')
@section('content')
<div class="show">
    <div class="row page-actions">
        @include('_helpers.breadcrumbs')
        <h1>{{ $vendor->name }} </h1>
        <div class="btn-group" id="record-options">
            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
                <a class="btn btn-default" href="{{ url($basepath.'/'.$vendor->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
            @endif
            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
                @if ($vendor->disabled == 0)
                    {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'DISABLE')) }}
                        <input type="hidden" name="ids[]" value="{{ $vendor->id }}">
                        <button class="btn btn-default active" title="Currently enabled. Click to disable.">
                            <i class="fa fa-eye"></i>
                        </button>
                    {{ Form::close() }}
                @else
                    {{ Form::open(array('url' => $basepath.'/enable', 'method' => 'ENABLE')) }}
                        <input type="hidden" name="ids[]" value="{{ $vendor->id }}">
                        <button class="btn btn-default" title="Currently disabled. Click to enable.">
                            <i class="fa fa-eye"></i>
                        </button>
                    {{ Form::close() }}
                @endif
                {{ Form::open(array('url' => $basepath.'/' . $vendor->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
                    <button class="btn btn-default" title="Delete">
                        <i class="fa fa-trash" title="Delete"></i>
                    </button>
                {{ Form::close() }}
            @endif
        </div>
        @if (!$vendor->block_email && !$vendor->block_sms)
            <div class="btn-group" id="communication-options">
        @endif
                @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep']))
                    @if (!$vendor->block_email)
                        {{ Form::open(array('url' => '/compose-email', 'method' => 'POST')) }}
                            {{ Form::hidden('user_ids[]', $vendor->id) }}
                            <button class="btn btn-default" title="Send Email">
                                <i class="fa fa-envelope"></i>
                            </button>
                        {{ Form::close() }}
                    @endif
                    @if (!$vendor->block_sms)
                        {{ Form::open(array('url' => '/compose-sms', 'method' => 'POST')) }}
                            {{ Form::hidden('user_ids[]', $vendor->id) }}
                            <button class="btn btn-default" title="Send SMS (text) Message">
                                <i class="fa fa-mobile-phone"></i>
                            </button>
                        {{ Form::close() }}
                    @endif
                @endif
        @if (!$vendor->block_email && !$vendor->block_sms)
            </div>
        @endif
    </div><!-- row -->
    <div class="row">
        <div class="col col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 div class="panel-title">Vendor Information
                        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
                            <a class="pull-right" href="{{ url($basepath.'/'.$vendor->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
                        @endif
                    </h2>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>
                            ID:
                        </th>
                        <td>{{ $vendor->id }}</td>
                    </tr>
                    <tr>
                        <th>
                            Name:
                        </th>
                        <td>
                            {{ $vendor->name }}
                        </td>
                    </tr>
                    @if ($vendor->hide_email != true || Auth::user()->hasRole(['Superadmin', 'Admin']))
                        <tr>
                            <th>Email:</th>
                            <td>
                                {{ $vendor->email }}
                                @if ($vendor->block_email)
                                    <br>
                                    <span class="label label-warning">
                                        {{ $vendor->name }} has opted out of receiving emails.
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>
                                {{ $vendor->phone }}
                                @if ($vendor->block_sms)
                                    <br>
                                    <span class="label label-warning">
                                        {{ $vendor->name }} has opted out of receiving text messages.
                                    </span>
                                @endif
                            </td>
                        </tr> 
                        <tr>
                            <th>Address 1:</th>
                            <td>
                                {{ $vendor->address->address_1 }}
                            </td>
                        </tr>   
                        <tr>
                            <th>Address 2:</th>
                            <td>
                                {{ $vendor->address->address_2 }}
                            </td>
                        </tr>   
                        <tr>
                            <th>City:</th>
                            <td>
                                {{ $vendor->address->city }}
                            </td>
                        </tr>   
                        <tr>
                            <th>State:</th>
                            <td>
                                {{ $vendor->address->state }}
                            </td>
                        </tr>   
                        <tr>
                            <th>Zip:</th>
                            <td>
                                {{ $vendor->address->zip }}
                            </td>
                        </tr>   
                        <tr>
                            <th>Status:</th>
                            <td>
                                {{ $vendor->disabled ? "Disabled" : "Active" }}
                            </td>
                        </tr>   
                        
                    @endif
                </table>
            </div><!-- panel -->
        </div><!-- col -->
    </div><!-- row -->
@stop
