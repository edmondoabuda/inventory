<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/controlpad/inventory/bower_components/angular-xeditable/dist/css/xeditable.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/controlpad/inventory/css/styles.css') }}" />
@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    <div ng-controller="NewPOController" class="" class="my-controller">
        <div class="create">
            <div class="row">
                <div class="col col-lg-6 col-xs-12">
                    @include('_helpers.breadcrumbs')
                    <h1 class="no-top">New Purchase Order</h1>
                </div>
                <a class="btn btn-default pull-right" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
            </div>
            <div class="row">
                <div class="col">
                    <form class="form-horizontal" editable-form name="editablePOForm" onaftersave="savePO($data)">
                        {{ Form::hidden('inv-model','purchaseorder')}}
                        <div class="panel panel-success">
                            <div class="panel-header">
                                <div class="pull-right">
                                    <a ng-click="editablePOForm.$show()" ng-show="!editablePOForm.$visible" class="btn btn-primary form-control" title="Edit Item" href="javascript:void(0);"><i class="fa fa-edit"></i> Edit</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                    
                                        <div class="form-group">
                                            {{ Form::label('po_id', 'PO ID', array('class'=>'control-label col-sm-4')) }}
                                            <div class="col-sm-7 form_txt">
                                                <div e-disabled e-class="form-control" editable-text="po.id" e-name="po_id" onbeforesave="vendorForm.checkprice($data)" e-required>PO@{{ po.id || 'empty' }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            {{ Form::label('po_number', 'PO #', array('class'=>'control-label col-sm-4')) }}
                                            <div class="col-sm-7 form_txt">
                                                <div e-class="form-control" editable-text="po.po_number" e-name="po_number" onbeforesave="vendorForm.checkprice($data)">@{{ po.po_number || 'empty' }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            {{ Form::label('vendor', 'Vendor', array('class'=>'control-label col-sm-4')) }}
                                            <div class="col-sm-7 form_txt">
                                                <div e-class="form-control" editable-select="po.vendor_id" e-name="vendor_id" onbeforesave="vendorForm.checkprice($data)" e-ng-options="s.id as s.name for s in vendors" e-ng-change="setVendor($data)" e-required>@{{ (po.vendors | filter:{id: po.vendor_id}:true)[0].name || 'Not set' }}</div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            {{ Form::label('ordered_on', 'Ordered On', array('class'=>'control-label col-sm-4')) }}
                                            <div class="col-sm-7 form_txt">
                                                <div e-class="form-control dateonlypicker" editable-text="po.ordered_on" e-name="ordered_on" onbeforesave="vendorForm.checkprice($data)"><span ng-bind="po.ordered_on | dateToISO"></span></div>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            {{ Form::label('due_on', 'Due On', array('class'=>'control-label col-sm-4')) }}
                                            <div class="col-sm-7 form_txt">
                                                <div e-class="form-control dateonlypicker" editable-text="po.due_on" e-name="due_on" onbeforesave="vendorForm.checkprice($data)"><span ng-bind="po.due_on | dateToISO"></span></div>
                                            </div>
                                        </div>
                                        <div class="form-group" ng-show="!editablePOForm.$visible">
                                            {{ Form::label('total_amount', 'Total Amount', array('class'=>'control-label col-sm-4')) }}
                                            <div class="col-sm-7 form_txt">
                                                <div e-class="form-control" editable-text="po.total_amount" e-name="total_amount" onbeforesave="vendorForm.checkprice($data)"><span ng-bind="getTotalPoAmount() | currency"></span></div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" ng-show="editablePOForm.$visible">
                                     <div class="col">
                                        <span class="pull-right space_right">
                                            <button type="submit" class="btn btn-info" ng-disabled="editablePOForm.$waiting">
                                                <i class="fa fa-save"></i> Update
                                            </button>
                                            <button type="button" class="btn btn-success" ng-disabled="editablePOForm.$waiting" ng-click="editablePOForm.$cancel()">
                                                <i class="fa fa-close"></i> Cancel
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </form>
                </div>
            </div>
            <div class="row">
                <div class="col col-md-6">
                    <h4 class="pull-left"><strong>Vendor Information&nbsp;</strong></h4><a href="javscript:void(0);" ng-click="toggleVendorInfo()"><span class="label label-info" ng-bind="vendorInfoBtn"></span></a><br/>
                </div>
                <div class="col col-md-6">
                    <h4 class="pull-left"><strong>Shipping Information&nbsp;</strong></h4>
                </div>
            </div>
            <div class="row" ng-show="showVendorInfo()">
                <div class="col-md-6">
                    <form class="form-horizontal" editable-form name="editableVendorForm" onaftersave="saveVendor($data)">
                    <div class="panel panel-default">
                        <div class="panel-header">
                            <div class="pull-right">
                                <a ng-click="editableVendorForm.$show()" ng-show="!editableVendorForm.$visible" class="btn btn-primary form-control" title="Edit Item" href="javascript:void(0);"><i class="fa fa-edit"></i> Edit</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        {{ Form::label('id', 'ID', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.id" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.id || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.name" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.name || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('email', 'Email', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.email" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.email || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('address_1', 'Address 1', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.address_1" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.address_1 || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('address_2', 'Address 2', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.address_2" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.address_2 || 'empty' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        {{ Form::label('phone', 'Phone', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.phone" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.phone || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('city', 'City', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.city" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.city || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('state', 'State', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.state" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.state || 'empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('zip', 'Zip', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="vendor_info.zip" e-min="1" e-name="rep_price" onbeforesave="vendorForm.checkprice($data)" e-required>@{{ vendor_info.zip || 'empty' }}</div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                             <div class="row" ng-show="editableVendorForm.$visible">
                                 <div class="col">
                                    <span class="pull-right space_right">
                                        <button type="submit" class="btn btn-info" ng-disabled="editableVendorForm.$waiting">
                                            <i class="fa fa-save"></i> Update
                                        </button>
                                        <button type="button" class="btn btn-success" ng-disabled="editableVendorForm.$waiting" ng-click="editableVendorForm.$cancel()">
                                            <i class="fa fa-close"></i> Cancel
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-6">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4 class="pull-left"><strong>Items (<span ng-bind="items.length"></span>) </strong>&nbsp;</h4><div ng-show="itemMessage.length" class="pull-left alert alert-danger"><span ng-bind="itemMessage"></span></div><button type="button" ng-click="addItem()" data-toggle="modal" data-target=".bs-example-modal-lg" class="pull-right btn btn-info"><span ng-bind="addItemBtn"></button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <ul class="media-list">
                        <li class="" dir-paginate-start="item in items | filter:search | itemsPerPage: pageSize " current-page="currentPage" total-items="countItems">
                            <form ng-if="item.added" shown="true" class="col" editable-form name="editableForm" onaftersave="saveProduct($data)">
                                <div class="panel panel-info">
                                    <div class="panel-header">
                                        <div class="form-group pull-right">
                                            <a ng-click="editableForm.$show()" ng-show="!editableForm.$visible" class="btn btn-primary form-control" title="Edit Item" href="javascript:void(0);"><i class="fa fa-edit"></i> Edit</a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    {{ Form::label('name', 'Name') }}
                                                    <div e-class="form-control" editable-text="item.item.name" e-typeahead="rawitem.name for rawitem in rawitems | filter:$viewValue | limitTo:8" e-name="name" e-required>@{{ item.item.name || 'empty' }} </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col" style="display:none;">
                                                <div class="form-group">
                                                    <div e-class="form-control" editable-number="item.id" e-value="@{{item.id}}" e-name="id">@{{ item.id || 'empty' }}</div>
                                                </div>
                                            </div>

       
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    {{ Form::label('quantity', 'Quantity') }}
                                                    <div e-class="form-control" editable-number="item.qty" e-min="1" e-name="quantity" onbeforesave="productForm.checkquantity($data)" e-required>@{{ item.qty || 'empty' }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-2" ng-show="!editableForm.$visible">
                                                <div class="form-group">
                                                    {{ Form::label('price', 'Price') }}
                                                    <div e-class="form-control" e-name="price">@{{ item.item.products[0].price_retail || 'empty' | currency }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-2" ng-show="!editableForm.$visible">
                                                <div class="form-group">
                                                    {{ Form::label('cost', 'Sub Total') }}
                                                    <div e-class="form-control" e-name="cost">@{{ item.qty * item.item.products[0].price_retail || 'empty' | currency }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" ng-show="editableForm.$visible">
                                            <div class="col">
                                                <span class="pull-right space_right">
                                                    <button type="submit" class="btn btn-info" ng-disabled="editableForm.$waiting">
                                                        <i class="fa fa-save"></i> Save
                                                    </button>
                                                    <button type="button" class="btn btn-success" ng-disabled="editableForm.$waiting" ng-click="editableForm.$cancel()">
                                                        <i class="fa fa-close"></i> Cancel
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                
                             </form>
                            <form ng-if="!item.added" class="col" editable-form name="editableForm" onaftersave="saveProduct($data)">
                                <div class="panel panel-info">
                                    <div class="panel-header">
                                        <div class="form-group pull-right">
                                            <a ng-click="editableForm.$show()" ng-show="!editableForm.$visible" class="btn btn-primary form-control" title="Edit Item" href="javascript:void(0);"><i class="fa fa-edit"></i> Edit</a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    {{ Form::label('name', 'Name') }}
                                                    <div e-class="form-control" editable-text="item.item.name" e-typeahead="rawitem.name for rawitem in rawitems | filter:$viewValue | limitTo:8" e-name="name" e-required>@{{ item.item.name || 'empty' }} </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col" style="display:none;">
                                                <div class="form-group">
                                                    <div e-class="form-control" editable-number="item.id" e-value="@{{item.id}}" e-name="id">@{{ item.id || 'empty' }}</div>
                                                </div>
                                            </div>

       
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    {{ Form::label('quantity', 'Quantity') }}
                                                    <div e-class="form-control" editable-number="item.qty" e-min="1" e-name="quantity" onbeforesave="productForm.checkquantity($data)" e-required>@{{ item.qty || 'empty' }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-2" ng-show="!editableForm.$visible">
                                                <div class="form-group">
                                                    {{ Form::label('price', 'Price') }}
                                                    <div e-class="form-control" e-name="price">@{{ item.item.products[0].price_retail || 'empty' | currency }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-2" ng-show="!editableForm.$visible">
                                                <div class="form-group">
                                                    {{ Form::label('cost', 'Sub Total') }}
                                                    <div e-class="form-control" e-name="cost">@{{ item.qty * item.item.products[0].price_retail || 'empty' | currency }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" ng-show="editableForm.$visible">
                                            <div class="col">
                                                <span class="pull-right space_right">
                                                    <button type="submit" class="btn btn-info" ng-disabled="editableForm.$waiting">
                                                        <i class="fa fa-save"></i> Save
                                                    </button>
                                                    <button type="button" class="btn btn-success" ng-disabled="editableForm.$waiting" ng-click="editableForm.$cancel()">
                                                        <i class="fa fa-close"></i> Cancel
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                
                             </form>
                        </li>
                        <li dir-paginate-end></li>
                    </ul>
                </div>
            </div>
            <br/>
            <div class="row" ng-show="items.length">
                <div class="col col-sm-offset-1">
                    <button type="button" ng-click="addItem()" class="pull-left btn btn-info"><span ng-bind="addItemBtn"></button>
                    
                </div>
                
            </div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Select Items</h4>
          </div>
        <div class="modal-body">
            <div class="page-actions">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right hidable-xs">
                            <div class="input-group pull-right">
                                <span class="input-group-addon no-width">Count</span>
                                <input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
                            </div>
                            <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
                        </div>
                    </div>
                </div><!-- row -->
            </div>
            <div class="row">
                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                        <div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
                            <div class="pull-left">
                                <div class="pull-left">
                                    <div class="input-group">
                                        <div class="input-group-btn no-width">
                                            <button class="btn btn-default applyAction" disabled>
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                    @else
                        <div class="col-md-12 col-sm-12 col-xs-12">
                    @endif
                        <div class="pull-right">
                            <div class="input-group">
                                <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
                                <span class="input-group-btn no-width">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div><!-- col -->
                </div><!-- row -->
        </div><!-- page actions -->
        <div class="row">
                <div class="col col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox">
                                </th>

                                <th class="link" ng-click="orderByField='name'; reverseSort = !reverseSort">Name
                                    <span>
                                        <span ng-show="orderByField == 'name'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='weight'; reverseSort = !reverseSort">Weight
                                    <span>
                                        <span ng-show="orderByField == 'weight'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='volume'; reverseSort = !reverseSort">Volume
                                    <span>
                                        <span ng-show="orderByField == 'volume'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='inventory_number'; reverseSort = !reverseSort">Inventory Number
                                    <span>
                                        <span ng-show="orderByField == 'inventory_number'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='mfg_sku'; reverseSort = !reverseSort">MFG SKU
                                    <span>
                                        <span ng-show="orderByField == 'mfg_sku'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-class="{highlight: item.new == 1}" dir-paginate-start="item in rawitems | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                    <td ng-click="checkbox()">
                                        <input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.item_id')">
                                    </td>
                                
                                <td>
                                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin','Admin']))
                                        <a href="/{{$basepath}}/@include('_helpers.item_id')"><span ng-bind="item.name"></span></a>
                                    @else
                                        <a target="_blank" href="/{{$basepath}}/@include('_helpers.item_id')"><span ng-bind="item.name"></span></a>
                                    @endif
                                </td>
                                
                                <td>
                                    <span ng-bind="item.weight"></span>
                                </td>
                                                                
                                <td>
                                    <span ng-bind="item.volume"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="item.inventory_number"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="item.mfg_sku"></span>
                                </td>
                                
                            </tr>
                            <tr dir-paginate-end></tr>
                        </tbody>
                    </table>
                    @include('_helpers.loading')
                    <div ng-controller="OtherController" class="other-controller">
                        <div class="text-center">
                            <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
                        </div>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        <div class="modal-footer">
            <button type="button" class="btn btn-primary">Add</button>
        </div>
    </div>
  </div>
</div>

        </div>
    </div>
</div>

@stop
<script type="text/ng-template" id="modalPDF.html">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" ng-model="modalTitle">@{{ viewTitle }}</h4>
        </div>
        <div class="modal-body">
            <embed>@{{ mypdf }} </embed>
        </div>
</script>
@section('scripts')
{{ HTML::script(URL::asset('packages/controlpad/inventory/bower_components/angular-xeditable/dist/js/xeditable.min.js') ) }}
<script>

    var api_path = "{{\Config::get('inventory::config.route.api.path')}}";
    var all_inventories = "{{\Config::get('inventory::config.route.api.all-inventories')}}";
    var getPurchaseOrder = "{{\Config::get('inventory::config.route.api.getPurchaseOrder')}}";
    var getPoLine = "{{\Config::get('inventory::config.route.api.getPoLine')}}";
    var getVendor = "{{\Config::get('inventory::config.route.api.getVendor')}}";
    var allVendors = "{{\Config::get('inventory::config.route.api.all-vendors')}}";
    var allItems = "{{\Config::get('inventory::config.route.api.all-items')}}";
    var availableItems = "{{\Config::get('inventory::config.route.api.available-items')}}";
    var updatePoLine = "{{\Config::get('inventory::config.route.api.updatePoLine')}}";
    var updatePurchaseOrder = "{{\Config::get('inventory::config.route.api.updatePurchaseOrder')}}";
    
    var path = "/"+api_path+"/"+all_inventories;
    
    var getPurchaseOrder_path = "/"+api_path+"/"+getPurchaseOrder;
    var allVendors_path = "/"+api_path+"/"+allVendors;
    var allItems_path = "/"+api_path+"/"+allItems;
    var availableItems_path = "/"+api_path+"/"+availableItems;
    var getVendor_path = "/"+api_path+"/"+getVendor;
    var getPoLine_path = "/"+api_path+"/"+getPoLine;
    var updatePoLine_path = "/"+api_path+"/"+updatePoLine;
    var updatePurchaseOrder_path = "/"+api_path+"/"+updatePurchaseOrder;

    var app = angular.module('app', ['angularUtils.directives.dirPagination','xeditable','ui.bootstrap']);
    app.directive('dateonlypicker', function() {
        return {
            restrict: 'C',
            require: 'ngModel',
            link: function(scope, element, attrs, ctrl) {
                $(element).datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(date) {
                        ctrl.$setViewValue(date);
                        ctrl.$render();
                        scope.$apply();
                    }
                });
            }
        };
    });
    
    app.filter('dateToISO', ['$filter', function($filter) {
      return function(input) {
        input = new Date(input);//.toISOString();
        console.log("input");
        if(input != "Invalid Date"){
            return $filter('date')(input, 'EEEE, MMMM d, y');
        }else return "Not set yet";
      };
    }]);
    
    var purchaseorder_id  = '{{$purchaseorder->id}}';
    
    function NewPOController($scope, $http, $filter, $modal) {

        $scope.currentPage = 1;
        $scope.countItems = 0;
        $scope.pageSize = 10;
        $scope.meals = [];
        $scope.vendor_info = [];
        $scope.vendors = [];
        $scope.vendor = 0;
        $scope.vendorInfoVisible = true;
        $scope.vendorInfoBtn = "hide";
        $scope.addItemBtn = "Add Item";
        $scope.rawitems = [];
        $scope.items = [];
        $scope.po = {};
        
        $http.get(getPurchaseOrder_path+'/'+purchaseorder_id).success(function(v) {
            $scope.po = v;
            $http.get(allVendors_path+'/').success(function(vv) {
                $scope.vendors = vv.data;
            });
            
            $http.get(availableItems_path+'/'+purchaseorder_id).success(function(uu) {
                $scope.rawitems = uu.data;
            });
            
            $http.get(getPoLine_path+'/'+purchaseorder_id).success(function(xx) {
                $scope.items = xx.data;
                $scope.countItems = xx.count;
                $scope.pageSize = xx.count;
            });
        });
        
        $scope.setVendor = function(vendor)
        {
            $http.get(getVendor_path+'/'+vendor).success(function(v) {
                console.log("set vendor called");
                $scope.vendor = vendor;
                $scope.vendor_info = v;
            });        
        };
        
        $scope.addItem = function()
        {
            /*
            var countNew = $scope.items.filter(function(item){
                return item.hasOwnProperty('added') && item.added;
            });
            
            console.log("countNew");
            console.log(countNew);
            if(countNew.length){
                $scope.itemMessage = "Please submit the previously added form before adding another one.";
                return;           
            }else{
                $scope.itemMessage = "";
            }
            
            
            $scope.items.unshift({
                name : "",
                size : "",
                quantity : 0,
                retail_price: 0.00,
                added : true
            });
            $scope.countItems = $scope.items.length;    
            $scope.pageSize = $scope.items.length;   */ 
        };
        
        $scope.getTotalPoAmount = function()
        {
            var total = 0;
            $scope.items.map(function(item){
                if(item.hasOwnProperty('item') && item.item.hasOwnProperty('products') && item.item.products.length > 0){
                    total += item.qty * item.item.products[0].price_retail;    
                }
            });
            $scope.po.total_amount = total;
            return total;
        };
        
        $scope.toggleVendorInfo = function()
        {
            $scope.vendorInfoVisible = !$scope.vendorInfoVisible;
            $scope.vendorInfoBtn = $scope.vendorInfoVisible ? "hide" : "show";
            return $scope.vendorInfoVisible;    
        };
        
        $scope.showVendorInfo = function()
        {
            return $scope.vendor_info.name == undefined ? false : $scope.vendorInfoVisible;
        };
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.showFilterVendor = function(){
            var selected = $filter('filter')($scope.vendors, {id: $scope.po.vendor_id}, true);
            return ($scope.po.vendor_id && selected.length) ? selected[0].name : 'Not set';
        };
        
        $scope.saveProduct = function(data){
            console.log("saveProduct");
            console.log(this);
            console.log(data);
            var selected = $filter('filter')($scope.rawitems, {name: data.name}, true);
            console.log(selected);
            
            if(selected.length > 0){
                data.item_id = selected[0].id; 
                data.purchaseorder_id = purchaseorder_id; 
                $http.post(updatePoLine_path,data).success(function(v){

                    if(v.status == "failed"){
                        $scope.itemMessage = v.message;
                    }else{    
                        $scope.items.map(function(item){
                            if(item.hasOwnProperty('added') && item.added){
                                item.added = false;    
                            }
                        });
                    }
                });
            }
        };
        
        $scope.savePO = function(data){
            console.log("savePO");
            console.log(data);
            
            $http.post(updatePurchaseOrder_path+'/'+purchaseorder_id,data).success(function(v){
                console.log('success');
            });
        };

        $scope.savePDF = function(){
            selected = { "sample": "Hello World!"};
            sample = "purchaseorder=";
            sample = sample + JSON.stringify(selected);
            $http.post("/print/po", sample, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
            }).success(function(data, status, headers, config) {
                var file = new Blob([data], {type: 'application/pdf'}); 
                var fileURL = URL.createObjectURL(file);
                window.open(fileURL,'Purchase Order print preview');
                URL.revokeObjectURL(fileURL);
            }).error(function(data, status) { 
                window.alert('Problem has occurred. Please contact administrator.');
            });

        }
        
        $scope.savePDF = function(){
            console.log($scope);
            var selected = {};
            sample = "newpo=";
            sample = sample + JSON.stringify(selected);
            $http.post("/print/po", sample, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
            }).success(function(data, status, headers, config) {
                var file = new Blob([data], {type: 'application/pdf'}); 
                var fileURL = URL.createObjectURL(file);
                window.open(fileURL);
                //window.open(fileURL,'Inventory Print Preview','height=800,width=1000,left=200,top=200,toolbars=no,resizable=no,scrollbars=auto,location=no');
            }).error(function(data, status) { 
                window.alert('Problem has occurred. Please contact administrator.');
            });
        }
    }
    
    
    
    function OtherController($scope) {
        $scope.pageChangeHandler = function(num) {
        };
    }

</script>
@stop
