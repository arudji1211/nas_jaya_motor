<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100 h-200">
                <div class="card-body p-4 ">
                    <div class="row mb-4">
                        <div>
                            <h5 class="card-title fw-semibold">Transactions Container</h5>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#transaction_wrapper_create_modal">tambah</button>
                        </div>
                    </div>

                    <div class="overflow-auto">
                        <ul class="timeline-widget mb-0 position-relative mb-n5 ">
                            @foreach($transaction_wrappers as $td)
                            <li class="timeline-item d-flex position-relative overflow-hidden">



                                <div class="timeline-time text-dark flex-shrink-0 text-end">{{$td->plat}}</div>
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border <?= $td->status == 'Lunas' ? 'border-primary' : 'border-danger'; ?> flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="timeline-desc fs-3 text-dark mt-n1"><a href="{{ url('user/transaction-wrapper/' . $td->id); }}" class="text-dark">Transaction from {{$td->nama_konsumen}}</a></div>

                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4 overflow-auto">
                    <div class="mb-4">
                        <div>
                            <h5 class="card-title fw-semibold">Recent Transactions</h5>
                        </div>
                        <div class="text-end">
                            <a href="" class="btn btn-primary rounded">tambah</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Jenis</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Harga</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Cost</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Quantity</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Timestamp</h6>
                                </th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach($transactions as $td)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $no }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge <?php if ($td->jenis == 'pemasukan') {
                                                                    echo 'bg-primary';
                                                                } else if ($td->jenis == 'biaya_operasional') {
                                                                    echo 'bg-danger';
                                                                    $td->jenis = 'beban';
                                                                } ?> rounded-3 fw-semibold">{{ $td->jenis }}</span>
                                        </div>

                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">{{ $td->nama }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">{{ $td->harga }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">{{ $td->cost }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">{{ $td->jumlah }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">{{ $td->updated_at }}</h6>
                                    </td>
                                    <?php $no++; ?>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="transaction_wrapper_create_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Transaction Wrapper</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            @csrf
                            <label for="nama_konsumen_form" class="form-label">Nama Konsumen</label>
                            <input type="text" name="nama_konsumen_form" id="nama_konsumen_form" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="plat_form" class="form-label">Nomor Plat</label>
                            <input type="number" name="plat_form" id="plat_form" class="form-control">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>

    </div>
</div>