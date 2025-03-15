<body>
    <div class="container">
        <div class="warna1 col-lg-5 col-md-12 mx-auto pt-2 pb-4 px-5 rounded shadow-sm position-absolute top-50 start-50 translate-middle">
            <div class="mt-3">
                <center>
                    <h4>NAS Jaya Motor</h4>
                    <p class="fw-lighter text-secondary"> Jalan Tamalanrea Raya Poros BTP Blok.E No.9, Kec. Tamalanrea, Kota Makassar, Sulawesi Selatan 90245, Indonesia </p>
                </center>
            </div>
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">{{ $trw->nama_konsumen }} </div>
                    <div class="col-md-6 text-end">{{ $trw->plat }}</div>
                </div>

                <div class="mt-3"><b> Detail Pembayaran </b></div>
                <?php
                $total = 0;
                ?>
                <div>
                    @foreach($trw->transactions as $tr)
                    <div class="row">
                        <div class="col-5 mt-1">{{$tr->nama}}</div>
                        <div class="col-1">{{$tr->jumlah}}</div>
                        <div class="col-1"> X </div>
                        <div class="col-2">{{$tr->harga + $tr->cost}}</div>
                        <div class="col-3 text-end">{{$tr->cost_total}}</div>
                        <?php $total += $tr->cost_total; ?>
                    </div>
                    @endforeach
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <b>Total Harga</b>
                    </div>
                    <div class="text-end col-6">
                        <b>Rp. {{$total}}</b>
                    </div>

                </div>

                <div class="mt-3">
                    Status Pembayaran : <span style="color: <?php echo $trw->status == 'Belum Lunas' ? 'red' : 'green'; ?>;">{{$trw->status}}</span>
                </div>
                <div class="mt-2 text-center text-secondary">
                    {{$tr->created_at}}
                </div>


            </div>
        </div>

    </div>
</body>