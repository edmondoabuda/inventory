<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/controlpad/inventory/bower_components/angular-xeditable/dist/css/xeditable.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/controlpad/inventory/css/styles.css') }}" />
@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    <div ng-controller="ReceiveController" class="" class="my-controller">
        <div class="row">
            <div class="col col-lg-4 col-xs-12">
                @include('_helpers.breadcrumbs')
                <h1 class="no-top">Delivery Receipt </h1>
            </div>
            <a class="btn btn-default pull-right" target="_blank" ng-click="savePDF()"><i class="fa fa-file-pdf-o"></i></a>
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
		
		<form action='/inv_api/purchaseOrdersReceive' method="POST">
                <div class="row">
                    <div class="col">
                            <h4 class="pull-left"><strong>Items (<span ng-bind="getTotalItems()"></span>) </strong>&nbsp;</h4><div ng-show="itemMessage.length" class="pull-left alert alert-danger"><span ng-bind="itemMessage"></span></div>
                    
                        <div class="form-group pull-right">
                            <h4 class='col-sm-4'><strong>Receipt #</strong></h4>
                            <div class="col-sm-6 ">
                                <input type='text' class='form-control' ng-model='po.receipt_number' name='receipt_number'/>
                            </div>
                        </div>    
                    </div>   
                </div>    
		<div class="row">          
                   
			<div class="col">
				<ul class="media-list">
					<li class="" dir-paginate-start="item in po.polines | filter:search | itemsPerPage: pageSize |orderBy:'-id'" current-page="currentPage" total-items="po.polines.length">
											
						<div class="panel panel-info" ng-show="item.computed_qty > 0">
							<input type='hidden' ng-model='item.purchaseorder_id' name='purchaseorder_id[]' value='@{{item.purchaseorder_id}}'/>
							<div class="panel-body" >
								<div class="row" >
									<div class="col-sm-2">
										<div class="form-group">
											{{ Form::label('name', 'Name') }}
											<div e-class="form-control" e-typeahead="rawitem.name for rawitem in rawitems | filter:$viewValue | limitTo:8" e-name="name" e-required>@{{ item.item.name || 'empty' }} </div>
											
										</div>
									</div>
									
									<div class="col" style="display:none;">
										<div class="form-group">
											<div e-class="form-control" >@{{ item.id || 'empty' }}</div>
											<input type='hidden' ng-model='item.id' name='item_id[]' value='@{{item.id}}'/>
										</div>
									</div>
									<div class="col-sm-1">
										<div class="form-group">
											{{ Form::label('quantity', 'Quantity') }}
											<div e-class="form-control" min="1"name="quantity" onbeforesave="productForm.checkquantity($data)" e-required>@{{ item.qty || 'empty' }}</div>
											
										</div>
									</div>


									<div class="col-sm-1">
										<div class="form-group">
											{{ Form::label('receivables', 'Current') }}
											<div e-class="form-control" min="1"name="receivables" onbeforesave="productForm.checkquantity($data)" e-required>@{{ item.computed_qty || 'empty' }}</div>
											
										</div>
									</div>
									
									<div class="col-sm-2" ng-show="!editableForm.$visible">
										<div class="form-group">
											{{ Form::label('actual_quantity', 'Qty Received') }}
											{{ Form::number('actual_quantity[]', Input::old('actual_quantity'), array('class' => 'form-control','ng-change'=>'setBalance( item)','ng-model'=>'item.actual_quantity','min'=>'0')) }}
											
										</div>
									</div>
                                                                        <div class="col-sm-2">
										<div class="form-group">
											{{ Form::label('actual_price', 'Actual Price') }}
											{{ Form::number('actual_price[]', Input::old('actual_price'), array('class' => 'form-control','ng-model'=>'item.actual_price','min'=>'0')) }}
											
										</div>
									</div>
									
									<div class="col-sm-1" ng-show="!editableForm.$visible">
										<div class="form-group">
											{{ Form::label('remaining_balance', 'Balance') }}
											<div class="form-control" name="remaining-balance"><span ng-bind="item.balance"></span></div>
											<input type='hidden' ng-model='item.balance' name='remaining_balance[]'  value='@{{item.balance}}'/>
										</div>
									</div>
                                                                         <div class="col-sm-2" ng-show="!editableForm.$visible">
										<div class="form-group">
											{{ Form::label('warehouse', 'Warehouse') }}
                                                                                        <select class='form-control' name='warehouse_id[]'>
                                                                                            <option ng-repeat='warehouse in po.warehouse.data' value='@{{warehouse.id}}'>
                                                                                                @{{warehouse.name}}
                                                                                            </option>   
                                                                                        </select>
										</div>
									</div>
								</div>
								
							</div>   
						</div>
							
						
					</li>
					<li dir-paginate-end></li>
				</ul>
			</div>
		</div>
		<div class="row">
            <div class="col col-lg-3 col-md-4 col-sm-6">            
            
                    {{ Form::submit('Recieve', array('class' => 'btn btn-primary')) }}
                   
            </div>
        </div>
		</form>
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
        $scope.setpurchaseorder = function(po)
        {
            $http.get('/inv_api/getPurchaseOrder/'+po).success(function(v) {
                $scope.po = v;
            });
            
            $http.get('/inv_api/all-purchaseorders').success(function(v) {
                $scope.purchaseorders = v.data;
            });    
        };
		
		$scope.setBalance = function(item)
		{
			if(item.actual_quantity > item.computed_qty)
				item.actual_quantity = item.qty;
                        item.balance= item.computed_qty - item.actual_quantity; 
                        
		}
		$scope.saveRecevied = function(polines)
		{
			console.log(polines[0])
			$http({
				url: '/inv_api/purchaserOdersReceive',
				method: "POST",
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				data: $.param(polines[0])
			})
			.success(function(response) {
				console.log(response)
			});
			
		}
		
		
        
        $scope.pageChangeHandler = function(num) {
            
        };
		
		$scope.getTotalItems = function(){
			if($scope.po.hasOwnProperty("polines")){
				var res = $scope.po.polines.filter(function(poline){
					return poline.computed_qty > 0;
				});
				return res.length;
			}
			
			return 0;
		};
        
        $scope.savePDF = function(){
            console.log($scope);
            var selected = {};
            sample = "receipt=";
            sample = sample + JSON.stringify(selected);
            $http.post("/print/receipt", sample, {
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