<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/controlpad/inventory/bower_components/angular-xeditable/dist/css/xeditable.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/controlpad/inventory/css/styles.css') }}" />
@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    <div ng-controller="ReceiveController" class="" class="my-controller">
        <div class="row">
            <div class="col col-lg-4 col-xs-12">
                @include('_helpers.breadcrumbs')
                <h1 class="no-top">Receive Products</h1>
            </div>
            <a class="btn btn-default pull-right margin-right-1" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
        </div>      
        <div class="row">
            <div class="col">
                <form class="form-horizontal" editable-form name="editablePOForm" onaftersave="savePO($data)">
                    {{ Form::hidden('inv-model','purchaseorder')}}
                    <div class="panel panel-success">
                        <div class="panel-header">
                        </div>
                       
                            <div class="row">
                                <div class="col-sm-5">
                                
                                    <div class="form-group">
                                        {{ Form::label('po_id', 'PO ID', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-disabled e-class="form-control" editable-text="po.id" e-name="po_id" onbeforesave="vendorForm.checkprice($data)" e-required>PO@{{ po.id || ' empty' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('po_number', 'PO #', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-text="po.po_number" e-name="po_number" onbeforesave="vendorForm.checkprice($data)">@{{ po.po_number || 'PO'+(po.id || ' empty')  }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {{ Form::label('vendor', 'Vendor', array('class'=>'control-label col-sm-4')) }}
                                        <div class="col-sm-7 form_txt">
                                            <div e-class="form-control" editable-select="po.vendor_id" e-name="vendor_id" onbeforesave="vendorForm.checkprice($data)" e-ng-options="s.id as s.name for s in vendors" e-ng-change="setVendor($data)" e-required>@{{ po.vendor.name || 'Not set' }}</div>
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
                                            <div e-class="form-control" editable-text="po.total_amount" e-name="total_amount" onbeforesave="vendorForm.checkprice($data)"><span ng-bind="po.total_amount | currency"></span></div>
                                                
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
				</form>	
			</div>			
        </div>            
		<div class="row">
			<div class="col">
				<h4 class="pull-left"><strong>Items (<span ng-bind="po.polines.length"></span>) </strong>&nbsp;</h4><div ng-show="itemMessage.length" class="pull-left alert alert-danger"><span ng-bind="itemMessage"></span></div>
			</div>
		</div>
		
		<div class="row">
			<div class="col">
				<ul class="media-list">
					<li class="" dir-paginate-start="item in po.polines | filter:search | itemsPerPage: pageSize |orderBy:'-id'" current-page="currentPage" total-items="po.polines.length">
						<input type='hidden' ng-model='item.purchaseorder_id' name='purchaseorder_id[]' value='@{{item.purchaseorder_id}}'/>					
						<div class="panel panel-info">
							
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											{{ Form::label('name', 'Name : ') }}
											<label ng-bind="item.item.name || 'empty'"></label>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											{{ Form::label('quantity', 'Quantity : ') }}
											<label ng-bind="item.qty || 'empty'"></label>
										</div>
									</div>	
									<div class="col-sm-3">
										<div class="form-group">
											{{ Form::label('remaining_balance', 'Remaining Balance : ') }}
											<label ng-bind="item.computed_qty || 'empty'"></label>
										</div>
									</div>		
							
								</div>
								<div class="row">
								
									<table class='table table-bordered'>
										<tr>
											<td>Receive</td>
                                            <td>Actual Price</td>
                                            <td>Recept # </td>
											<td>Date</td>
										</tr>
										<tr dir-paginate-start="receive in item.item.receives | filter:search | itemsPerPage: item.receives.length |orderBy:'-id'" current-page="currentPage" total-items=" item.receives.length">
											<td> <span ng-bind="receive.actual_quantity"></span></td>
                                            <td> <span ng-bind="receive.actual_price"></span></td>
                                            <td> <span ng-bind="receive.receipt_number"></span></td>
											<td>  <span ng-bind="receive.created_at | dateToISO"></span></td>
										<tr dir-paginate-end>
									</table>
								</div>
								
							</div>   
						</div>
							
						
					</li>
					<li dir-paginate-end></li>
				</ul>
			</div>
		</div>		
		
    </div>
</div>
@stop
@section('scripts')
{{ HTML::script(URL::asset('packages/controlpad/inventory/bower_components/angular-xeditable/dist/js/xeditable.min.js') ) }}
<script>

    var app = angular.module('app', ['angularUtils.directives.dirPagination','xeditable','ui.bootstrap']);
    
    app.filter('dateToISO', ['$filter', function($filter) {
      return function(input) {
        input = new Date(input);//.toISOString();
        console.log("input");
        if(input != "Invalid Date"){
            return $filter('date')(input, 'EEE, MMMM d, y');
        }else return "Not set yet";
      };
    }]);
    
    function ReceiveController($scope, $http) {

        $scope.currentPage = 1;
        $scope.pageSize = 20;
        $scope.meals = [];
        $scope.po = [];
        $scope.purchaseorders = [];
		
        $http.get('/inv_api/getPurchaseOrder/{{$po_id}}').success(function(v) {
                $scope.po = v;
				$scope.pageSize = v.polines.length;
            });       
		
		$scope.setBalance = function(item)
		{
			if(item.actual_quantity > item.qty)
				item.actual_quantity = item.qty;
			item.balance = item.computed_qty - item.actual_quantity;
		}	
		
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.savePDF = function(){
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