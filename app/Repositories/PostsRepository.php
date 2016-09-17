<?php 

namespace App\Repositories;

use App\Post;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

class PostsRepository extends Repository {
	public function model() {
		return 'App\Post';
	}

	public function maRepoMethode() {
		echo "ma repo thode";
		die();
	}

	public function getPosts() {
		return DB::table('post')
			->join('users','post.poster','=', 'users.id')
			->select('post.*','users.name as name')
			->get();
	}

	public function getPostById($postid) {	
		//ORM
		//return Post::find($postid);
		//QueryBuilder
		return DB::table('post')
			->join('users','post.poster','=', 'users.id')
			->where('post.id', $postid)
			->select('post.*','users.name as name')
			->get();
		//return $this->find($id);
	}

	public function getComments($post_id) {
		return DB::table('comment')
			->join('users', 'comment.user_id', '=', 'users.id')
			->where('comment.post_id', $post_id)
			->select('comment.*', 'users.name as name')
			->get();
	}

}