<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Transaction Container</h5>

                    <div class="">
                        <form action="">
                            <div class="mb-3">
                                <label for="nama_konsumen" class="form-label">Nama Konsumen</label>
                                <input type="hidden" name="id" name="id" value="1">
                                <input type="text" name="nama_konsumen" id="nama_konsumen" class="form-control" aria-describedby="Nama Konsumen">
                            </div>
                            <div class="mb-3">
                                <label for="plat" class="form-label">Nomor Plat </label>
                                <input type="text" name="plat" id="plat" class="form-control" aria-describedby="plat">
                            </div>
                            <div class="mb-3">
                                <label for="total_harga" class="form-label">Total Harga</label>
                                <input type="number" name="total_harga" id="total_harga" class="form-control" aria-describedby="total_harga" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Belum Lunas">Belum Lunas</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-primary rounded" type="submit">Simpan Transaksi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">
                        Transaction
                    </h5>

                    <div>
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <div class="dropdown">
                                <input type="text" id="search" class="form-control" placeholder="Ketik untuk mencari..." autocomplete="off">
                                <ul class="dropdown-menu" id="dropdown"></ul>
                            </div>
                        </div>
                        <form action="">
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Nama</label>
                                <input type="text" name="item_name" id="item_name" aria-describedby="item_name" class="form-control">

                            </div>
                            <label for="harga" class="form-label">Harga</label>
                            <div class="mb-3 input-group" id="harga">

                                <label for="item_harga" class="input-group-text">Harga | Markup</label>
                                <input type="number" class="form-control" name="item_harga" id="item_harga">
                                <input type="number" class="form-control" name="item_markup" id="item_markup">
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah</label>
                                <input type="Number" class="form-control" name="amount" id="amount" aria-describedby="amount">
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-primary">tambahkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center fw-semibold">
                        Transaction Details
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">nama</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">harga</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">cost</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">amount</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">total harga</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">action</h6>
                            </th>
                        </thead>
                        <tbody class=""></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>



</div>