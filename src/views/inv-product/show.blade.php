@extends('layouts.default')
@section('content')
<div class="show">
    <div class="row">
        <div class="col-md-12">
            @include('_helpers.breadcrumbs')
            <h1 class="no-top">{{ $product->name }}</h1>
            @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
                <div class="page-actions">
                    <div class="btn-group" id="record-options">
                        <a class="btn btn-default" href="{{ url($basepath.'/'.$product->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
                        @if ($product->disabled == 0)
                            {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'DISABLE')) }}
                                <input type="hidden" name="ids[]" value="{{ $product->id }}">
                                <button class="btn btn-default active" title="Currently enabled. Click to disable.">
                                    <i class="fa fa-eye"></i>
                                </button>
                            {{ Form::close() }}
                        @else
                            {{ Form::open(array('url' => $basepath.'/enable', 'method' => 'ENABLE')) }}
                                <input type="hidden" name="ids[]" value="{{ $product->id }}">
                                <button class="btn btn-default" title="Currently disabled. Click to enable.">
                                    <i class="fa fa-eye"></i>
                                </button>
                            {{ Form::close() }}
                        @endif
                        {{ Form::open(array('url' => $basepath.'/' . $product->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this product? This cannot be undone.");')) }}
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
            <p class="align-left">{{ $product->blurb }}</p>
            @if (isset($product->featured_image))
                <img id="featured-image" src="/uploads/{{ $product->featured_image->url }}" class="full-image">
            @else
                <img id="featured-image" src="/img/default-product.png" class="full-image">
            @endif
            @if (count($attachment_images) > 1)
                <div class="margin-top-2 product-thumbs">
                    @foreach ($attachment_images as $attachment_image)
                        <img src="/uploads/{{ $attachment_image }}" class="thumb thumb-md">
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col col-md-6">
            <table class="table">
                
                @if ($product->description != '')
                    <tr>
                        <th>Description:</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                @endif
                
                <tr>
                    <th>Product ID:</th>
                    <td>
                           {{ $product->id }}
                    </td>
                </tr>
                
                <tr>
                    <th>Retail Price:</th>
                    <td>
                           {{ money($product->price_retail) }}
                    </td>
                </tr>

                <tr>
                    <th>Rep Price:</th>
                    <td>
                           {{ money($product->price_rep) }}
                    </td>
                </tr>
                
                <tr>
                    <th>CV Price:</th>
                    <td>
                           {{ money($product->price_cv) }}
                    </td>
                </tr>
                
                <tr>
                    <th>Weight:</th>
                    <td>
                           {{ $product->weight }}
                    </td>
                </tr>
                
                <tr>
                    <th>Volume:</th>
                    <td>
                           {{ $product->volume }}
                    </td>
                </tr>
                
                <tr>
                    <th>SKU:</th>
                    <td>
                           {{ $product->sku }}
                    </td>
                </tr>
                
                <tr>
                    <th>Quantity:</th>
                    <td>{{ $product->quantity }}</td>
                </tr>
                
                   @if (isset($product->productitems))
                    <tr>
                        <th>Items:</th>
                        <td>
                               <ul class="list-group">
                                @foreach ($product->productitems as $product_item)
                                    <li class="list-group-item">{{ $product_item->qty }} &times; <a href="/{{$item_basepath}}/{{ $product_item->item_id }}">{{ $product_item->items->name }}</a></li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endif
                
                <tr>
                    <th>Disabled:</th>
                    <td>{{ $product->disabled ? "Disabled" : "Active" }}</td>
                </tr>
                
            </table>
        </div>
    </div>
</div>
@stop