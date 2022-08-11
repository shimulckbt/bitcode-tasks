<?php

namespace App\Http\Controllers\Trello\List;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{
    use HasUrlConstant;

    /**
     * getAllLists
     *
     * @param $id
     * @return view
     */
    public function getAllLists($id)
    {
        # https://api.trello.com/1/boards/{id}/lists?key=APIKey&token=APIToken

        $response = Http::get($this->baseUrl . 'boards/' . $id . '/lists' . '?key=' . session('apiKey') . '&token=' . session('apiToken'));

        $allLists = json_decode($response->body(), true);
        // $idBoard = $allLists[0]['idBoard'];
        session(['idBoard' => $id]);
        $boardID = $id;
        return view('trello.boards.lists.all-lists', compact('allLists'));
    }

    public function createList()
    {
        return view('trello.boards.lists.create-list');
    }

    /**
     * storeList
     *
     * @param  Request $request
     * @return view
     */
    public function storeList(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        //https://api.trello.com/1/lists?name={name}&idBoard=5abbe4b7ddc1b351ef961414&key=APIKey&token=APIToken

        try {
            $response = Http::post($this->baseUrl . 'lists' . '?name=' . $request->name . '&idBoard=' . session('idBoard') . '&key=' . session('apiKey') . '&token=' . session('apiToken'));

            return redirect()->route('all.lists', session('idBoard'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
