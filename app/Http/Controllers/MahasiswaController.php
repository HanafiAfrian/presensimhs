<?php

namespace App\Http\Controllers;

use App\Models\{ModelApi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Validator};
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;



class MahasiswaController extends Controller
{
    public function __construct()
    {
        $user = session('user');
        // dd($user);
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {

    }

    public function absensiReport(Request $request)
    {
        $user = session('user');
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();

        $data = null;


        if ($request->isMethod('post')) {

            $request->validate([
                'fakultas' => 'required',
                'smt' => 'required',
            ]);

            if ($request->has('fakultas') && $request->has('smt')) {

                $getAbsensiReport = $modelApi->getReportAbsensiMhs($token, $user->mhsNim, $request->fakultas, $request->smt);
                $data = $getAbsensiReport->data;

            //    dd($data);

            }
        }



        $fakultas = $modelApi->daftarFakultas($token);

        return view('mahasiswa.absensi-report', compact('data', 'user', 'fakultas'));
    }

 public function ambilabsensi(Request $request)
    {
        
		$user = session('user');
        return view('mahasiswa.ambil-absensi', compact('user'));
    }
	
	

    public function receiveQr(Request $request)
    {
        
        $request->validate([
            'qr' => 'required|string',
            'mhsNim' => 'required|string',
        ]);

        $qrData = json_decode(str_replace("'", '"', $request->qr), true);

     
        if ($qrData === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid qr format'
            ], 400);
        }

     
        $response = [
            'status' => 'success',
            'message' => 'qr received',
            'mhsNim' => $request->mhsNim,
            'fakid' => $qrData['fakid'],
            'kelasid' => $qrData['kelasid']
        ];

        return response()->json($response);
    }


}