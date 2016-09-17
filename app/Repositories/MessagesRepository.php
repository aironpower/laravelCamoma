<?php 

namespace App\Repositories;

use App\Message;
use App\User;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessagesRepository extends Repository {
	public function model() {
		return 'App\Message';
	}

	public function getMessages() {
		$id = Auth::user()->id;
		return DB::table('message')
			->where('sender_id', $id)
			->orwhere('receiver_id', $id)
			->get();
	}

	public function getUsers() {
		return DB::table('users')
			->get();
	}

	public function getUserById($id) {
		return User::find($id);
	}

	public function uploadMessages($sender, $receiver) {
		return DB::table('message')
			->where('sender_id', $sender)
			->where('receiver_id', $receiver)
			->where('type', 'new')
			->get();
	}

	public function getNewMessages() {
		return DB::table('message')
			->where('message.receiver_id', Auth::user()->id)
			->where('message.type','new')
			->get();
	}

}