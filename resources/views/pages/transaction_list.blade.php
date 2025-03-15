<body class="bg-light">
    <div class="container bg-white shadow col-md-8 mx-auto mt-5 py-3 px-3 rounded">
        <div class="text-center mt-2">
            <h4>Laporan Transaksi</h4>
        </div>
        <div class="text-end mb-2">
            <button class="btn btn-primary">cetak</button>
        </div>
        <div class="mt-2">
            <table class="table rounded">
                <thead>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Cost</th>
                    <th>Quantity</th>
                    <th>Timestamp</th>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($transactions as $td)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $td->jenis }}</td>
                        <td>{{ $td->nama }}</td>
                        <td>{{ $td->harga }}</td>
                        <td>{{ $td->cost }}</td>
                        <td>{{ $td->jumlah }}</td>
                        <td>{{ $td->updated_at }}</td>
                        <?php $no++; ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>