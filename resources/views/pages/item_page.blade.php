<body>
    <table border="1" align="center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Barcode</th>
                <th>Nama</th>
                <th>Stock</th>
                <th>Harga</th>
                <th>Markup</th>
                <th>Harga Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->bar_code}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->stock}}</td>
                <td>{{$item->harga}}</td>
                <td>{{$item->markup}}</td>
                <td>{{$item->harga + $item->markup}}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
</body>