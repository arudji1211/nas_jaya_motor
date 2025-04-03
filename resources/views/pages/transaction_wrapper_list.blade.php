<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">New Transaction Wrapper</h5>
                    <div>
                        <form action="{{ url('user/transaction-wrapper/create')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_konsumen" class="form-label">Nama konsumen</label>
                                <input type="text" name="nama_konsumen" class="form-control" placeholder="Adam">
                            </div>
                            <div class="mb-3">
                                <label for="nama_konsumen" class="form-label">Nomor plat konsumen</label>
                                <input type="text" name="plat" class="form-control" placeholder="DD 1234 XY">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary rounded">create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 align-items-stretch">
            <div class="card w-100">
                <div class="card-body ">

                    <h5 class="card-title fw-semibold mb-4">
                        Transaction Wrapper List
                    </h5>


                    <div class="table-responsive overflow-auto custom-max-height">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <th class="border-bottom mb-0">
                                    <h6 class="fw-semibold mb-0">
                                        Nama Konsumen
                                    </h6>
                                </th>
                                <th class="border-bottom mb-0">
                                    <h6 class="fw-semibold mb-0">
                                        Nomor Plat
                                    </h6>
                                </th>
                                <th class="border-bottom mb-0">
                                    <h6 class="fw-semibold mb-0">
                                        Status
                                    </h6>
                                </th>
                                <th class="border-bottom mb-0">
                                    <h6 class="fw-semibold mb-0">
                                        Tanggal Pembuatan
                                    </h6>
                                </th>
                            </thead>
                            <tbody class="">
                                @foreach($transaction_wrappers as $tw)

                                <tr onclick='window.location=`{{ url("user/transaction-wrapper/$tw->id") }}`'>

                                    <td class="fw-semibold mb-0">
                                        {{$tw->nama_konsumen}}
                                    </td>
                                    <td class="fw-semibold mb-0">
                                        {{$tw->plat}}
                                    </td>
                                    <td class="fw-semibold mb-0">
                                        <span class="badge rounded-pill <?= $tw->status == 'Belum Lunas' ? 'text-bg-warning' : 'text-bg-primary' ?>">{{$tw->status}}</span>
                                    </td>
                                    <td class="fw-semibold mb-0">
                                        {{$tw->created_at}}
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>