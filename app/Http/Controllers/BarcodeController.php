<?php

namespace App\Http\Controllers;

use App\Models\{ModelApi};

use Illuminate\Support\Facades\{Cache, Validator};
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarcodeController extends Controller
{
    public function create($klsId, $klsFakId, $nip)
    {
      
	
		
		  $url = route('kelas.barcode.create', [$klsId, $klsFakId, $nip]);

    // Generate QR code
    $qrCode = QrCode::format('svg')->size(300)->generate($url);
	$qr = 'data:image/svg+xml;base64,'. base64_encode ($qrCode);
	//dd($qrCode);
    return view('kelas.generate', ['qrCode' => $qr, 'url'=> $url]);
		
		
    }
}


