@extends('layouts.default')
@section('content')
<div class="show">
    <div class="row page-actions">
        @include('_helpers.breadcrumbs')
        <h1>{{ $item->name }} </h1>
        <div class="btn-group" id="record-options">
            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
                <a class="btn btn-default" href="{{ url($basepath.'/'.$item->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
            @endif
            @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
                @if ($user->disabled == 0)
                    {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'DISABLE')) }}
                        <input type="hidden" name="ids[]" value="{{ $item->id }}">
                        <button class="btn btn-default active" title="Currently enabled. Click to disable.">
                            <i class="fa fa-eye"></i>
                        </button>
                    {{ Form::close() }}
                @else
                    {{ Form::open(array('url' => $basepath.'/enable', 'method' => 'ENABLE')) }}
                        <input type="hidden" name="ids[]" value="{{ $item->id }}">
                        <button class="btn btn-default" title="Currently disabled. Click to enable.">
                            <i class="fa fa-eye"></i>
                        </button>
                    {{ Form::close() }}
                @endif
                {{ Form::open(array('url' => $basepath.'/' . $item->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
                    <button class="btn btn-default" title="Delete">
                        <i class="fa fa-trash" title="Delete"></i>
                    </button>
                {{ Form::close() }}
            @endif
        </div>
        @if (!$item->block_email && !$item->block_sms)
            <div class="btn-group" id="communication-options">
        @endif
                @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep']))
                    @if (!$item->block_email)
                        {{ Form::open(array('url' => '/compose-email', 'method' => 'POST')) }}
                            {{ Form::hidden('user_ids[]', $item->id) }}
                            <button class="btn btn-default" title="Send Email">
                                <i class="fa fa-envelope"></i>
                            </button>
                        {{ Form::close() }}
                    @endif
                    @if (!$item->block_sms)
                        {{ Form::open(array('url' => '/compose-sms', 'method' => 'POST')) }}
                            {{ Form::hidden('user_ids[]', $item->id) }}
                            <button class="btn btn-default" title="Send SMS (text) Message">
                                <i class="fa fa-mobile-phone"></i>
                            </button>
                        {{ Form::close() }}
                    @endif
                @endif
        @if (!$item->block_email && !$item->block_sms)
            </div>
        @endif
    </div><!-- row -->
    <div class="row">
        <div class="col col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 div class="panel-title">Item Information
                        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
                            <a class="pull-right" href="{{ url($basepath.'/'.$item->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
                        @endif
                    </h2>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>
                            ID:
                        </th>
                        <td>{{ $item->id }}</td>
                    </tr>
                    <tr>
                        <th>
                            Name:
                        </th>
                        <td>
                            {{ $item->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Weight:
                        </th>
                        <td>
                            {{ $item->weight }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Volume:
                        </th>
                        <td>
                            {{ $item->volume }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Inventory Number:
                        </th>
                        <td>
                            {{ $item->inventory_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            MGF SKU:
                        </th>
                        <td>
                            {{ $item->mfg_sku }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Status:
                        </th>
                        <td>
                            {{ $item->disabled ? "Disabled" :"Active" }}
                        </td>
                    </tr>
                </table>
            </div><!-- panel -->
        </div><!-- col -->
    </div><!-- row -->
@stop
