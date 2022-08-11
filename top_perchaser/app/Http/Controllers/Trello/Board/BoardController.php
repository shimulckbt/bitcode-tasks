<?php

namespace App\Http\Controllers\Trello\Board;

use App\Http\Controllers\Controller;
use App\Traits\Trello\HasUrlConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    use HasUrlConstant;

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
}
