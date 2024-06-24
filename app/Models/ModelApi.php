<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ModelApi extends Model
{
    use HasFactory;

    public function tokenApi()
    {
        $url_gettoken = 'https://10.250.25.2/auth/get-token';
        $context_gettoken = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array('userid' => 'presensi', 'pin' => 'cEoiPU')),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );
        $gettoken = file_get_contents($url_gettoken, false, stream_context_create($context_gettoken));
        $token_result = json_decode($gettoken)->token;
        return $token_result;
    }

    public function dataDosenSso($token, $uid)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/profil-dosen';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'uid' => $uid,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $logindosen = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datadosen = json_decode($logindosen);


        return $datadosen;
    }
    public function dataMahasiswaSso($token, $uid)
    {
        $url_loginmahasiswa = 'https://10.250.25.2/presensi/profil-mhs';
        $context_loginmahasiswa = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'uid' => $uid,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $loginmahasiswa = file_get_contents($url_loginmahasiswa, false, stream_context_create($context_loginmahasiswa));

        $datamahasiswa = json_decode($loginmahasiswa);


        return $datamahasiswa;
    }
    
    public function dataDosen($username, $password, $token_result)
    {
        $url_logindosen = 'https://10.250.25.2/siakad/login-dosen';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'username' => $username,
                    'password' => $password
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $logindosen = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datadosen = json_decode($logindosen);


        return $datadosen;
    }



    public function dataMahasiswa($username, $password, $token_result)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/profil-mhs';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'uid' => $username
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $logindosen = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datadosen = json_decode($logindosen);


        return $datadosen;
    }



    public function tokenPresensi()
    {
        $url_gettoken = 'https://10.250.25.2/auth/get-token';
        $context_gettoken = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array('userid' => 'presensi', 'pin' => 'cEoiPU')),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );
        $gettoken = file_get_contents($url_gettoken, false, stream_context_create($context_gettoken));
        $token_result = json_decode($gettoken)->token;
        return $token_result;
    }
    public function daftarFakultas($token_result)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/list-fakultas';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',

                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $fakultas = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datafakultas = json_decode($fakultas);


        return $datafakultas;
    }
    public function daftarSemester($token_result, $fakid)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/list-semester';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fakid,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }



    public function getKelas($token_result, $id, $fak, $nip)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/get-kelas';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fak,
                    'klsid' =>  $id,
                    'nip' => $nip,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }

    public function getDataKelas($token_result, $id, $nip, $fakultas)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/list-kelas';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fakultas,
                    'semid' =>  $id,
                    'nip' => $nip,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }

    public function getListPertemuan($token_result, $fakultas, $id)
    {
        $url_glp = 'https://10.250.25.2/presensi/list-pertemuan';
        $context_glp = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fakultas,
                    'klsid' =>  $id,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $glp = file_get_contents($url_glp, false, stream_context_create($context_glp));

        $dataglp = json_decode($glp);


        return $dataglp;
    }

    public function getDetailKelas($token, $klsid, $nip, $fak)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/list-kelas-detail';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fak,
                    'klsid' =>  $klsid,
                    'nip' => $nip,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }
    public function getStatuskehadiran($token, $fak)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/list-status';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fak
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }

    public function refPertemuan($token, $klsid, $jenis, $fak)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/ref-pertemuan';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fak,
                    'klsid' =>  $klsid,
                    'jenis' => $jenis,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }
    public function postPertemuan($token, $data)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/create-pertemuan';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }
    public function ubahPertemuan($token, $data)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/update-materi-pertemuan';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }
	
    public function postUpdatePertemuan($token, $data)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/update-status-kehadiran';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }
	
    public function getDetailPertemuan($token, $fakid, $pklsid)
    {
        $url_logindosen = 'https://10.250.25.2/presensi/detail-pertemuan';
        $context_logindosen = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' 	=> $fakid,
                    'presklsid' => $pklsid,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token . "\r\n"
            )
        );
        $smt = file_get_contents($url_logindosen, false, stream_context_create($context_logindosen));

        $datasmt = json_decode($smt);


        return $datasmt;
    }


    public function getReportPesertaKelas($token_result, $fakultas, $id, $semid, $jenis)
    {
        $url_glp = 'https://10.250.25.2/presensi/report-peserta-kelas';
        $context_glp = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'fakid' => $fakultas,
                    'klsid' => $id,
                    'semid' => $semid, // "20232",
                    'jenis' => $jenis //"T",
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $glp = file_get_contents($url_glp, false, stream_context_create($context_glp));

        $dataglp = json_decode($glp);


        return $dataglp;
    }
    public function getReportAbsensiMhs($token_result, $nim, $fakultas, $semid)
    {
        $url_glp = 'https://10.250.25.2/presensi/report-absen-mhs-semester';
        $context_glp = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode(array(
                    'nim'   => $nim,
                    'fakid' => $fakultas,
                    'semid' => $semid,
                )),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Bearer " . $token_result . "\r\n"
            )
        );
        $glp = file_get_contents($url_glp, false, stream_context_create($context_glp));

        $data = json_decode($glp);


        return $data;
    }

}
