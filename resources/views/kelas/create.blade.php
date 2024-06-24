@extends('layouts.app')
@push('menu-active-home', 'active')

@section('title', 'Daftar Hadir Kelas')
@section('content-title', 'DATA')
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
                                                <label>Pertemuan Ke  :</label>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen Pengampu : {{$user->dsnGelarDepan.$user->dsnNama.$user->dsnGelarBelakang }}</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Daftar Mahasiswa</h3>
                                    </div>

                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th >No.</th>
                                                    <th >Nim</th>
                                                    <th >Absensi</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>192313
                                                    </td>
                                                    <td><select name="absensi" class="form-control"> <option value="">Hadir</option>
                                                        <option value="">Sakit</option>
                                                        <option value="">Alpha</option>

                                                    </select></td>

                                                </tr>

                                            </tbody>

                                        </table>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Buat Pertemuan </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="date" class="form-control datetimepicker-input"
                                data-target="#reservationdate" />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pertemuan Ke 1</label>
                        <select class="form-control select2bs4" style="width: 100%;">
                            <option selected="selected">Pilih Pertemuan</option>
                            <option>Pertemuan 1</option>
                            <option>Pertemuan 2</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary"> <a href="{{ route('createKelas') }}">Buat Kelas</a> </button>
                </div>
            </div>
        </div>
    </div>
@endsection
