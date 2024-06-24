@extends('layouts.app')

@push('menu-active-kelas', 'active')

@section('title', 'Kelas')
@section('content-title', 'Kelas')
@section('content')
    {{-- <div class="container mt-4"> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

                <div class="card-body">

                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label>Daftar Fakultas Perkuliahan</label>
<input type"text" name="nip" id="nip" value="{{$user['dsnNip']}}">
                                        <select class="form-control select2bs4" id="fakultas" name="fakultas"
                                            style="width: 100%;" required>
                                            <option value="" selected="selected">Pilih Fakultas</option>
                                            @foreach ($fakultas->data as $key => $value)
                                                <option value="{{ $value->fakId }}">{{ $value->fakNama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label>Daftar Semester Perkuliahan</label>
                                        <select class="form-control select2bs4" id="smt" name="smt"
                                            style="width: 100%;" required>
                                            <option value="" selected="selected">Pilih Semester</option>

                                        </select>
                                    </div>

                                </div>

                            </div>
                            <div class="row">

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Daftar Matakuliah</h3>
                                            <br>
                              
                                            </br>
                                        </div>

                                        <div class="card-body">
<div class="table-responsive">
                                            <table id="example2" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Matakuliah</th>
                                                        <th>Kelas</th>
                                                        <th>Jadwal</th>

                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>

                                            </table>
</div>                                        
</div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
    {{--
    </div> --}}
@endsection
@section('footer_script')
    <script>
        $(function() {
            $('.select2').select2()

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        $('#fakultas').change(function() {
            var id = $(this).val();
            var namasmtSelect = $('#smt');


            $.ajax({
                url: "{{ route('get.smt', ':id') }}".replace(':id', id),
                method: "GET",

                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        namasmtSelect.append('<option value="' + data[i].semId + '">' + data[i]
                            .semNama + '-' + data[i].semTahun + '</option>');
                    }
                }
            });
        });

        $('#smt').change(function() {
            var smt = $(this).val();
            var nip = $('#nip').val();
            var fakultas = $('#fakultas').val();
            var getDetailKelasRoute = "{{ route('kelas.show', [':klsId', ':fakultas', ':nip']) }}";

            $.ajax({
                url: "{{ route('get.kelas', [':smt', ':fakultas', ':nip']) }}"
                    .replace(':smt', smt)
                    .replace(':fakultas', fakultas)
                    .replace(':nip', nip),
                method: "GET",
                async: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var tableBody = $('#example2 tbody');
                    tableBody.empty();
                    Object.keys(data).forEach(function(key) {
        var row = data[key];
        var rowData = '<tr>' +
            '<td>' + (parseInt(key) + 1) + '</td>' +
            '<td>' + row.mkNama + '</td>' +
            '<td>' + row.klsNama + '</td>';

        // Tambahkan informasi jadwal dalam satu kolom
        var jadwalHTML = '';
        Object.keys(row.jadwal).forEach(function(idx) {
            var jadwal = row.jadwal[idx];
            jadwalHTML += jadwal.hari + ' (' + jadwal.jamMulai + '-' + jadwal.jamSelesai + ') Ruang ' + jadwal.ruNama + '<br>';
        });
        rowData += '<td>' + jadwalHTML + '</td>';

        // Tambahkan kolom aksi
        var detailKelasUrl = getDetailKelasRoute.replace(':klsId', row.klsId).replace(':nip', nip).replace(':fakultas', fakultas);
                rowData += '<td><a class="btn btn-primary" href="' + detailKelasUrl + '">Absensi Kelas</td>';

            // Tutup baris
        rowData += '</tr>';

        // Tambahkan baris ke tabel
        tableBody.append(rowData);});
                    // for (var i = 0; i < data.length; i++) {
                    //     namasmtSelect.append('<option value="' + data[i].semId + '">' + data[i]
                    //         .semNama + '-' + data[i].semTahun + '</option>');
                    // }
                }
            });
        });

        // $('#smt').change(function() {
        //     var id = $(this).val();
        //     var nip = $('#nip').val();
        //     var fakultas = $('#fakultas').val();

        //     $.ajax({

        //         url: "{{ route('get.kelas', [':id', ':fak', ':nip']) }}"
        //     .replace(':id', id)
        //     .replace(':fak', fakultas)
        //     .replace(':nip', nip),
        //         method: "GET",

        //     //     data: {
        //     // id: id,
        //     // nip: nip,
        //     // fakultas: fakultas
        // // },
        //         async: false,
        //         dataType: 'json',
        //         success: function(data) {
        //             console.log(data);
        //         }
        //     });
        // });
    </script>
@endsection
