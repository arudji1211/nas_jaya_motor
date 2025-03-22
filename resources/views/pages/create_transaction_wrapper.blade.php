<div class="container-fluid">
    <style>
        .dropdown-menu {
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            position: absolute;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Transaction Container</h5>

                    <div class="">
                        <form action="">
                            <div class="mb-3">
                                <label for="nama_konsumen" class="form-label">Nama Konsumen</label>
                                <input type="hidden" name="transactionWrapperId" id="transactionWrapperId" value="1">
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
                                <input type="text" id="searchItem" class="form-control" placeholder="Ketik untuk mencari..." autocomplete="off">
                                <ul class="dropdown-menu" id="dropdownSearch"></ul>
                            </div>
                        </div>
                        <form id="formAddTransaction">
                            @csrf
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Nama</label>
                                <input type="text" name="item_nama" id="item_nama" aria-describedby="item_nama" class="form-control">
                                <input type="hidden" id="item_id" name="item_id">
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
<script>
    //search form
    const items = @json($items);
    const searchInput = document.getElementById("searchItem");
    const dropdown = document.getElementById("dropdownSearch");
    const itemIdInput = document.getElementById("item_id");
    const itemNama = document.getElementById("item_nama");
    const itemHarga = document.getElementById("item_harga");
    const itemCost = document.getElementById("item_markup");

    function filteritems() {
        const searchText = searchInput.value.toLowerCase();
        dropdown.innerHTML = "";


        const filtereditems = items.filter(item =>
            item.nama.toLowerCase().includes(searchText)
        );

        if (filtereditems.length === 0) {
            dropdown.innerHTML = `<li class="dropdown-item disabled">Tidak ada hasil</li>`;
        } else {
            filtereditems.forEach(item => {
                const option = document.createElement("li");
                //console.log(item);
                option.classList.add("dropdown-item");
                option.textContent = item.nama;
                option.onclick = function() {
                    searchInput.value = item.nama;
                    itemIdInput.value = item.id;
                    itemNama.value = item.nama;
                    itemHarga.value = item.harga;
                    itemCost.value = item.markup;
                    dropdown.classList.remove("show");
                };
                dropdown.appendChild(option);
            });
        }

        dropdown.classList.toggle("show", filtereditems.length > 0);
    }

    searchInput.addEventListener("input", filteritems);

    document.addEventListener("click", function(event) {
        if (!searchInput.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove("show");
        }
    });
</script>
<script>
    //tambah transaksi
    $(document).ready(function() {
        $('#formAddTransaction').submit(function(e) {
            e.preventDefault();

            //form data
            var formData = {
                _token: "{{ csrf_token() }}",
                item_id: $('#item_id').val(),
                jenis: "pemasukan",
                nama: $('#item_nama').val(),
                transaction_wrapper_id: $('#transactionWrapperId').val(),
                cost: $('#item_harga').val(),
                jumlah: $('#amount').val(),
            }

            console.log(formData);
            $.ajax({
                type: "POST",
                url: "{{ url('user/transaction/create') }}",
                data: formData,
                success: function(response) {
                    alert("Data berhasil disimpan!");
                    $('#formAddTransaction')[0].reset(); // Reset form setelah submit
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseJSON.msg);
                }
            })
        })

    })
</script>