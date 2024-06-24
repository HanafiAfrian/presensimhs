@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Daftar Hadir Kelas')
@section('content-title', 'DATA')

@push('header')
<!-- Tambahkan stylesheet Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush

@section('navigation')
<a href="{{route('kelas.pertemuan.show',[ $presklsid, $fakid])}}" class="btn btn-primary" >Kembali</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('UBAH KEHADIRAN') }}</div>

            <div class="card-body">

                <section class="content">
                    <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelas : </label>
                                                {{$kelas->klsNama}}<br>
                                                <label>Matakuliah : </label>
                                                {{$kelas->mkNama}}<br>
                                                <label>SKS : </label>
                                                {{$kelas->mkSks}}<br>
                                                <label>Prodi :</label>
                                                {{$kelas->mkProdiNama}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Dosen : </label><br>
                                                {{$kelas->dosenPresensiNama}}
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
                                                <table id="example2" class="table table-sm table-bordered table-hover" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Informasi</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!is_null($pesertas) && is_array($pesertas) && count($pesertas) > 0)
                                                        @foreach ($pesertas as $key => $peserta)
														@if($peserta->mhsPresId == $mhsPresId)
                                                        <tr>
                                                            <td width="50%">
                                                                NIM : {{$peserta->mhsNim}}<br>
																NAMA : {{$peserta->mhsNama}}<br>
																KEHADIRAN SAAT INI : <b>{{$peserta->statusNama}}</b>
															</td>
															<td class="" style="width: 50%;">
																<form action="{{ route('kelas.pertemuan.update') }}" method="POST" class="w-100">
																	@csrf
																	<input type="hidden" name="fakid" value="{{ $fakid }}">
																	<input type="hidden" name="presklsid" value="{{ $presklsid }}">
																	<input type="hidden" name="mhsPresId" value="{{ $peserta->mhsPresId }}">
																	<div class="input-group">
																		<select name="statusHadir" class="form-control" required>
																			@foreach ($dataStatusKehadiran->data as $item)
																				<option class="form-control" value="{{ $item->statusId }}" {{ $item->statusId == $peserta->statusId ? 'selected':'' }}>{{ $item->statusNama }}</option>
																			@endforeach
																		</select>
																		&nbsp;&nbsp;<button type="submit" class="btn btn-danger btn-sm">Update</button>
																	</div>
																</form>
															</td>

                                                        </tr>
														@endif
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
