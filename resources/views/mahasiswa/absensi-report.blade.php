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
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Daftar Fakultas Perkuliahan</label>
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

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" name="cek" value="Lihat" class="btn btn-primary">
                                        </div>

                                    </div>
                                </div>
                            </form>

                            @if (request()->has('cek'))
                                <div class="row">

                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <br>
                                                @php
                                                    //dd($user);
                                                @endphp
                                                Mahasiswa : {{ $user->mhsNama }} ({{ $user->mhsNim }})
                                                </br>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Kode MK</th>
                                                                <th>Mata Kuliah</th>
                                                                <th>Jenis</th>
                                                                <th>Hadir</th>
                                                                <th>Alpha</th>
                                                                <th>Sakit</th>
                                                                <th>Izin</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($data)
                                                                @foreach ($data as $key => $item)
                                                                    <tr>
                                                                        <td>
                                                                            {{ $key + 1 }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $item->mkKode }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $item->mkNama }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $item->jenisKelas }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $item->jmlHadir }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $item->jmlAlpa }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $item->jmlSakit }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $item->jmlIzin }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @else
                                Silahakan Pilih fakultas dan Semester Terlebih Dahulu.
                            @endif
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
    </script>
@endsection
