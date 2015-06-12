@extends('layouts.default')
@section('content')
<?php 
	$route_inventories_path = \Config::get('inventory::config.route.inventories.path');   
    $route_receive_product_path = \Config::get('inventory::config.route.inventories.receive-product');
?>
<div ng-app="app" class="index">
    {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'POST')) }}
        <div ng-controller="PurchaseorderController" class="my-controller">
            <div class="page-actions">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-top pull-left no-pull-xs">All Purchaseorders</h1>
                        <div class="pull-right hidable-xs">
                            <div class="input-group pull-right">
                                <span class="input-group-addon no-width">Count</span>
                                <input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
                            </div>
                            <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
                            <a class="btn btn-default pull-right margin-right-1" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
                        </div>
                        <a class="btn btn-default pull-right margin-right-1" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
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
                                
                                <th class="link" ng-click="orderByField='vendor.name'; reverseSort = !reverseSort">Vendor
                                    <span>
                                        <span ng-show="orderByField == 'vendor.name'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='ordered_on'; reverseSort = !reverseSort">Ordered On
                                    <span>
                                        <span ng-show="orderByField == 'ordered_on'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='received_on'; reverseSort = !reverseSort">Received On
                                    <span>
                                        <span ng-show="orderByField == 'received_on'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                
                                <th class="link" ng-click="orderByField='due_on'; reverseSort = !reverseSort">Due On
                                    <span>
                                        <span ng-show="orderByField == 'due_on'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
								<th class="link" ng-click="orderByField='total_order'; reverseSort = !reverseSort">Total Order
                                    <span>
                                        <span ng-show="orderByField == 'total_order'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
								<th class="link" ng-click="orderByField='total_receive'; reverseSort = !reverseSort">Total Receive
                                    <span>
                                        <span ng-show="orderByField == 'total_receive'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
								<th class="link" ng-click="orderByField='total_amount'; reverseSort = !reverseSort">Total Amount
                                    <span>
                                        <span ng-show="orderByField == 'total_amount'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                <th class="link" ng-click="orderByField='user_name'; reverseSort = !reverseSort">Created By
                                    <span>
                                        <span ng-show="orderByField == 'user_name'">
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
                            <tr ng-class="{highlight: purchaseorder.new == 1}" dir-paginate-start="purchaseorder in purchaseorders | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    <td ng-click="checkbox()">
                                        <input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.purchaseorder_id')">
                                    </td>
                                @endif
                                
                                <td>
                                    @if (Auth::check() && Auth::user()->hasRole(['Superadmin','Admin']))
                                        <a href="/{{$basepath}}/@include('_helpers.purchaseorder_id')"><span ng-bind="purchaseorder.id"></span></a>
                                    @else
                                        <a target="_blank" href="/{{$basepath}}/@include('_helpers.purchaseorder_id')"><span ng-bind="purchaseorder.id"></span></a>
                                    @endif
                                </td>
                                
                                <td>
                                    <span ng-bind="purchaseorder.vendor.name"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="purchaseorder.ordered_on | dateToISO"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="purchaseorder.received_on | dateToISO"></span>
                                </td>
                                
                                <td>
                                    <span ng-bind="purchaseorder.due_on | dateToISO"></span>
                                </td>
								 <td>
                                    <span ng-bind="purchaseorder.total_order"></span>
                                </td>
								 <td>
                                    <span ng-bind="purchaseorder.total_receive"></span>
                                </td>
								 <td>
                                    <span ng-bind="purchaseorder.total_amount"></span>
                                </td>
                                 <td>
                                    <span ng-bind="purchaseorder.created_by"></span>
                                </td>
                               
                                <td>
                                    <span><a href="/{{$route_inventories_path}}/{{$route_receive_product_path}}/@{{purchaseorder.id}}" class=' btn btn-primary btn-xs'>receive</a></span>
                                </td>
                                
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    
                                    <td class="hidable-sm boolean border">
                                        <span ng-if="purchaseorder.disabled"><i class="fa fa-check"></i></span>
                                    </td>
                                    
                                    <td>
                                        <span ng-bind="purchaseorder.updated_at"></span>
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
    var all_purchaseorders = "{{\Config::get('inventory::config.route.api.all-purchaseorders')}}";
    var path = "/"+api_path+"/"+all_purchaseorders;

    var app = angular.module('app', ['angularUtils.directives.dirPagination']);
    
    app.filter('dateToISO', ['$filter', function($filter) {
      return function(input) {
        input = new Date(input);//.toISOString();
        console.log("input");
        if(input != "Invalid Date"){

            return $filter('date')(input, 'MM/dd/yy');
        }else return "Not set yet";
      };
    }]);
    
    function PurchaseorderController($scope, $http, $filter) {
    
        $http.get(path).success(function(v) {
            $scope.purchaseorders = v.data;
            console.log($scope.purchaseorders);
            @include('_helpers.bulk_action_checkboxes')
            
        });
        
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.savePDF = function(){
            var selected = $filter('filter')($scope.purchaseorders,  $scope.search);
            sample = "purchaseorder=";
            sample = sample + JSON.stringify(selected);
           
            $http.post("/print/all", sample, {
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
    
    }
    
    function OtherController($scope) {
        $scope.pageChangeHandler = function(num) {
        };
    }

</script>
@stop