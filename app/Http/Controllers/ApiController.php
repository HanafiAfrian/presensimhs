<?php

namespace App\Http\Controllers;

use App\Models\ModelApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiController extends Controller
{
	public function __construct()
    {
		$user = session('user');
		// dd($user);
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
      return json_encode(['data'=>'oke']);
    }
}
