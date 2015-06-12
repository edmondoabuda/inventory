@extends('layouts.default')
@section('content')
<div class="create">
    {{ Form::open(array('url' => $basepath)) }}
    <div class="row">
        <div class="col col-lg-4 col-xs-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">Add Product</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-6">
                
                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('blurb', 'Brief Description') }}
                    {{ Form::textarea('blurb', Input::old('blurb'), array('class' => 'form-control')) }}
                </div>
                
                <div class="form-group">
                    {{ Form::label('description', 'Long Description') }}
                    {{ Form::textarea('description', Input::old('description'), array('class' => 'wysiwyg form-control')) }}
                </div>
            
            
        </div><!-- col -->
    </div><!-- row -->
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Images</label>
                <ul id="image-list" class="list-group no-bottom">
                    @foreach ($attachment_images as $attachment_image)
                        <li class="list-group-item">
                            <input type="hidden" name="images[{{ $attachment_image->id }}][attachment_id]" value="{{ $attachment_image->attachment_id }}">
                            <div class="display-table width-full">
                                <div class="btn-group table-cell">
                                    <img src="/uploads/{{ $attachment_image->url }}" class="thumb-md">
                                </div>
                                <div class="table-cell" style="vertical-align:top;"><i data-attachment-id="{{ $attachment_image->attachment_id }}" class="fa fa-times removeImage pull-right removeImage"></i></div>
                            </div>
                            <label class="margin-top-2">
                                <input type="radio" <?php if ($attachment_image->featured == 1) echo 'checked' ?> name="images[{{ $attachment_image->id }}][featured]">
                                &nbsp;Featured Image
                            </label>
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="btn btn-default margin-top-2" id="add-image"><i class="fa fa-plus"></i> Add Image</button>
            </div>
            
            <div class="form-group">
                {{ Form::label('price_retail', 'Retail Price') }}
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {{ Form::text('price_retail', Input::old('price_retail'), array('class' => 'form-control')) }}
                </div>
            </div>
            
            <div class="form-group">
                {{ Form::label('price_rep', 'Rep Price') }}
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {{ Form::text('price_rep', Input::old('price_rep'), array('class' => 'form-control')) }}
                </div>
            </div>
            
            <div class="form-group">
                {{ Form::label('price_cv', 'CV Price') }}
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {{ Form::text('price_cv', Input::old('price_cv'), array('class' => 'form-control')) }}
                </div>
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
                {{ Form::label('sku', 'SKU') }}
                {{ Form::text('sku', Input::old('sku'), array('class' => 'form-control')) }}
            </div>
            
            <div class="form-group">
                {{ Form::label('quantity', 'Quantity') }}
                {{ Form::number('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
            </div>
            
            <div class="form-group">
                {{ Form::label('disabled', 'Status') }}
                <br>
                {{ Form::select('disabled', [
                    0 => 'Active',
                    1 => 'Disabled'
                ], null, ['class' => 'form-control']) }}
            </div>
            
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
    {{ Form::submit('Add Product', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
</div>
@stop
