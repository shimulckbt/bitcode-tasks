<?php

namespace App\Http\Controllers\Trello\Authorization;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthorizationController extends Controller
{
    use HasUrlConstant;

    public function showForm()
    {
        if (session()->has('apiToken')) {
            return redirect()->route('all.boards');
        }
        return view('trello.index');
    }

    /**
     * getAuthorized
     *
     * @param  Request $request
     * @return void
     */
    public function getAuthorized(Request $request)
    {
        $request->validate([
            'apiKey' => 'required',
            'apiToken' => 'required',
        ]);

        session(['apiKey' => $request->apiKey]);
        session(['apiToken' => $request->apiToken]);

        try {
            $response = Http::get($this->baseUrl . $this->meUrl . $this->organizationUrl . '/?key=' . session('apiKey') . '&token=' . session('apiToken'));

            $arrayResponse = json_decode($response->body());

            $memberId = $arrayResponse[0]->id;

            session(['memberId' => $memberId]);
            return redirect()->route('all.boards');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function logout()
    {
        session()->forget(['apiKey', 'apiToken', 'memberId', 'idBoard', 'idList']);
        return redirect()->route('home');
    }
}
