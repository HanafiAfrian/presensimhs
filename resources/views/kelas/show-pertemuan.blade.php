@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Daftar Hadir Kelas')
@section('content-title', 'DATA')

@push('header')
<!-- Tambahkan stylesheet Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush

@section('navigation')
<a href="{{route('kelas.show',[$klsid, $fakid, $nip])}}" class="btn btn-primary" >Kembali</a>
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
							<div class="col-md-6">
								@if (!is_null($kelas) && is_array($kelas) && count($kelas) > 0)
								@foreach ($kelas as $key => $kls)
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Kelas : </label>
											{{$kls->klsNama}}<br>
											<label>Matakuliah : </label>
											{{$kls->mkNama}}<br>
											<label>SKS : </label>
											{{$kls->mkSks}}<br>
											<label>Prodi :</label>
											{{$kls->mkProdiNama}}
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Dosen : </label><br>
											{{$kls->dosenPresensiNama}}
										</div>
									</div>
								</div>
								@endforeach
								@endif
							</div>
							<div class="col-md-6">
								
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								@if (!is_null($kelas) && is_array($kelas) && count($kelas) > 0)
								@foreach ($kelas as $key => $kls)
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Tema : </label>
											{{$kls->presklsTema}}<br>
											<label>Pokok Bahasan : </label>
											{{$kls->presklsPokokBahasan}}
										</div>
									</div>
									<div class="col-md-12">
										@php
										$token = encrypt(json_encode(['tema'=>$kls->presklsTema, 'pokokbahasan'=>$kls->presklsPokokBahasan]));
										@endphp
										
										<a href="{{ route('kelas.pertemuan.ubah', [$kls->klsId, $kls->presklsId]) }}?token={{$token}}&from=kelas-pertemuan-detail" class="btn btn-info btn-xs" title="Ubah Tema dan Pokok Bahasan Pertemuan"><i class="fas fa-edit"></i> Ubah</a>
									</div>
									
								</div>
								@endforeach
								@endif
							</div>
							<div class="col-md-6">
								
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
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
													
													@if (!is_null($pesertas) && is_array($pesertas) && count($pesertas) > 0)
													@foreach ($pesertas as $key => $peserta)
													<tr>
														<td>{{$key+1}}</td>
														<td>
															{{$peserta->mhsNim}}
														</td>
														<td>{{$peserta->mhsNama}}</td>
														<td>{{$peserta->mhsJenkel}}</td>
														@if($peserta->mhsPresId != null)
														<td>{{ $peserta->statusNama }}</td>
														<td>
															<a href="{{ route('kelas.pertemuan.edit', [$pklsid, $fakid, $peserta->mhsPresId]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
														</td>
													@endif  </tr>
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
				</div>
			</div>
		</div>
	</div>
	
	@endsection
	
	@push('footer')
	
	@endpush
