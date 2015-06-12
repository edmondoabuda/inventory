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
        </style>
<body>
    <div id="header">
        <div class="col col-md-12">
            <h6 class="page alignright">Page </h6>
            <h6>{{ $currentDate }}</h6>
            <h1>All Purchase Orders</h1>
            
        </div>
    </div>
    <div id="footer">
        <p align="center">Inapikle.com</p>
    </div>
    </head>
    <body>
        <div class="row">
            <div class="col col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col col-md-1">ID</th>
                            <th class="col col-md-1">Vendor</th>
                            <th class="col col-md-1">Ordered On</th>
                            <th class="col col-md-1">Received On</th>
                            <th class="col col-md-1">Due On</th>
                            <th class="col col-md-1 alignright">Total Orders</th>
                            <th class="col col-md-1 alignright">Total Received</th>
                            <th class="col col-md-1 alignright">Total Amount</th>
                            @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                <th class="col col-md-1">Disabled</th>
                                <th class="col col-md-1">Modified</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>
                                <span>{{ $item['id'] }}</span>
                            </td>
                            <td>
                                <span>{{ $item['vendor']['name'] }}</span>
                            </td>
                            <td class="tiny">
                                <span>{{ date('m/d/y', strtotime($item['ordered_on'])) }}</span>
                            </td>
                            <td class="tiny">
                                <span>{{ date('m/d/y', strtotime($item['received_on'])) }}</span>
                            </td>
                            <td class="tiny">
                                <span>{{ date('m/d/y', strtotime($item['due_on'])) }}</span>
                            </td>
                            <td class="alignright">
                                <span>{{ $item['total_order'] }}</span>
                            </td>
                            <td class="alignright">
                                <span>{{ $item['total_receive'] }}</span>
                            </td>
                            <td class="alignright">
                                <span>{{ $item['total_amount'] }}</span>
                            </td>
                            @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                <td class="hidable-sm boolean border">
                                    <span>{{ $item['disabled'] }}</span>
                                </td>
                                <td>
                                    <span>{{ $item['updated_at'] }}</span>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

