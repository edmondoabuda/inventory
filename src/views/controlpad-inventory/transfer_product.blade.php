@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    <div ng-controller="TransferController" class="" class="my-controller">
        <div class="row">
            <div class="col col-lg-4 col-xs-12">
                @include('_helpers.breadcrumbs')
                <h1 class="no-top">Transfer Products</h1>
            </div>
        </div>
        
        {{ Form::open(array('url' => $basepath,'id'=>'transferForm')) }}
        <div class="row">
            @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>        
                @endforeach
            </div>
            @endif
            <div class="col col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-sm-6">               
                        <div class="form-group">
                            {{ Form::label('warehouse_id_from', 'Source Warehouse') }}
                            {{ Form::select('warehouse_id_from', $warehouses, null, array('class' => 'form-control','ng-init'=>'source="0"','ng-model'=>'source','ng-change'=>'setsourcewarehouse(source)')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('warehouse_id_from', 'Items') }}
                            <div ng-hide="source_warehouse.inventories">
                                No product items for this warehouse.
                            </div>
                            <ul class="nav nav-pills">
                                <li dir-paginate-start="inventory in source_warehouse.inventories | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage" ng-show="inventory.quantity > 0">
                               
                                    <a ng-click="transfer(inventory.id)" href="javascript:void(0);">
                                            <span ng-bind="inventory.item.name"></span> - 
                                            <input type='number' name='quantity[]'value="@{{inventory.quantity}}"/>
                                    </a>
                                    <input type='hidden' name='item_id[]'value="@{{inventory.item_id}}"/>
                                             
                                </li>
                                <li dir-paginate-end></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">
                            {{ Form::label('warehouse_id_to', 'Destination Warehouse') }}
                            {{ Form::select('warehouse_id_to', $warehouses, null, array('class' => 'form-control','ng-init'=>'destination="0"','ng-model'=>'destination','ng-change'=>'setdestinationwarehouse(destination)')) }}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('warehouse_id_to', 'Items') }}
                            <div ng-hide="destination_warehouse.inventories">
                                No product items for this warehouse.
                            </div>
                            <ul class="nav nav-pills">
                                <li dir-paginate-start="inventory in destination_warehouse.inventories | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                    <a href="javascript:void(0);"><span ng-bind="inventory.item.name"></span> - <span  class="label label-info" ng-bind="inventory.quantity"></span></a></li>
                               
                                <li dir-paginate-end></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-6'>
                <ul class='errors has-error'></ul>
                    
            </div>
        </div>
        <div class="row">
            <div class="col col-lg-3 col-md-4 col-sm-6">            
            
                    {{ Form::submit('Process Transfer Now', array('class' => 'btn btn-primary')) }}
                   
            </div>
        </div>
        {{ Form::close() }}
        <div><br/>
            <div class="page-actions">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="no-top pull-left no-pull-xs">Transfer History</h3>
                        <div class="pull-right hidable-xs">
                            <div class="input-group pull-right">
                                <span class="input-group-addon no-width">Count</span>
                                <input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
                            </div>
                            <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
                        </div>
                        <a class="btn btn-default pull-right margin-right-1" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
                    </div>
                </div>
                <div class="row">
                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                        <div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
                            <div class="pull-left">
                                <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url($basepath.'/create') }}"><i class="fa fa-plus"></i></a>
                                <div class="pull-left">
                                    <div class="input-group">
                                        <select class="form-control selectpicker actions">
                                            <option value="products/disable" selected>Disable</option>
                                            <option value="products/enable">Enable</option>
                                            <option value="products/delete">Delete</option>
                                        </select>
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
            </div>
            <div class="row">
                <div class="col col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    <th>
                                        <input type="checkbox">
                                    </th>
                                @endif
                                
                                <th class="link" ng-click="orderByField='id'; reverseSort = !reverseSort">ID
                                    <span>
                                        <span ng-show="orderByField == 'id'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='item.name'; reverseSort = !reverseSort">Source Warehouse
                                    <span>
                                        <span ng-show="orderByField == 'item.name'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='quantity'; reverseSort = !reverseSort">Destination Warehouse
                                    <span>
                                        <span ng-show="orderByField == 'quantity'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='state'; reverseSort = !reverseSort">Quantity
                                    <span>
                                        <span ng-show="orderByField == 'state'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='zip'; reverseSort = !reverseSort">Item Name
                                    <span>
                                        <span ng-show="orderByField == 'zip'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                <th class="link" ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
                                    <span>
                                        <span ng-show="orderByField == 'disabled'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>

                                    
                                    <th class="link" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
                                        <span>
                                            <span ng-show="orderByField == 'updated_at'">
                                                <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                                <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                            </span>
                                        </span>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-class="{highlight: inventory.new == 1}" dir-paginate-start="transfer in transfers | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    <td ng-click="checkbox()">
                                        <input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.inventory_id')">
                                    </td>
                                @endif
                                
                                <td>
                                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin','Admin']))
                                        <a href="/{{$basepath}}/@include('_helpers.inventory_id')"><span ng-bind="transfer.id"></span></a>
                                    @else
                                        <a target="_blank" href="/{{$basepath}}/@include('_helpers.inventory_id')"><span ng-bind="transfer.id"></span></a>
                                    @endif
                                </td>
                                
                                <td>
                                    <span ng-bind="transfer.warehouse_from_name"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="transfer.warehouse_to_name"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="transfer.qty"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="transfer.item_name"></span>
                                </td>
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                <td>
                                    <span ng-bind="transfer.disabled"></span>
                                </td>
                                @endif
                            </tr>
                            <tr dir-paginate-end></tr>
                        </tbody>
                    </table>
                    <div ng-hide="isLoading()">
                        @include('_helpers.loading')
                    </div>
                    <div ng-controller="OtherController" class="other-controller">
                        <div class="text-center">
                            <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
                        </div>
                    </div>
                </div><!-- col -->
            </div>
        </div>
    </div>
</div>

@stop
@section('scripts')
<script>

    var app = angular.module('app', ['angularUtils.directives.dirPagination']);
    
    function TransferController($scope, $http, $filter) {

        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        $scope.source_warehouse = [];
        $scope.destination_warehouse = [];

        $scope.isComplete = false;
        
        $http.get('/inv_api/all-transfers').success(function(v) {
            $scope.transfers = v.data;
            console.log($scope.transfers);
            $scope.isComplete = true;
        });
        
        $scope.setsourcewarehouse = function(warehouse){
            $scope.source = warehouse;
            if($scope.destination == warehouse){
                $scope.destination = 0;    
                $scope.destination_warehouse = [];    
            }
            $http.get('/inv_api/getWarehouse/'+warehouse).success(function(v) {
                $scope.source_warehouse = v;
            });
        };
        
        $scope.setdestinationwarehouse = function(warehouse){
            $scope.destination = warehouse;
            if($scope.source == warehouse){
                $scope.source = 0;    
                $scope.source_warehouse = [];    
            }
            $http.get('/inv_api/getWarehouse/'+warehouse).success(function(v) {
                $scope.destination_warehouse = v;
            });
        };
        
        $scope.transfer = function(inventory_id)
        {
            console.log(inventory_id);
        };
        
        $scope.pageChangeHandler = function(num) {
            
        };

        $scope.isLoading = function(){
            return $scope.isComplete;
        };

        $scope.savePDF = function(){
            
            var selected = $filter('filter')($scope.transfers,  $scope.search);
            sample = "transfer=";
            sample = sample + JSON.stringify(selected);
            $http.post("/print/all", sample, {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
            }).success(function(data, status, headers, config) {
                var file = new Blob([data], {type: 'application/pdf'}); 
                var fileURL = URL.createObjectURL(file);
                window.open(fileURL);
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
<script>
    $(document).ready(function(){
        $("[name='warehouse_id_from'],[name='warehouse_id_to']").focus(function(){
             $(".errors").html("");
        })
        $("#transferForm").submit(function (event){
            strBuilder = "";
            if($("[name='warehouse_id_from']").val()==0 || $("[name='warehouse_id_to']").val()==0 ){
                strBuilder+= "<li>Make sure you have selected warehouse source and destination</li>"
                $(".errors").html(strBuilder);
                return false;
            }   
            
                 return true;
             })
    })
    
</script>
@stop