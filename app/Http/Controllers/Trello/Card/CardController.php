<?php

namespace App\Http\Controllers\Trello\Card;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CardController extends Controller
{
    use HasUrlConstant;

    /**
     * getAllCards
     *
     * @param $id
     * @return view
     */
    public function getAllCards($id, $idBoard)
    {
        # https://api.trello.com/1/lists/{id}/cards?key=APIKey&token=APIToken
        $response = Http::get($this->baseUrl . 'lists/' . $id . '/cards' . '?key=' . session('apiKey') . '&token=' . session('apiToken'));

        $allCards = json_decode($response->body(), true);

        // $idList = $allCards[0]['idList'];
        session(['idList' => $id]);
        // dd($id);
        $boardID = $idBoard;
        return view('trello.boards.cards.all-cards', compact('allCards', 'boardID'));
    }

    /**
     * getSingleCard
     *
     * @param $id
     * @return view
     */
    public function getSingleCard($id)
    {
        # https://api.trello.com/1/cards/{id}?key=APIKey&token=APIToken

        $response = Http::get($this->baseUrl . 'cards/' . $id . '?key=' . session('apiKey') . '&token=' . session('apiToken'));

        $singleCard = json_decode($response->body(), true);

        return view('trello.boards.cards.show-single-card', compact('singleCard'));
    }

    public function createCard()
    {
        return view('trello.boards.cards.create-card');
    }

    /**
     * storeCard
     *
     * @param Request $request
     * @return view
     */
    public function storeCard(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        # https://api.trello.com/1/cards?idList=5abbe4b7ddc1b351ef961414&key=APIKey&token=APIToken
        try {
            $response = Http::post($this->baseUrl . 'cards' . '?name=' . $request->name . '&desc=' . $request->description . '&idList=' . session('idList') . '&key=' . session('apiKey') . '&token=' . session('apiToken'));

            // dd(json_decode($response->status()));
            return redirect()->route('all.cards', session('idList'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
