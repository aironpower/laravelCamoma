<?php 

namespace App\Repositories;

use App\User;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersRepository extends Repository {
	public function model() {
		return 'App\User';
	}

	public function maRepoMethode() {
		echo "ma repo methode";
		die();
	}

	public function getUsers() {
		return DB::table('users')
			->where('users.id', '!=', Auth::user()->id)
			//->join('comment','post.id','=', 'comment.post_id')
			//->select('post.*','comment.comment')
			->get();
	}

	public function getUserById($userid) {	
		//ORM
		return User::find($userid);
		//QueryBuilder
		/*return DB::table('post')
			->join('comment','post_id','=', 'comments.painting_id')
			->where('post.id', $postid)
			->select('post.*','comment.comment')
			->get();*/
		//return $this->find($id);
	}

	public function getPostsById($userid) {
		return DB::table('post')
			->join('users','post.poster','=', 'users.id')
			->where('users.id', $userid)
			->select('post.*','users.name as name')
			->get();
	}

	public function getCommentsByPostId($post_id) {
		return DB::table('comment')
			->where('comment.post_id', $post_id)
			->get();
	}

	public function getMessages() {
		return DB::table('message')
			->where('message.receiver_id', Auth::user()->id)
			->where('message.type','new')
			->get();
	}
}