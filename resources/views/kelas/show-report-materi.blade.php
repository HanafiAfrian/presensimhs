@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Rekap Ringkasan Perkuliahan ' . $data->data->mkNama)
@section('content-title', 'DATA')

@push('header')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
@endpush

@section('navigation')
<a href="{{ route('kelas.show', [$fak, $kls, $nip]) }}" class="btn btn-primary">Kembali</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Report Ringkasan Perkuliahan') }}</div>

            <div class="card-body">

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelas : </label>
                                            {{$data->data->klsNama}}<br>
                                            <label>Matakuliah : </label>
                                            {{$data->data->mkNama}}<br>
                                            <label>SKS : </label>
                                            {{$data->data->mkSks}}<br>
                                            <label>Prodi :</label>
                                            {{$data->data->prodiJenjang}} - {{$data->data->prodiNama}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Semester : </label>
                                            {{$data->data->semNama}}<br>
                                            <label>Dosen : </label><br>
                                            @foreach ($data->data->dosens as $item)
                                                - {{ $item->dsnNama}}<br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Ringkasan Perkuliahan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="table-1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle">Pertemuan Ke</th>
                                                    <th rowspan="2" style="vertical-align: middle">Jenis Pertemuan</th>
                                                    <th rowspan="2" style="vertical-align: middle">Tanggal Pertemuan
                                                    </th>
                                                    <th colspan="2" style="text-align: center">Materi</th>
                                                    <th rowspan="2" style="vertical-align: middle">Total Mahasiswa</th>
                                                    <th rowspan="2" style="vertical-align: middle">Hadir</th>
                                                    <th rowspan="2" style="vertical-align: middle">Alpa</th>
                                                    <th rowspan="2" style="vertical-align: middle">Sakit</th>
                                                    <th rowspan="2" style="vertical-align: middle">Izin</th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center">Tema </th>
                                                    <th style="text-align: center">Pembahasan </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    // dd($dataPertemuan->data);
                                                @endphp
                                                @if (!is_null($dataPertemuan->data) && is_array($dataPertemuan->data) && count($dataPertemuan->data) > 0)
                                                    @foreach ($dataPertemuan->data as $key => $item)
                                                        <tr>

                                                            <td class="text-center">{{$item->presklsPertemuanKe}}</td>
                                                            <td class="text-center"> @if($item->presklsJenis == 'T')
                                                                Teori
                                                            @else
                                                                Praktek
                                                            @endif
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($item->presklsTanggalPelaksanaan)->format('d-m-Y') }}
                                                            </td>

                                                            <td> {{$item->presklsTema}}</td>
                                                            <td> {{$item->presklsPokokBahasan}}</td>

                                                            <td> {{$item->jmlMhs}}</td>
                                                            <td> {{$item->jmlHadir}}</td>
                                                            <td> {{$item->jmlAlpa}}</td>
                                                            <td> {{$item->jmlSakit}}</td>
                                                            <td> {{$item->jmlIzin}}</td>

                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>

                                            @endsection


                                            @push('footer')

                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
                                                <script type="text/javascript" charset="utf8"
                                                    src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>


                                                <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        var kelasNama = "{{$data->data->klsNama}}";
                                                        var mkNama = "{{$data->data->mkNama}}";
                                                        var mkSks = "{{$data->data->mkSks}}";
                                                        var prodiJenjang = "{{$data->data->prodiJenjang}}";
                                                        var prodiNama = "{{$data->data->prodiNama}}";
                                                        var semNama = "{{$data->data->semNama}}";
                                                        var dosens = @json($data->data->dosens);
                                                        var dosenNames = dosens.map(dosen => "- " + dosen.dsnNama).join("\n");

                                                        var headerData = [
                                                            ['Kelas:', kelasNama],
                                                            ['Matakuliah:', mkNama],
                                                            ['SKS:', mkSks],
                                                            ['Prodi:', prodiJenjang + ' - ' + prodiNama],
                                                            ['Semester:', semNama],
                                                            ['Dosen:', dosenNames]
                                                        ];

                                                        var fileName = 'pertemuan-' + kelasNama + '-' + mkNama + '-' + semNama + '-' + new Date().toISOString().slice(0, 19).replace(/[-:]/g, '');

                                                        $('#table-1').DataTable({
                                                            layout: {
                                                                topStart: {
                                                                    buttons: [
                                                                        {
                                                                            extend: 'excel',
                                                                            filename: fileName,
                                                                            title: 'Daftar Ringkasan Perkuliahan',
                                                                            customize: function (xlsx) {
                                                                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                                                                var numrows = 8; // Menambah satu baris kosong tambahan di sini
                                                                                var clR = $('row', sheet);

                                                                                // Update Row
                                                                                clR.each(function () {
                                                                                    var attr = $(this).attr('r');
                                                                                    var ind = parseInt(attr);
                                                                                    ind = ind + numrows;
                                                                                    $(this).attr("r", ind);
                                                                                });

                                                                                // Create row before data
                                                                                $('row c', sheet).each(function () {
                                                                                    var attr = $(this).attr('r');
                                                                                    var pre = attr.substring(0, 1);
                                                                                    var ind = parseInt(attr.substring(1, attr.length));
                                                                                    ind = ind + numrows;
                                                                                    $(this).attr("r", pre + ind);
                                                                                });

                                                                                function Addrow(index, data) {
                                                                                    var msg = '<row r="' + index + '">';
                                                                                    for (var i = 0; i < data.length; i++) {
                                                                                        var key = data[i].key;
                                                                                        var value = data[i].value;
                                                                                        msg += '<c t="inlineStr" r="' + key + index + '">';
                                                                                        msg += '<is>';
                                                                                        msg += '<t>' + value + '</t>';
                                                                                        msg += '</is>';
                                                                                        msg += '</c>';
                                                                                    }
                                                                                    msg += '</row>';
                                                                                    return msg;
                                                                                }

                                                                                // Insert header rows starting from row 2 to avoid clashing with the title
                                                                                var r1 = Addrow(2, [{ key: 'A', value: 'Kelas:' }, { key: 'B', value: kelasNama }]);
                                                                                var r2 = Addrow(3, [{ key: 'A', value: 'Matakuliah:' }, { key: 'B', value: mkNama }]);
                                                                                var r3 = Addrow(4, [{ key: 'A', value: 'SKS:' }, { key: 'B', value: mkSks }]);
                                                                                var r4 = Addrow(5, [{ key: 'A', value: 'Prodi:' }, { key: 'B', value: prodiJenjang + ' - ' + prodiNama }]);
                                                                                var r5 = Addrow(6, [{ key: 'A', value: 'Semester:' }, { key: 'B', value: semNama }]);
                                                                                var r6 = Addrow(7, [{ key: 'A', value: 'Dosen:' }, { key: 'B', value: dosenNames }]);
                                                                                var r7 = Addrow(8, [{ key: 'A', value: '' }, { key: 'B', value: '' }]); // Baris kosong tambahan

                                                                                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + r6 + r7 + sheet.childNodes[0].childNodes[1].innerHTML;
                                                                            }
                                                                        },
                                                                        {
                                                                            extend: 'pdf',
                                                                            filename: fileName,
                                                                            orientation: 'landscape', 
                                                                            title: 'Daftar Ringkasan Perkuliahan',
                                                                            customize: function (doc) {
                                                                                doc.content.splice(0, 0, {
                                                                                    table: {
                                                                                        body: headerData
                                                                                    },
                                                                                    margin: [0, 0, 0, 12]
                                                                                });
                                                                            }
                                                                        }
                                                                    ]
                                                                }
                                                            },

                                                            pageLength: 500
                                                        });
                                                    });
                                                </script>

                                            @endpush