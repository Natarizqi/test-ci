<script>
    $('#kategori-modal').on('hidden.bs.modal', function() {
        $('input.form-control').val('');
        $('input[name="_method"]').prop('disabled', true);
        $('#id').val('');

        resetValidasiForm();
    });
</script>

<script>
    const dataDatatable = () => {
        $('#data-table').DataTable();
    }
    dataDatatable();
</script>

<script>
    $('#btn-tambah').on('click', function() {
        $('#kategori-modal').modal('show');
        $('.modal-title').text('Tambah Kategori');
        resetButton('#btn-simpan', 'Simpan');
    });
</script>

<script>
    const edit = (id) => {
        $('#kategori-modal').modal('show');
        $('.modal-title').text('Edit Kategori');

        $.ajax({
            url: "<?= base_url('admin/kategori/edit') ?>",
            data: {
                id: id
            },
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function(data) {
                loadingModal();
                $('#btn-simpan').attr("data-kt-indicator", "on");
            },
            success: function(data) {
                resetButton('#btn-simpan', 'Ubah');
                resetLoadingModal();

                $('#id').val(id);
                $('input[name="_method"]').prop('disabled', false);
                $('input[name="namaKategori"]').val(data.data.namaKategori);
            }
        })
    }
</script>

<script>
    $('#btn-simpan').on('click', function(e) {
        e.preventDefault();
        var data = $('#form-kategori').serializeArray();
        var id = $('#id').val();
        var url;
        var textBtn;
        if (id === '') {
            url = '<?= base_url('admin/kategori/store') ?>';
            textBtn = 'Simpan';
        } else {
            url = '<?= base_url('admin/kategori/update') ?>';
            textBtn = 'Ubah';

            data.push({
                name: 'id',
                value: id
            });
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            beforeSend: function(data) {
                $('#btn-simpan').attr("data-kt-indicator", "on");
            },
            success: function(data) {
                $('#kategori-modal').modal('hide');
                resetButton('#btn-simpan', textBtn);
                Swal.fire({
                    icon: "success",
                    title: "Selamat!",
                    text: data.message,
                    padding: '2em',
                    timer: 3000
                }).then(location.reload())
            },
            error: function(data) {
                resetValidasiForm();
                resetButton('#btn-simpan', textBtn);
                if (data.status === 422) {
                    for (const [key, value] of Object.entries(data.responseJSON.response)) {
                        $('input[name="' + key + '"]').addClass('is-invalid');
                        $('textarea[name="' + key + '"]').addClass('is-invalid');
                        $('select[name="' + key + '"]').addClass('is-invalid');
                        $('#' + key).append(value);
                    }
                }
                if (data.status === 400) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.responseJSON.message,
                        icon: 'error',
                        padding: '2em',
                        timer: 3000
                    })
                }
                if (data.status === 500) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi Kesalahan pada server, pastikan sudah di isi dengan benar',
                        icon: 'error',
                        padding: '2em',
                        timer: 3000
                    })
                }
            }
        })
    });
</script>

<script>
    const hapus = (id) => {
        Swal.fire({
            icon: 'warning',
            title: 'Apakah anda yakin?',
            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/kategori/delete') ?>',
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{!! csrf_token() !!}',
                        id: id
                    },
                    success: function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            padding: '2em',
                            timer: 1500,
                        }).then(location.reload())
                    },
                    error: function(data) {
                        if (data.status === 400) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.responseJSON.message,
                                icon: 'error',
                                padding: '2em',
                                timer: 3000
                            })
                        }
                        if (data.status === 500) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi Kesalahan pada server, pastikan sudah di isi dengan benar',
                                icon: 'error',
                                padding: '2em',
                                timer: 3000
                            })
                        }
                    }
                })
            }
        });
    }
</script>