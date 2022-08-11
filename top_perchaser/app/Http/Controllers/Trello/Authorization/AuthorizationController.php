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
        session(['apiKey' => $request->apiKey]);
        session(['apiToken' => $request->apiToken]);

        try {
            $response = Http::get($this->baseUrl . $this->meUrl . $this->organizationUrl . '/?key=' . session('apiKey') . '&token=' . session('apiToken'));

            $arrayResponse = json_decode($response->body());

            $memberId = $arrayResponse[0]->id;

            session(['memberId' => $memberId]);
            // dd($memberId);
            return redirect()->route('all.boards');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function getAllBoards()
    {
        try {
            $response = Http::get($this->baseUrl . $this->organizationUrl . session('memberId') . '/boards' . '/?key=' . session('apiKey') . '&token=' . session('apiToken'));

            $allBoards = json_decode($response->body(), true);

            return view('trello.boards.all-boards', compact('allBoards'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function createBoard()
    {
        return view('trello.boards.create-board');
    }

    public function storeBoard(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        try {
            $response = Http::post($this->baseUrl . 'boards/' . '?name=' . $request->name . '&desc=' . $request->description . '&key=' . session('apiKey') . '&token=' . session('apiToken'));
            return redirect()->route('all.boards');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function editBoard($id)
    {
        try {
            // https://api.trello.com/1/boards/{id}?key=APIKey&token=APIToken
            $response = Http::get($this->baseUrl . 'boards/' . $id . '?key=' . session('apiKey') . '&token=' . session('apiToken'));
            $data = json_decode($response->body());
            return view('trello.boards.edit-board', compact('data'));
        } catch (\Throwable $th) {
            $th->getMessage();
        }
    }

    public function updateBoard(Request $request, $id)
    {
        $response = Http::put($this->baseUrl . 'boards/' . $id . '?name=' . $request->name . '&desc=' . $request->description . '&key=' . session('apiKey') . '&token=' . session('apiToken'));
        // dd($response->status());
        return redirect()->route('all.boards');
    }

    public function deleteBoard($id)
    {
        # https://api.trello.com/1/boards/{id}?key=APIKey&token=APIToken
        $response = Http::delete($this->baseUrl . 'boards/' . $id . '?key=' . session('apiKey') . '&token=' . session('apiToken'));
        // dd($response->status());
        return redirect()->route('all.boards');
    }

    public function getAllLists($id)
    {
        # https://api.trello.com/1/boards/{id}/lists?key=APIKey&token=APIToken
        $response = Http::get($this->baseUrl . 'boards/' . $id . '/lists' . '?key=' . session('apiKey') . '&token=' . session('apiToken'));
        // dump($id);
        // dd(json_decode($response->body()));
        $allLists = json_decode($response->body(), true);
        // $idBoard = $allLists[0]['idBoard'];
        session(['idBoard' => $id]);
        return view('trello.boards.lists.all-lists', compact('allLists'));
    }

    public function createList()
    {
        return view('trello.boards.lists.create-list');
    }

    public function storeList(Request $request)
    {
        // dd($request->all());
        //https://api.trello.com/1/lists?name={name}&idBoard=5abbe4b7ddc1b351ef961414&key=APIKey&token=APIToken
        try {
            $response = Http::post($this->baseUrl . 'lists' . '?name=' . $request->name . '&idBoard=' . session('idBoard') . '&key=' . session('apiKey') . '&token=' . session('apiToken'));

            // dd(json_decode($response->body()));
            return redirect()->route('all.lists', session('idBoard'));
        } catch (\Throwable $th) {
            $th->getMessage();
        }
    }

    public function getAllCards($id)
    {
        # https://api.trello.com/1/lists/{id}/cards?key=APIKey&token=APIToken
        $response = Http::get($this->baseUrl . 'lists/' . $id . '/cards' . '?key=' . session('apiKey') . '&token=' . session('apiToken'));
        // dd(json_decode($response->body()));
        $allCards = json_decode($response->body(), true);
        // dd(json_decode($response->body(), true));
        // $idList = $allCards[0]['idList'];
        session(['idList' => $id]);
        // dd(session()->all());
        return view('trello.boards.cards.all-cards', compact('allCards'));
    }

    public function getSingleCard($id)
    {
        # https://api.trello.com/1/cards/{id}?key=APIKey&token=APIToken

        $response = Http::get($this->baseUrl . 'cards/' . $id . '?key=' . session('apiKey') . '&token=' . session('apiToken'));

        $singleCard = json_decode($response->body(), true);
        // dd(json_decode($response->body(), true));
        return view('trello.boards.cards.show-single-card', compact('singleCard'));
    }

    public function createCard()
    {
        return view('trello.boards.cards.create-card');
    }

    public function storeCard(Request $request)
    {
        // dd($request->all());
        # https://api.trello.com/1/cards?idList=5abbe4b7ddc1b351ef961414&key=APIKey&token=APIToken
        try {
            $response = Http::post($this->baseUrl . 'cards' . '?name=' . $request->name . '&desc=' . $request->description . '&idList=' . session('idList') . '&key=' . session('apiKey') . '&token=' . session('apiToken'));

            // dd(json_decode($response->status()));
            return redirect()->route('all.cards', session('idList'));
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
