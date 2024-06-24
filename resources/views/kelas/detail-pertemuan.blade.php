@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Daftar Hadir Kelas')
@section('content-title', 'DATA')

@push('header')
<!-- Tambahkan stylesheet Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Daftar Hadir Perkuliahan') }}</div>

            <div class="card-body">

                <section class="content">
                    <div class="container-fluid">

                        <form action="{{route('kelas.pertemuan.store')}}" method="POST" required>
                            @csrf
                            <input type="hidden" name="klsId" id="klsid" value="{{$data->data->klsId}}" required>
                            <input type="hidden" name="klsFakId" id="fakid" value="{{$data->data->klsFakId}}" required>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelas : </label>
                                                {{$data->data->klsNama}}
                                            </div>
                                            <div class="form-group">
                                                <label>Matakuliah : </label>
                                                {{$data->data->mkNama}}
                                            </div>
                                            <div class="form-group">
                                                <label>SKS : </label>
                                                {{$data->data->mkSks}}
                                            </div>
                                            <div class="form-group">
                                                <label>Prodi :</label>
                                                {{$data->data->prodiJenjang}} - {{$data->data->prodiNama}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Semester : </label>
                                                {{$data->data->semNama}}
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen : </label><br>
                                                @foreach ($data->data->dosens as $item)
                                                - {{ $item->dsnNama}}<br>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="text-primary">Buat Pertemuan</h4><br>
                                    <div class="row">
                                        <div class="col-md-6">


                                            <div class="form-group">
                                                <label>TANGGAL PERTEMUAN : </label><br>

                                                <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="{{date('Y-m-d')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>PILIH JADWAL : </label><br>
                                                <select name="jenis" class="form-control" id="jadwalSelect" required>
                                                    <option value="">Pilih Jadwal Kelas</option>
                                                    @foreach ($data->data->jadwal as $key => $item)
                                                    <option value="{{$item->jenis}}">{{$item->hari}}|{{$item->jamMulai}}-{{$item->jamSelesai}}|{{$item->ruNama}}|{{$item->gdNama}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>PILIH PERTEMUAN : (pilih jadwal terlebih dahulu)</label><br>
                                                <select id="pertemuanSelect" name="pertemuan" class="form-control" required>
                                                    <option value="">Pilih Pertemuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>TEMA</label><br>
                                                <input type="text" class="form-control" name="tema" placeholder="Tema" value="" required>
                                            </div>
                                            <div class="form-group">
                                                <label>POKOK BAHASAN</label><br>
                                                <textarea name="pokokbahasan" class="form-control" id="pokokbahasan" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-12 mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Daftar Mahasiswa</h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example2" class="table table-sm table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>NIM</th>
                                                            <th>Nama</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Kehadiran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!is_null($dataAddPertemuan->data) && is_array($dataAddPertemuan->data) && count($dataAddPertemuan->data) > 0)
                                                        @foreach ($dataAddPertemuan->data as $key => $mhs)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>
                                                                {{$mhs->mhsNim}}
                                                                <input type="hidden" name="nim[]" value="{{$mhs->mhsNim}}" required>
                                                            </td>
                                                            <td>{{$mhs->mhsNama}}</td>
                                                            <td>{{$mhs->mhsJenkel}}</td>
                                                            <td>
                                                                <select name="statusHadir[]" class="form-select" required>
                                                                    @foreach ($dataStatusKehadiran->data as $item)
                                                                    <option value="{{$item->statusId}}">{{$item->statusNama}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif

                                                    </tbody>

                                                </table>

                                                <div class="form-group" style="float: inline-end;">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="SIMPAN">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer')
<!-- Tambahkan script Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#tanggal", {
        dateFormat: "Y-m-d", // Format tanggal yang diinginkan
        // Anda juga dapat menambahkan opsi tambahan di sini
    });

    $(document).ready(function() {
        // When jadwal is selected
        $('#jadwalSelect').change(function() {
            var fakid = $('#fakid').val();
            var klsid = $('#klsid').val();
            var jenis = $(this).val();

            if (jenis) {
                // Fetch pertemuan data based on selected jadwal jenis
                $.ajax({
                    url: "{{route('get.pertemuan')}}",
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{$token}}',
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        fakid: fakid,
                        klsid: klsid,
                        jenis: jenis
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var pertemuanOptions = '';
                            $.each(response.data, function(index, pertemuan) {
                                pertemuanOptions += '<option value="' + index + '"> Pertemuan ke - ' + pertemuan + '</option>';
                            });
                            $('#pertemuanSelect').html(pertemuanOptions);
                        } else {
                            console.error('Failed to fetch pertemuan data:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching pertemuan data:', error);
                    }
                });
            } else {
                $('#pertemuanSelect').html('<option value="">Pilih Pertemuan</option>');
            }
        });
    });
</script>


@endpush
