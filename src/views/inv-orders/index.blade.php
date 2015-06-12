@extends('layouts.default')
@section('content')
<?php 
	$route_inventories_path = \Config::get('inventory::config.route.inventories.path');   
    $route_receive_product_path = \Config::get('inventory::config.route.inventories.receive-product');
?>
<div ng-app="app" class="index">
    {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'POST')) }}
        <div ng-controller="OrderController" class="my-controller">
            <div class="page-actions">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-top pull-left no-pull-xs">All Orders</h1>
                        <div class="pull-right hidable-xs">
                            <div class="input-group pull-right">
                                <span class="input-group-addon no-width">Count</span>
                                <input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
                            </div>
                            <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
                            <a class="btn btn-default pull-right margin-right-1" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
                        </div>
                    </div>
                </div><!-- row -->
                <div class="row">
                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                        <div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
                            <div class="pull-left">
                                <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url($basepath.'/create') }}"><i class="fa fa-plus"></i></a>
                                <div class="pull-left">
                                    <div class="input-group">
                                        <select class="form-control selectpicker actions">
                                            <option value="{{$basepath}}/disable" selected>Disable</option>
                                            <option value="{{$basepath}}/enable">Enable</option>
                                            <option value="{{$basepath}}/delete">Delete</option>
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
            </div><!-- page-actions -->
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
                                
                                <th class="link" ng-click="orderByField='vendor.name'; reverseSort = !reverseSort">Order By
                                    <span>
                                        <span ng-show="orderByField == 'vendor.name'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='ordered_on'; reverseSort = !reverseSort">Total Price
                                    <span>
                                        <span ng-show="orderByField == 'ordered_on'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='received_on'; reverseSort = !reverseSort">Total Points
                                    <span>
                                        <span ng-show="orderByField == 'received_on'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='due_on'; reverseSort = !reverseSort">Total Tax
                                    <span>
                                        <span ng-show="orderByField == 'due_on'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
								<th class="link" ng-click="orderByField='total_order'; reverseSort = !reverseSort">Total Shipping
                                    <span>
                                        <span ng-show="orderByField == 'total_order'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>								
                                <th>
                                     <span>
                                       Action
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
                            <tr ng-class="{highlight: orders.new == 1}" dir-paginate-start="order in orders | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    <td ng-click="checkbox()">
                                        <input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.purchaseorder_id')">
                                    </td>
                                @endif
                                
                                <td>
                                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin','Admin']))
                                        <a href="/{{$basepath}}/@{{order.id}}"><span ng-bind="order.id"></span></a>
                                    @else
                                        <a target="_blank" href="/{{$basepath}}/@{{order.id}}"><span ng-bind="order.id"></span></a>
                                    @endif
                                </td>
                                
                                <td>
                                    <span ng-bind="order.vendor.name"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="order.total_price"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="order.total_points"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="order.total_tax"></span>
                                </td>
								 <td>
                                    <span ng-bind="order.total_shipping"></span>
                                </td>
								
                                <td>
                                    <span><a href="/{{$route_inventories_path}}/{{$route_receive_product_path}}/@{{purchaseorder.id}}" class=' btn btn-primary btn-xs'>receive</a></span>
                                </td>
                                
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    
                                    <td class="hidable-sm boolean border">
                                        <span ng-if="order.disabled"><i class="fa fa-check"></i></span>
                                    </td>
                                    
                                    <td>
                                        <span ng-bind="order.updated_at"></span>
                                    </td>
                                @endif
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
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
<script>

    var api_path = "{{\Config::get('inventory::config.route.api.path')}}";
    var all_orders = "{{\Config::get('inventory::config.route.api.all-orders')}}";
    var path = "/"+api_path+"/"+all_orders;
   
    var app = angular.module('app', ['angularUtils.directives.dirPagination']);
    
    app.filter('dateToISO', ['$filter', function($filter) {
      return function(input) {
        input = new Date(input);//.toISOString();
        console.log("input");
        if(input != "Invalid Date"){
            return $filter('date')(input, 'EEEE, MMMM d, y');
        }else return "Not set yet";
      };
    }]);
    
    function OrderController($scope, $http, $filter) {
    
        $http.get(path).success(function(v) {
            $scope.orders = v;
            console.log(v);
            @include('_helpers.bulk_action_checkboxes')
            
        });
        
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.savePDF = function(){
            
            var selected = $filter('filter')($scope.orders,  $scope.search);
            sample = "orders=";
            sample = sample + JSON.stringify(selected);
            $http.post("/printAll", sample, {
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
@stop