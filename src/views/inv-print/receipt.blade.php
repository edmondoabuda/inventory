<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta  http-equiv="Content-Type" content="charset=utf-8" />
        <style type="text/css">
            * { font-family: Verdana, Geneva, sans-serif; }
            @page { margin: 180px 50px; }
            #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; text-align: left; }
            #header .page:after { content: counter(page, arial); }
            #footer { position: fixed; left: 0px; bottom: -190px; right: 0px; height: 100px;}
            .alignright { text-align: right; }
            .textindent { text-indent: 10px; }
            #panek { border: 2px inset;padding: 20px;width: 200px;height: 150px;}
    </style>
    </head>
    <body>
        <div id="header">
            <div class="col col-md-12">
                <h6>{{ $currentDate }}</h6>
                <h1>Delivery Receipt</h1>
            </div>
        </div>
        <div id="footer">
            <p align="center">Inapikle.com</p>
        </div>
        <div class="panel" id="rcorners">
            <div class="row">
                <div class="row">
                    <div class="col col-md-12">
                        <span>Details<span> 
                    </div>    
                </div>
                <div class="row">
                    <div class="col col-md-4">
                         <span>PO ID<span> 
                    </div>
                    <div class="col col-md-1">
                         <span>{{ $product.id }}</span> 
                    </div>
                    <div class="col col-md-4">
                         <span>Ordered On<span> 
                    </div>
                    <div class="col col-md-1">
                         <span>{{ $product.ordered_on }}</span> 
                    </div>
                </div>    
                <div class="row">
                    <div class="col col-md-4">
                         <span>PO #<span> 
                    </div>
                    <div class="col col-md-1">
                         <span>{{ $product.refno }}</span> 
                    </div>
                    <div class="col col-md-4">
                         <span>Due On<span> 
                    </div>
                    <div class="col col-md-1">
                         <span>{{ $product.due_on }}</span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                         <span>Vendor<span> 
                    </div>
                    <div class="col col-md-1">
                         <span>{{ $product.refno }}</span> 
                    </div>
                    <div class="col col-md-4">
                         <span>Total Amount<span> 
                    </div>
                    <div class="col col-md-1">
                         <span>{{ $product.total }}</span> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row"></div>
        <div class="row" id="rcorners">
            <div class="col col-md-12">
                <span>Item Details<span> 
            </div>    
            <div class="row">
                <div class="col col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="col col-md-1">Item Name</th>
                                <th class="col col-md-1">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    <span>{{ $item['name'] }}</span>
                                </td>
                                <td>
                                    <span>{{ $item['qty'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

