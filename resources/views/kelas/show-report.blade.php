@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Daftar Hadir Kelas')
@section('content-title', 'DATA')

@push('header')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">

    <style>
        @media print {
            body {
                margin: 0;
                font-family: Arial, sans-serif;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            .header-table td {
                border: none;
                padding: 2px 8px;
            }
        }
    </style>

@endpush

@section('navigation')
<a href="{{ route('kelas.show', [$kls, $fak, $nip]) }}" class="btn btn-primary">Kembali</a>
@endsection


@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Report Pseserta Kelas Perkuliahan') }}</div>

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
                                    <h3 class="card-title">Daftar Peserta Kelas</h3>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="table-1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>NIM </th>
                                                    <th>NAMA</th>
                                                    <th>Hadir</th>
                                                    <th>Alpha</th>
                                                    <th>Sakit</th>
                                                    <th>Izin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    // dd($dataPesertaKelas->data->detail);
                                                    // var_dump($dataPesertaKelas->data->detail[0]);
                                                @endphp
                                                @if (!is_null($dataPesertaKelas->data->detail) && is_array($dataPesertaKelas->data->detail) && count($dataPesertaKelas->data->detail) > 0)
                                                    @foreach ($dataPesertaKelas->data->detail as $key => $item)
                                                        <tr>
                                                            <td>
                                                                {{$key + 1}}
                                                            </td>
                                                            <td>
                                                                {{ $item->mhsNim }}
                                                            </td>

                                                            <td>
                                                                {{ $item->mhsNama }}
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

            </div>

            </section>
        </div>
    </div>
</div>
</div>
@endsection


@push('footer')

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
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

            var fileName = 'peserta-kelas-' + kelasNama + '-' + mkNama + '-' + semNama + '-' + new Date().toISOString().slice(0, 19).replace(/[-:]/g, '');

            $('#table-1').DataTable({
                layout: {
                    topStart: {
                        buttons: [
                            {
                                extend: 'excel',
                                filename: fileName,
                                title: 'Daftar Peserta Kelas',
                                customize: function (xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    var numrows = 8;
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
                                title: 'Daftar Peserta Kelas',
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