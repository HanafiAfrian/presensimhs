<?php

namespace App\Http\Controllers;

use App\Models\{ModelApi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Validator};
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;



class KelasController extends Controller
{
    public function __construct()
    {
        $user = session('user');
        // dd($user);
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $user = session('user');
        // dd($user);
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        // dd($token);
        $fakultas = $modelApi->daftarFakultas($token);

        // dd($fakultas);

        return view('kelas.index', compact('user', 'fakultas'));
    }

    public function show(Request $request, $kls, $fak, $nip)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        // $fakultas = Crypt::decrypt($fak);
        //   $klsid = Crypt::decrypt($kls);

        $data = $modelApi->getKelas($token, $kls, $fak, $nip);

        $dataPertemuan = $modelApi->getListPertemuan($token, $fak, $kls);
        $crypt = $kls . '.' . $fak . '.' . $nip;
        $param = Crypt::encrypt($crypt);
        return view('kelas.show', compact('data', 'dataPertemuan', 'nip', 'fak', 'param'));
    }

    public function createPertemuan($kls, $fak, $nip)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        $data = $modelApi->getKelas($token, $kls, $fak, $nip);

        $dataAddPertemuan = $modelApi->getDetailKelas($token, $kls, $nip, $fak);
        $dataStatusKehadiran = $modelApi->getStatuskehadiran($token, $fak);

        //dd($data);
        //DIE;
        return view('kelas.create-pertemuan', compact('data', 'dataAddPertemuan', 'dataStatusKehadiran', 'token', 'nip'));
    }


    public function createPertemuanStore(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nim.*' => 'required',
            'statusHadir.*' => 'required',
            'tanggal' => 'required',
            'klsFakId' => 'required',
            'klsId' => 'required',
            'pertemuan' => 'required',
            'jenis' => 'required',
            'tema' => 'required',
            'pokokbahasan' => '',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }


        // Mendapatkan token presensi
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();

        $peserta = [];

        // Mengambil data peserta dari input
        foreach ($request->nim as $key => $nim) {
            $peserta[] = [
                'nim' => $nim,
                'statusId' => $request->statusHadir[$key],
            ];
        }

        $user = session('user');
        $clientIp = $request->ip();
        $nip = $user->dsnNip;
        $dosenNama = $user->dsnNama;

        $data = [
            "fakid" => $request->klsFakId,
            "klsid" => $request->klsId,
            "jeniskls" => $request->jenis,
            "pertemuanke" => $request->pertemuan,
            "tema" => $request->tema,
            "pokokbahasan" => $request->pokokbahasan,
            "tanggal" => $request->tanggal,
            "dsnNip" => $nip,
            "dsnNama" => $dosenNama,
            "dsnIpAddress" => $clientIp,
            "peserta" => $peserta,
        ];

        // dd($nip, $data, $user);

        // Kirim data pertemuan
        $post = $modelApi->postPertemuan($token, $data);


        return redirect(route('kelas.show', [$request->klsId, $request->klsFakId, $nip]))
            ->with('success', 'Pertemuan Berhasil Dibuat!');
    }


    public function ubahPertemuan(Request $request, $klsid, $presklsid)
    {
        $user = session('user');
        $fakultas = $user->fakId;
        $nip = $user->dsnNip;

        if ($request->has('token')) {
            try {

                $token_data = json_decode(decrypt($request->get('token')));

                // dd('Sorry, this page in maintenance!', $user, $presklsid, $token_data);

                $modelApi = new ModelApi();
                $token = $modelApi->tokenPresensi();
                $data = $modelApi->getKelas($token, $klsid, $fakultas, $nip);

                // dd('Sorry, this page in maintenance!', $data);

                return view('kelas.ubah-pertemuan.ubah-pertemuan', compact('data', 'nip', 'presklsid', 'token_data'));
            } catch (DecryptException $e) {
                dd('token invalid!!');
            }
        }
    }


    public function ubahPertemuanStore(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'klsId' => 'required',
            'presklsid' => 'required',
            'tema' => 'required',
            'pokokbahasan' => '',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }


        // Mendapatkan token presensi
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();

        $user = session('user');
        $clientIp = $request->ip();
        $fakultas = $user->fakId;
        $nip = $user->dsnNip;
        $dosenNama = $user->dsnNama;

        $data = [
            "fakid" => $fakultas,
            "presklsid" => $request->presklsid,
            "value" => [
                "tema" => $request->tema,
                "pokokbahasan" => $request->pokokbahasan,
            ]
        ];

        // dd($nip, $data, $user);

        // Kirim data pertemuan
        $execute = $modelApi->ubahPertemuan($token, $data);


        return redirect(route('kelas.show', [$request->klsId, $fakultas, $nip]))
            ->with('success', 'Pertemuan Berhasil Diubah!');
    }


    public function showPertemuan($pklsid, $fakid)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        // $data   = $modelApi->getKelas($token, $kls, $fak, $nip);
        //$fakultas = Crypt::decrypt($fakid);

        $getDataDetailPertemuan = $modelApi->getDetailPertemuan($token, $fakid, $pklsid);

        // dd($getDataDetailPertemuan);

        $user = session('user');
        $nip = $user->dsnNip;

        if (count($getDataDetailPertemuan->data->kelas) > 0) {
            $kelas = json_decode(json_encode($getDataDetailPertemuan->data->kelas));
            $klsid = json_decode(json_encode($getDataDetailPertemuan->data->kelas[0]))->klsId;
            $pesertas = json_decode(json_encode($getDataDetailPertemuan->data->peserta));
        } else {
            return redirect(route('kelas.index'))
                ->with('error', 'Data kelas tidak ditemukan!');
        }


        return view('kelas.show-pertemuan', compact('kelas', 'pesertas', 'pklsid', 'fakid', 'nip', 'klsid'));
    }

    public function editPertemuan($presklsid, $fakid, $mhsPresId)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        // $data   = $modelApi->getKelas($token, $kls, $fak, $nip);

        $getDataDetailPertemuan = $modelApi->getDetailPertemuan($token, $fakid, $presklsid);

        $dataStatusKehadiran = $modelApi->getStatuskehadiran($token, $fakid);

        $kelas = json_decode(json_encode($getDataDetailPertemuan->data->kelas[0]));
        $pesertas = json_decode(json_encode($getDataDetailPertemuan->data->peserta));
        $user = session('user');
        $nip = $user->dsnNip;

        // dd($kelas, $pesertas);

        return view('kelas.edit-peserta-pertemuan', compact('kelas', 'pesertas', 'dataStatusKehadiran', 'presklsid', 'fakid', 'mhsPresId'));
    }


    public function editPertemuanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fakid' => 'required',
            'presklsid' => 'required',
            'mhsPresId' => 'required',
            'statusHadir' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();

        $data = [
            "fakid" => $request->fakid,
            "mhspresid" => $request->mhsPresId,
            "value" => [
                "statusid" => $request->statusHadir
            ]
        ];

        // echo json_encode($data); die;
        // dd($request->all());
        $post = $modelApi->postUpdatePertemuan($token, $data);
        // dd($post);
        return redirect(route('kelas.pertemuan.edit', [$request->presklsid, $request->fakid, $request->mhsPresId]))->with('success', 'Absensi Berhasil Diupdate!');
    }

    public function showReportPesertaKelas(Request $request, $kls, $fak, $nip)
    {


        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        // $fakultas = Crypt::decrypt($fak);
        //   $klsid = Crypt::decrypt($kls);

        $data = $modelApi->getKelas($token, $kls, $fak, $nip);

        $semid = $data->data->semId;

        $jenis = $data->data->jadwal[0]->jenis;


        $dataPesertaKelas = $modelApi->getReportPesertaKelas($token, $fak, $kls, $semid, $jenis);

        // dd($dataPesertaKelas);
        return view('kelas.show-report', compact('data', 'dataPesertaKelas', 'nip', 'fak', 'kls'));
    }











    // ---------------------------------------------------------------------------------- LOAD DATA API
    // ---------------------------------------------------------------------------------- LOAD DATA API
    // ---------------------------------------------------------------------------------- LOAD DATA API
    public function getPertemuan(Request $request)
    {
        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        $data = $modelApi->refPertemuan($token, $request->klsid, $request->jenis, $request->fakid);
        return $data;
    }

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

        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();

        $getKelas = $modelApi->getDataKelas($token, $id, $nip, $fak);
        $data = $getKelas->data;
        //if (is_array($data)) {
        //foreach ($data as $kelas) {
        // foreach ($kelas->dosens as $dosen) {
        //     $dosen->dsnPegNip = Crypt::encrypt($dosen->dsnPegNip);
        // }
        // $kelas->klsId = Crypt::encrypt($kelas->klsId);
        // $kelas->klsFakId = Crypt::encrypt($kelas->klsFakId);
        //}
        //  }

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

    // public function created()
    // {
    //     return view('kelas.index');
    // }

    // public function createKelas()
    // {
    //     $user = Cache::get('user');
    //     return view('kelas.create', compact('user'));
    // }

    public function showReportMateri(Request $request, $id)
    {


        $modelApi = new ModelApi();
        $token = $modelApi->tokenPresensi();
        $param = Crypt::decrypt($id);
        $pecah = explode('.', $param);

        $dataPertemuan = $modelApi->getListPertemuan($token, $pecah[1], $pecah[0]);
        $data = $modelApi->getKelas($token,  $pecah[0],  $pecah[1],  $pecah[2]);
        $kls = $pecah[1];
        $fak = $pecah[0];
        $nip = $pecah[2];
        return view('kelas.show-report-materi', compact('data', 'dataPertemuan', 'nip', 'fak', 'kls'));
    }
}
