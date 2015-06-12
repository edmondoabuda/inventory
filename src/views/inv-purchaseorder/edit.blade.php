@extends('layouts.default')
@section('content')
<div class="create">
    {{ Form::model($purchaseorder, array('route' => array($basepath.'.update', $purchaseorder->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">Edit Purchaseorder</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-3 col-md-4 col-sm-6">
                
                <div class="form-group">
                    {{ Form::label('vendor_id', 'Vendor') }}<br>
                    {{ Form::select('vendor_id',$vendors, $purchaseorder->vendor_id, array('class' => 'form-control')) }}
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
            
            
        </div><!-- col -->
    </div><!-- row -->
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            
            @if (isset($available_items))
                <div class="form-group">
                    {{ Form::label('items', 'Items') }}
                    <div class="input-group">
                        <select class="form-control" id="add-item">
                            @foreach ($available_items as $available_item)
                                <option value="{{ $available_item->id }}">{{ $available_item->name }}</option>
                            @endforeach
                        </select>
                        <div class='input-group-btn'>
                            <button type="button" class='btn btn-default' id="add-item-button"><i class='fa fa-plus'></i></button>
                        </div>
                    </div>
                    <br>
                    @if (isset($product_items))
                           <ul class="list-group item-list product-items">
                            @foreach ($product_items as $product_item)
                                <li class="list-group-item display-table width-full">
                                    {{ Form::hidden("items[" . $product_item->id . "][new_product_item]", 0) }}
                                    {{ Form::hidden("items[" . $product_item->id . "][item_id]", $product_item->id) }}
                                    <div class="table-cell quantity">
                                        {{ Form::text("items[" . $product_item->id . "][quantity]", $product_item->item_quantity, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="table-cell">{{ $product_item->name }}</div>
                                    <div class="table-cell align-left">
                                        <i class="fa fa-times removeItem pull-right" data-item-id="{{ $product_item->id }}" data-product-id="{{ $product->id }}"></i>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        (No products)
                    @endif
                </div>
            @endif
        </div>
    </div>
    {{ Form::submit('Update Product', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
</div>
@stop
