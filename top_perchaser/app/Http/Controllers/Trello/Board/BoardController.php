<?php

namespace App\Http\Controllers\Trello\Board;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    use HasUrlConstant;

    /**
     * getAllBoards
     *
     * @return view
     */
    public function getAllBoards()
    {
        try {
            # https://api.trello.com/1/organizations/{id}/boards?key=APIKey&token=APIToken

            $response = Http::get($this->baseUrl . $this->organizationUrl . session('memberId') . '/boards' . '/?key=' . session('apiKey') . '&token=' . session('apiToken'));

            $allBoards = json_decode($response->body(), true);

            return view('trello.boards.all-boards', compact('allBoards'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * createBoard
     *
     * @return view
     */
    public function createBoard()
    {
        return view('trello.boards.create-board');
    }

    /**
     * storeBoard
     *
     * @param  Request $request
     * @return view
     */
    public function storeBoard(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            # https://api.trello.com/1/boards/?name={name}&key=APIKey&token=APIToken

            $response = Http::post($this->baseUrl . 'boards/' . '?name=' . $request->name . '&desc=' . $request->description . '&key=' . session('apiKey') . '&token=' . session('apiToken'));
            return redirect()->route('all.boards');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * editBoard
     *
     * @param $id
     * @return view
     */
    public function editBoard($id)
    {
        try {
            # https://api.trello.com/1/boards/{id}?key=APIKey&token=APIToken
            $response = Http::get($this->baseUrl . 'boards/' . $id . '?key=' . session('apiKey') . '&token=' . session('apiToken'));
            $data = json_decode($response->body());
            return view('trello.boards.edit-board', compact('data'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * updateBoard
     *
     * @param  Request $request
     * @param $id
     * @return view
     */
    public function updateBoard(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        # https://api.trello.com/1/boards/{id}?name=&desc=&key=APIKey&token=APIToken

        $response = Http::put($this->baseUrl . 'boards/' . $id . '?name=' . $request->name . '&desc=' . $request->description . '&key=' . session('apiKey') . '&token=' . session('apiToken'));

        return redirect()->route('all.boards');
    }

    /**
     * deleteBoard
     *
     * @param $id
     * @return view
     */
    public function deleteBoard($id)
    {
        # https://api.trello.com/1/boards/{id}?key=APIKey&token=APIToken
        $response = Http::delete($this->baseUrl . 'boards/' . $id . '?key=' . session('apiKey') . '&token=' . session('apiToken'));

        return redirect()->route('all.boards');
    }
}
