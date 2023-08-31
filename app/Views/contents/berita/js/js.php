<script>
    function formatTampilan(data) {
        if (data.loading) {
            return data.text;
        }
        var markup =
            '<div class="mb-1">' +
            "<div>" + data.text + "</div>"
        "</div>";
        return markup;
    }

    function formatTampilanSelection(data) {
        if (!data.id) {
            return data.text;
        }
        return data.text;
    }

    $('#selectKategori').each(function() {
        $(this).select2({
            ajax: {
                url: '<?= base_url('admin/kategori/list') ?>',
                dataType: 'json',
                type: 'POST',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term, // search term
                        _token: '<?= csrf_hash() ?>'
                    };
                },
                processResults: function(data, params) {
                    var results = [];
                    if (data.code === 400) {
                        results.push({
                            id: "",
                            text: data.message,
                        });
                    } else if (data.code === 404) {
                        results.push({
                            id: "",
                            text: data.message,
                        });
                    } else if (data.code === 200) {
                        console.log()
                        $.each(data.data, function(index, item) {
                            results.push({
                                id: item.id,
                                text: item.nama,
                                name: item.nama,
                            });
                        });
                    }
                    return {
                        results: results,
                    };
                }
            },
            allowClear: true,
            dropdownParent: $(this).parent(),
            placeholder: "Masukkan Kategori",
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 0,
            templateResult: formatTampilan,
            templateSelection: formatTampilanSelection,
        });
    });
</script>

<script>
    $('#berita-modal').on('hidden.bs.modal', function() {
        $('input.form-control').val('');
        $('input[name="_method"]').prop('disabled', true);
        $('#id').val('');

        $('#selectKategori').val('').change();

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
        $('#berita-modal').modal('show');
        $('.modal-title').text('Tambah Berita');
        resetButton('#btn-simpan', 'Simpan');
    });
</script>

<script>
    const edit = (id) => {
        $('#berita-modal').modal('show');
        $('.modal-title').text('Edit Berita');

        $.ajax({
            url: "<?= base_url('admin/berita/edit') ?>",
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
                $('input[name="judulBerita"]').val(data.data.judulBerita);

                var option = new Option(data.data.namaKategori, data.data.kategoriId, true, true);
                $('#selectKategori').append(option).trigger('change');

                $('input[name="deskripsi"]').val(data.data.deskripsi);
            }
        })
    }
</script>

<script>
    $('#btn-simpan').on('click', function(e) {
        e.preventDefault();
        var data = $('#form-berita').serializeArray();
        var id = $('#id').val();
        var url;
        var textBtn;
        if (id === '') {
            url = '<?= base_url('admin/berita/store') ?>';
            textBtn = 'Simpan';
        } else {
            url = '<?= base_url('admin/berita/update') ?>';
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
                $('#berita-modal').modal('hide');
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
                    url: '<?= base_url('admin/berita/delete') ?>',
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '<?= csrf_hash() ?>',
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