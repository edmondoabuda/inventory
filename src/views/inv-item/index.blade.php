@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => $basepath.'/disable', 'method' => 'POST')) }}
        <div ng-controller="ItemController" class="my-controller">
            <div class="page-actions">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-top pull-left no-pull-xs">All Items</h1>
                        <div class="pull-right hidable-xs">
                            <div class="input-group pull-right">
                                <span class="input-group-addon no-width">Count</span>
                                <input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
                            </div>
                            <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
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
                            <tr ng-class="{highlight: item.new == 1}" dir-paginate-start="item in items | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    <td ng-click="checkbox()">
                                        <input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.item_id')">
                                    </td>
                                @endif
                                
                                <td>
                                    <span ng-bind="item.id"></span>
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
                                
                                @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                    
                                    <td class="hidable-sm boolean border">
                                        <span ng-if="item.disabled"><i class="fa fa-check"></i></span>
                                    </td>
                                    
                                    <td>
                                        <span ng-bind="item.updated_at"></span>
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
    var all_items = "{{\Config::get('inventory::config.route.api.all-items')}}";
    var path = "/"+api_path+"/"+all_items;

    var app = angular.module('app', ['angularUtils.directives.dirPagination']);
    
    function ItemController($scope, $http, $filter) {
    
        $http.get(path).success(function(v) {
            $scope.items = v.data;
            console.log($scope.items);
            @include('_helpers.bulk_action_checkboxes')
            
        });
        
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        
        $scope.pageChangeHandler = function(num) {
            
        };

        $scope.savePDF = function(){
            var selected = $filter('filter')($scope.items,  $scope.search);
            sample = "item=";
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
    
    function OtherController($scope) {
        $scope.pageChangeHandler = function(num) {
        };
    }

</script>
@stop