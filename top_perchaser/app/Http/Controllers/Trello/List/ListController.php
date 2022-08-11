<?php

namespace App\Http\Controllers\Trello\List;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{
    use HasUrlConstant;

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
}
