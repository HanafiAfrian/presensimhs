@extends('layoutsdosen.app')

@push('menu-active-dashboard', 'active')

@section('title', 'Home')
@section('content-title', 'Home')
@section('content')
{{-- <div class="container mt-4"> --}}
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3>Your Information</h3><br>
				<table class="table table-sm">
				@php
				// dd($user);
					    $keyMapping = [
										'dsnNip' => 'NIP',
										'dsnNidn' => 'NIDN',
										'dsnNama' => 'Nama Lengkap',
										'prodiNama' => 'Nama Prodi',
										'prodiJenjang' => 'Jenjang Prodi',
										"mhsNim"=> "NIM",
										"mhsNama"=> "Nama Lengkap",
										"mhsJenkel"=> "Jenis Kelamin",
										"mhsAngkatan"=> "Angkatan",
										"mhsProdiNama"=> "Nama Prodi",
										"mhsFakNama"=> "Nama Fakultas",
										"level"=> "Status User",
									];
				@endphp
				
				@foreach($user as $key => $val)
				@if(isset($keyMapping[$key]))
					<tr>
						<td>{{ $keyMapping[$key] }}</td><td>: {{ $val }}</td>
					</tr>
				@endif
				@endforeach
				</table>
				
            </div>
        </div>
    </div>
</div>
</div>
{{--
    </div> --}}
@endsection
@section('footer_script')

@endsection
