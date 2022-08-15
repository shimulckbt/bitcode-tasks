<?php

namespace App\Http\Controllers\Trello\Authorization;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthorizationController extends Controller
{
    use HasUrlConstant;

    /**
     * showForm
     *
     * @return view
     */
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
     * @return view
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
            # https://api.trello.com/1/members/me/?key={yourAPIKey}&token={yourAPIToken}

            $response = Http::get($this->baseUrl . $this->meUrl . $this->organizationUrl . '/?key=' . session('apiKey') . '&token=' . session('apiToken'));

            $responseBody = json_decode($response->body());

            $memberId = $responseBody[0]->id;

            session(['memberId' => $memberId]);
            return redirect()->route('all.boards');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * logout
     *
     * @return view
     */
    public function logout()
    {
        session()->forget(['apiKey', 'apiToken', 'memberId', 'idBoard', 'idList']);
        return redirect()->route('home');
    }
}
