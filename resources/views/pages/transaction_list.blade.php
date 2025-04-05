<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="mb-2">
                            <h5 class="card-title fw-semibold">Operational Cost</h5>
                        </div>
                        <div>
                            <form id="formAddTransaction">
                                <div class="mb-2">
                                    <label for="namaForm" class="form-label">Nama</label>
                                    <input type="text" id="namaForm" name="namaForm" placeholder="Masukkan nama biaya operasional" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label for="costForm" class="form-label">Cost</label>
                                    <input type="number" id="costForm" class="form-control" placeholder="Masukkkan cost yang dikeluarkan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlahForm" class="form-label">Jumlah</label>
                                    <input type="number" id="jumlahForm" class="form-control" placeholder="isi 1 jika biaya operasional tidak berkelipatan" required>
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary"> simpan </button>
                                </div>
                            </form>
                        </div>
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
                    </div>

                    <div class="table-responsive overflow-auto custom-max-height mb-2">
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

                                        <span class="mb-0 badge rounded-pill <?php

                                                                                if ($td->jenis == 'pemasukan') {
                                                                                    $td->jenis = 'pemasukan';
                                                                                    echo 'bg-primary';
                                                                                } elseif ($td->jenis == 'biaya_operasional') {
                                                                                    $td->jenis = 'biaya operasional';
                                                                                    echo 'bg-danger';
                                                                                } elseif ($td->jenis == 'restock') {
                                                                                    $td->jenis = 'restock';
                                                                                    echo 'bg-success';
                                                                                } ?>">{{ $td->jenis }}</span>


                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">{{ $td->nama }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">
                                            <script>
                                                document.write(rupiah("{{ $td->harga }}"))
                                            </script>

                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="fw-semibold mb-0">
                                            <script>
                                                document.write(rupiah("{{ $td->cost }}"))
                                            </script>
                                        </h6>
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
                    <div class="pagination">
                        {{ $transactions->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        ///ubah status menjadi lunas
        $(document).ready(function() {
            $('#formAddTransaction').submit(function(e) {
                e.preventDefault();

                //form data
                var formData = {
                    _token: "{{ csrf_token() }}",
                    item_id: null,
                    nama: $('#namaForm').val(),
                    cost: $('#costForm').val(),
                    harga: 0,
                    jenis: 'biaya_operasional',
                    transaction_wrapper_id: null,
                    jumlah: $('#jumlahForm').val()
                };

                //hit server
                $.ajax({
                    url: "{{ url('user/transaction/create/biaya_operasional') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {

                        alert("Transaksi berhasil disimpan!");
                    },
                    error: function(xhr) {
                        alert(`Transaksi gagal di simpan -` + xhr.responseJSON.msg);
                    },
                })

            })



        });
    </script>
</div>