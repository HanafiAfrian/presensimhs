<?php

namespace App\Http\Controllers;

use App\Models\ModelApi;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthApiController extends Controller
{
    public function loginsso(Request $request)
    {
        if ($request->has('token')) {
            session()->forget('user');
            session()->forget('tokensso');

            try {   
                $client = new Client();
                $response = $client->request('GET', 'https://sso.unand.ac.id/auth/realms/unand/protocol/openid-connect/userinfo', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer '.$request->get('token'),
                    ],
                ]);
                
                $statusCode = $response->getStatusCode();
                
                if ($statusCode === 200) {
                    $userData = json_decode($response->getBody());
                    
                    //GET STATUS USER
                    function getUserState($dn){
                        $dnRead = explode(",", $dn);
                        $rdnRead = explode("=", $dnRead[1]);
                        $userState = $rdnRead[1];
                        return $userState;
                    }
                    $dn = $userData->LDAP_ENTRY_DN;
                    $userState = getUserState($dn);
                    //GET STATUS USER

                    // dd($userState);

                    $uid = isset($userData->UID) ? $userData->UID:null;
                    
                    $modelApi = new ModelApi();
                    $token = $modelApi->tokenApi();


                    if($userState == 'dosen'){
                        $auth = $modelApi->dataDosenSso($token, $uid);
                        $level = 'dosen';
                    }elseif($userState == 'mahasiswa'){
                        $auth = $modelApi->dataMahasiswaSso($token, $uid);
                        $level = 'mahasiswa';
                    }else{
                        try {
                            $auth = $modelApi->dataDosenSso($token, $uid);
                            $level = 'dosen';

                        } catch (\Exception $e) {
                            // echo 'Error: ' . $e->getMessage();
                            try {
                                $auth = $modelApi->dataMahasiswaSso($token, $uid);
                                $level = 'mahasiswa';
                                // dd($auth);
                            } catch (\Exception $e) {
                                dd($e->getMessage(), 'Oops, Terjadi Kesalahan, Harap segera laporkan ke DTI UNAND');
                            }
                        }
                        // dd('Oops, Terjadi Kesalahan, Harap segera laporkan ke DTI UNAND');
                    }


                    //add atribut
                    $data_level = (object) [
                        'level' => $level,
                    ];
                    $auth->data->level = $data_level->level;
                    // $data_merged = json_encode($auth, JSON_PRETTY_PRINT);
                    // dd($auth);
                    //add atribut

                    
                    if ($auth->status == 'success') {
                        session()->put('user', $auth->data);
                        session()->put('tokensso', $request->get('token'));

						// $user = session('user');
						// dd('oke',$user); 
						
                        if($auth->data->level == 'dosen'){
                            return redirect(route('kelas.index'));
                        }elseif($auth->data->level == 'mahasiswa'){
                            return redirect(route('home'));
                        }else{
                            dd('Oops, Terjadi Kesalahan, Harap segera laporkan ke DTI UNAND');
                        }

                    } else {
                        session()->forget('user');
                        session()->forget('tokensso');
                        return redirect(env('SSO_URL'));
                    }
                } else {
                    session()->forget('user');
                    session()->forget('tokensso');
                    return redirect(env('SSO_URL'));
                }
            } catch (RequestException $e) {
                session()->forget('user');
                session()->forget('tokensso');
                return redirect(env('SSO_URL'));
            }
        } else {
            session()->forget('user');
            session()->forget('tokensso');
            return redirect(env('SSO_URL'));
        }
    }
   
    public function logoutsso()
    {
        session()->forget('user');
        session()->forget('tokensso');
        return redirect(env('SSO_URL'));
    }
	
	
	//-----
	// by passt
	  public function login(Request $request)
     {
         $modelApi = new ModelApi();


         $token = $modelApi->tokenApi();

         $credentials = $request->validate([
           'email' => 'required',
            'password' => 'required'
         ]);

         $auth = $modelApi->dataDosen($request->email, $request->password, $token);
        // dd($auth);
        session()->put('user', [
             'dsnId' => $auth->data->dsnId,
             'dsnNip' => $auth->data->dsnNip,
             'dsnNidn' => $auth->data->dsnNidn,
             'dsnNama' => $auth->data->dsnNama,
             'dsnGelarDepan' => $auth->data->dsnGelarDepan,
             'dsnGelarBelakang' => $auth->data->dsnGelarBelakang,
             'prodiKode' => $auth->data->prodiKode,
             'prodiNama' => $auth->data->prodiNama,
             'prodiJenjang' => $auth->data->prodiJenjang,
         ]);
       if ($auth->status == 'success') {
           //  Cache::put('user', $auth->data, now()->addHours(1));

            // // Autentikasi berhasil, arahkan pengguna ke halaman yang sesuai
             return redirect((route('homedosen')));
      } else {
            // // Autentikasi gagal, kembali ke halaman login dengan pesan error
            return back()->with('error', 'Login gagal, silakan coba lagi.');
        }
     }
	 
	 
     public function loginmhs(Request $request)
     {
         $modelApi = new ModelApi();
         $token = $modelApi->tokenApi();
         $credentials = $request->validate([
           'email' => 'required',
            'password' => 'required'
         ]);

         $auth = $modelApi->dataMahasiswa($request->email, $request->password, $token);
        // dd($auth);
		$datauser = json_encode([
             'mhsNim' => $auth->data->mhsNim,
             'mhsNama' => $auth->data->mhsNama,
             'mhsJenkel' => $auth->data->mhsJenkel,
             'mhsAngkatan' => $auth->data->mhsAngkatan,
             'mhsProdiNama' => $auth->data->mhsProdiNama,
             'mhsFakNama' => $auth->data->mhsFakNama,
			  'level' => 'mahasiswa',
            
         ]);
        session()->put('user', json_decode($datauser));
       if ($auth->status == 'success') {
           //  Cache::put('user', $auth->data, now()->addHours(1));

            // // Autentikasi berhasil, arahkan pengguna ke halaman yang sesuai
             return redirect((route('home')));
      } else {
            // // Autentikasi gagal, kembali ke halaman login dengan pesan error
            return back()->with('error', 'Login gagal, silakan coba lagi.');
        }
     }

    // public function logout()
    // {
        // Cache::forget('user');
        // Cache::forget('tokensso');
        // return redirect((route('login')));
    // }
	
	
}
