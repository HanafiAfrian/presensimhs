@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Daftar Hadir Kelas')
@section('content-title', 'DATA')


@section('navigation')
<a href="{{route('kelas.index')}}" class="btn btn-primary" >Kembali</a>
@endsection


@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Daftar Hadir Perkuliahan') }}</div>

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
                                        <a href="{{route('kelas.pertemuan.create',[$data->data->klsId, $data->data->klsFakId, $nip])}}" class="btn btn-danger" ><i class="fas fa-plus-circle"></i> Buat Pertemuan </a>
									</div>
                                    <div class="col-md-6">

                                        <a href="{{route('kelas.show.report.materi',$param)}}" class="btn btn-info" ><i class="fas fa-file"></i> Report Ringkasan Perkuliahan </a>

                                        <a href="{{route('kelas.show.report.pesertakelas',[$data->data->klsId, $data->data->klsFakId, $nip])}}" class="btn btn-warning" ><i class="fas fa-file"></i> Report Absensi Peserta Kelas </a>

									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="row">

                        <div class="col-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Pertemuan</h3>
								</div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
													<th>Tanggal Pelaksanaa </th>
                                                    <th>Pertemuan Ke</th>
                                                    <th>Jenis Pertemuan</th>
                                                    <th>Materi</th>
                                                    <th>Info Kehadiran</th>
                                                    <th>Aksi</th>
												</tr>
											</thead>
                                            <tbody>
												@php
												//dd($dataPertemuan->data);
												@endphp
                                                @if (!is_null($dataPertemuan->data) && is_array($dataPertemuan->data) && count($dataPertemuan->data) > 0)
                                                @foreach ($dataPertemuan->data as $key => $item)
                                                <tr>
                                                    <td>{{$key+1}}</td>
													<td>{{ \Carbon\Carbon::parse($item->presklsTanggalPelaksanaan)->format('d-m-Y') }}</td>

                                                    <td>{{$item->presklsPertemuanKe}}</td>

													<td>{{$item->presklsJenis}}</td>
                                                    <td>
														<b>Tema :</b> {{$item->presklsTema}}<br>
														<b>Pokok Bahasan :</b> {{$item->presklsPokokBahasan}}<br>
														@php
														$token = encrypt(json_encode(['tema'=>$item->presklsTema, 'pokokbahasan'=>$item->presklsPokokBahasan]));
														@endphp

														<a href="{{ route('kelas.pertemuan.ubah', [$data->data->klsId, $item->presklsId]) }}?token={{$token}}" class="btn btn-info btn-xs" title="Ubah Tema dan Pokok Bahasan Pertemuan"><i class="fas fa-edit"></i> Ubah</a>
													
													</td>

													<td>
														<b>Total Mahasiswa :</b> {{$item->jmlMhs}}<br>
														<b>Hadir :</b> {{$item->jmlHadir}}<br>
														<b>Alpa :</b> {{$item->jmlAlpa}}<br>
														<b>Sakit :</b> {{$item->jmlSakit}}<br>
														<b>Izin :</b> {{$item->jmlIzin}}<br>

													</td>

                                                    <td>

														<a href="{{route('kelas.pertemuan.show', [$item->presklsId, $fak])}}" class="btn btn-warning btn-sm"><i class="fas fa-users"></i> Kelola Absensi Mahasiswa</a>
<br><br>
   <a href="{{route('kelas.barcode.create',[$data->data->klsId, $data->data->klsFakId, $nip])}}" class="btn btn-danger" ><i class="fas fa-plus-circle"></i> Generete Barcode </a>
								
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
<script>
    $(document).ready(function(){
        $('.info-kehadiran').each(function() {
            var id = $(this).data('id');
            callApi(id, $(this));
		});
	});

    function callApi(id, targetElement) {
        $.ajax({
            url: "{{route('api.test')}}",
            type: "GET",
            dataType: "json",
            success: function(data){
                var resultHtml = "Data dari server: " + data;
                targetElement.html(resultHtml);

                console.log("Data dari server untuk ID " + id + ": " + data);
			},
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
			}
		});
	}
</script>
@endpush
