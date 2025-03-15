<body>
    <div class="container">
        <div class="col-md-8 mx-auto mt-5 rounded shadow-sm bg-white">
            <div class="mx-2 px-2 py-2 ">
                <table class="table px-2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Plat</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        ?>
                        @foreach($transaction_wrappers as $tw)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$tw->plat}}</td>
                            <td>{{$tw->nama_konsumen}}</td>
                            <td>{{$tw->status}}</td>
                            <td>{{$tw->updated_at}}</td>
                            <td><a class="btn warna2 btn-sm rounded" style="color: white;">Detail</a></td>
                        </tr>
                        <?php $no++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>