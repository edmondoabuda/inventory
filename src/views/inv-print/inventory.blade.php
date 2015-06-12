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
    </head>
    <body>
    <div id="header">
        <div class="col col-md-12">
            <h6 class="page alignright">Page </h6>
            <h6>{{ $currentDate }}</h6>
            <h1>All Inventories</h1>
        </div>
    </div>
    <div id="footer">
        <p align="center">Inapikle.com</p>
    </div>
    </head>
        <div class="row">
            <div class="col col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col col-md-1">ID</th>
                            <th class="col col-md-1">Item Name</th>
                            <th class="col col-md-1">Quantity</th>
                            <th class="col col-md-1">Address</th>
                            <th class="col col-md-1">Warehouse</th>
                            @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                <th class="col col-md-1">Disabled</th>
                                <th class="col col-md-1">Modified</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $inventory)
                        <tr>
                            <td>
                                <span>{{ $inventory['id'] }}</span>
                            </td>
                            <td>
                                <span>{{ $inventory['item']['name'] }}</span>
                            </td>
                            <td class="alignright">
                                <span>{{ $inventory['quantity'] }}</span>
                            </td>
                            <td class="indent">
                                <span>{{ $inventory['address'] }}</span>
                            </td>
                            <td class="indent">
                                <span>{{ $inventory['warehouse']['name'] }}</span>
                            </td>
                            @if (Auth::check() && Auth::user()->hasRole(['Superadmin', 'Admin']))
                                <td class="hidable-sm boolean border">
                                    <span>{{ $inventory['disabled'] }}</span>
                                </td>
                                <td>
                                    <span>{{ $inventory['updated_at'] }}</span>
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

