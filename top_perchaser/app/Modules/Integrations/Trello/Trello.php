<?php

namespace App\Modules\Integrations\Trello;

use Illuminate\Support\Facades\Http;

class Trello
{

	const BASE_API_URL = 'https://api.trello.com/1/';
	const ME_URL = 'members/me/';
	const ORGANOZATION_URL = 'organizations/';
	const API_KEY = '1e954ef8365b3f853e486c490cdeeda1';
	const API_TOKEN = 'a2d3b85ef1ea6913ae7fa4cf4c58191c82ce65f04bbd50ba3762054f46fbd240';

	private $organization_id;

	public function getUser()
	{
		// https://api.trello.com/1/members/{id}/organizations?key=APIKey&token=APIToken

		try {
			$response = Http::get(self::BASE_API_URL . self::ME_URL . self::ORGANOZATION_URL . '/?key=' . self::API_KEY . '&token=' . self::API_TOKEN);
			$arr_response = json_decode($response->body());

			$this->organization_id = $arr_response[0]->id;

			$boards_id = $arr_response[0]->idBoards[0];

			dd($this->organization_id);
		} catch (\Throwable $th) {
			dd($th->getMessage());
		}
	}

	public function allBoards()
	{
		// https://api.trello.com/1/organizations/{id}/boards
		try {
			$response = Http::get(self::BASE_API_URL . self::ME_URL . self::ORGANOZATION_URL . '/?key=' . self::API_KEY . '&token=' . self::API_TOKEN);
			$arr_response = json_decode($response->body());

			$this->organization_id = $arr_response[0]->id;

			$boards_response = Http::get(self::BASE_API_URL . self::ORGANOZATION_URL . $this->organization_id . '/' . 'boards/' . '?key=' . self::API_KEY . '&token=' . self::API_TOKEN);

			$all_boards = json_decode($boards_response->body());

			dd($all_boards);
		} catch (\Throwable $th) {
			dd($th->getMessage());
		}
	}

	public function createBoard()
	{
		// https://api.trello.com/1/boards/?name={name}&key=APIKey&token=APIToken

		try {
			$board_name = 'Shimul Chakraborty';

			$board_create_response = Http::post(self::BASE_API_URL . 'boards/' . '?name=' . $board_name . '?key=' . self::API_KEY . '&token=' . self::API_TOKEN);

			dump(self::BASE_API_URL . 'boards/' . '?name=' . $board_name . '&key=' . self::API_KEY . '&token=' . self::API_TOKEN);

			dd(json_decode($board_create_response->status()));
		} catch (\Throwable $th) {
			dd($th->getMessage());
		}
	}
}
