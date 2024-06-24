<?php

namespace App\Http\Controllers;

use App\Models\ModelApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard');
    }
    // public function logout()
    // {
        // session()->forget('user');
        // return redirect((route('login')));
    // }
    public function getSmt($fakid)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        $smt = $modelApi->daftarSemester($token, $fakid);
        $data = $smt->data;
        return $data;
    }

    public function getKelas($id, $fak, $nip)
    {

        // $id = $request->id;
        // $nip = $request->nip;
        // $fakultas = $request->fakultas;
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();

        $getKelas = $modelApi->getDataKelas($token, $id, $nip, $fak);
        $data = $getKelas->data;

        return $data;
        // return response()->json($getKelas);
    }

    public function getDetailKelas($fak, $kls, $nip)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        $getKelas = $modelApi->getDetailKelas($token, $fak, $kls, $nip);
        $data = $getKelas->data;

        return $data;

        // var_dump($token);
    }
}
