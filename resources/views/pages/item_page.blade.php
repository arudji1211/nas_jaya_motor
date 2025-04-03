<div class="container-fluid">

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100 h-200">
                <div class="card-body p-4">

                    <div class="mb-4">
                        <h5 class="fw-semibold card-title">
                            Tambah item
                        </h5>
                    </div>
                    <div class="mb-2">
                        <form action="" id="add_item_form">
                            <div class="mb-2">
                                <label for="nama_item_form" class="form-label">Nama</label>
                                <input type="text" id="nama_item_form" class="form-control" placeholder="masukkan nama item" required>
                            </div>
                            <div class="mb-2">
                                <label for="harga_item_form" class="form-label">Harga</label>
                                <input type="number" id="harga_item_form" class="form-control" placeholder="masukkan harga item" required>
                            </div>
                            <div class="mb-2">
                                <label for="markup_item_form" class="form-label">Markup</label>
                                <input type="number" id="markup_item_form" class="form-control" placeholder="masukkan nilai markup per item" required>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_item_form" class="form-label">Jumlah</label>
                                <input type="number" id="jumlah_item_form" class="form-control" placeholder="masukkan jumlah item" value="0" disabled>
                            </div>
                            <div class="mb-2">
                                <button id="simpan_item_form" class="btn btn-primary rounded">
                                    <span>
                                        <i class="ti ti-device-floppy"> Simpan</i>
                                    </span>


                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div>
                        <h5 class="card-title fw-semibold mb-4">
                            List of item
                        </h5>
                    </div>

                    <div class="table-responsive overflow-auto custom-max-height">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">nama</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">stock</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">harga</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">markup</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">tambah stock</h6>
                                </th>
                            </thead>
                            <tbody id="items-table">
                                @foreach($items as $i)
                                <tr>
                                    <td class="fw-semibold mb-0">
                                        {{ $i->nama }}
                                    </td>
                                    <td class="fw-semibold mb-0">
                                        {{ $i->stock }}
                                    </td>
                                    <td class="fw-semibold mb-0">
                                        <script>
                                            document.write(rupiah("{{ $i->harga }}"))
                                        </script>

                                    </td>
                                    <td class="fw-semibold mb-0">
                                        <script>
                                            document.write(rupiah("{{ $i->markup }}"))
                                        </script>
                                    </td>
                                    <td class="text-middle">
                                        <div class="input-group">
                                            <input type="number" class="stock-form-update form-control" placeholder="masukkan jumlah item">
                                            <button class="btn btn-primary btn-action-update" data-id="{{ $i->id }}">
                                                <i class="ti ti-square-plus"></i>
                                            </button>
                                        </div>

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
<script>
    //tambah stock data
    $(document).on('click', ".btn-action-update", function() {
        //ambil row data yang di click
        let row = $(this).closest('tr');
        let jumlah = row.find('.stock-form-update').val();
        let id = $(this).data('id');

        $.ajax({
            url: `{{ url('user/item')}}/${id}/restock `,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                amount: jumlah,
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.msg);

            }
        })
    });
</script>
<script>
    //buat item baru
    $(document).ready(function() {
        $('#add_item_form').submit(function(e) {
            e.preventDefault();

            ///form data
            var formData = {
                _token: "{{ csrf_token() }}",
                harga: $('#harga_item_form').val(),
                markup: $('#markup_item_form').val(),
                nama: $('#nama_item_form').val(),
            }

            $.ajax({
                method: "POST",
                url: `{{ url("user/item/create")}}`,
                data: formData,
                success: function(response) {
                    location.reload();

                },
                error: function(xhr) {
                    alert(xhr.responseJSON.msg);
                }
            })
        })
    })
</script>