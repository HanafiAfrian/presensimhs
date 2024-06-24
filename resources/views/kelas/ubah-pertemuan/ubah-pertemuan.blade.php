@extends('layouts.app')
@push('menu-active-kelas', 'active')

@section('title', 'Ubah Pertemuan')
@section('content-title', 'Ubah Pertemuan')

@push('header')

@endpush


@section('navigation')
<a href="{{route('kelas.show',[$data->data->klsId, $data->data->klsFakId, $nip])}}" class="btn btn-primary" >Kembali</a>
@endsection


@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">{{ __('Daftar Hadir Perkuliahan') }}</div>

            <div class="card-body">

                <section class="content">
                    <div class="container-fluid">

                        <form action="{{route('kelas.pertemuan.ubah.store')}}" method="POST" required>
                            @csrf
                            <input type="hidden" name="klsId" id="klsId" value="{{$data->data->klsId}}" required>
                            <input type="hidden" name="presklsid" id="presklsid" value="{{$presklsid}}" required>
							
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
                                    <hr>
                                    <h4 class="text-primary">Ubah Pertemuan</h4><br>
                                    <div class="row">
                                    <div class="col-md-8">
<div class="col-md-6">
                                            <div class="form-group">
                                                <label>TEMA</label><br>
                                                <input type="text" class="form-control" name="tema" placeholder="Tema" value="{{$token_data->tema}}" required>
                                            </div>
</div>
<div class="col-md-6">
                                            <div class="form-group">
                                                <label>POKOK BAHASAN</label><br>
                                                <textarea name="pokokbahasan" class="form-control" id="pokokbahasan" cols="30" rows="10">{{$token_data->pokokbahasan}}</textarea>
                                            </div>
</div>
<div class="col-md-6">
<div class="form-group" style="float: inline-end;">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Update">
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
</div>

@endsection

@push('footer')

@endpush
