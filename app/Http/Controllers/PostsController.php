<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\Repositories\PostsRepository;

use App\Post;

use App\Comment;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\RedirectResponse;

class PostsController extends Controller
{

    public $currentPost=0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostsRepository $post) {
        $this->middleware('auth');
        $this->post = $post;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = $this->post->getPosts();
        foreach ($posts as $p) {
            $p->comments = count($this->post->getComments($p->id));
        }
        return view('postList', array(
            'posts'=>$posts,
            ));
    }

    public function postView($post_id) {
        $comments = $this->post->getComments($post_id);
        $post = $this->post->getPostById($post_id)[0];
        return view('postView', array(
            'comments'=>$comments,
            'post'=>$post,
            ));
    }

    public function serviceNewPost(Request $request) {
        $this->validate($request, [
            'title'=> 'required|max:255',
            'texte'=>'required',
            ]);
        $post = new Post();
        $post->title = $_POST['title'];
        $post->description = $_POST['texte'];
        $post->poster= Auth::user()->id;
        $post->save();

        Session::flash('message', 'Poste partagé correctement!'); 
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('postList');  
    }

    public function serviceUpdatePost(Request $request) {
        $this->validate($request, [
            'title'=> 'required|max:255',
            'texte'=>'required',
            'post_id'=>'required'
            ]);
        $post = Post::find($_POST['post_id']);
        $post->title = $_POST['title'];
        $post->description = $_POST['texte'];
        $post->poster= Auth::user()->id;
        $post->save();

        Session::flash('message', 'Poste modifié correctement!'); 
        Session::flash('alert-class', 'alert-success');

        $comments = $this->post->getComments($_POST['post_id']);
        $post = $this->post->getPostById($_POST['post_id'])[0];
        $id = $_POST['post_id'];
        return Redirect("postView/".$id);
    }

    public function newCommentService(Request $request) {
        $this->validate($request, [
            'comment'=> 'required',
            ]);
        $comment = new Comment();
        $comment->comment = $_POST['comment'];
        $comment->post_id =  $_POST['post_id'];
        $comment->user_id= Auth::user()->id;
        $comment->save();

        Session::flash('message', 'Commentaire posté correctement!'); 
        Session::flash('alert-class', 'alert-success');
        
        $comments = $this->post->getComments($_POST['post_id']);
        $post = $this->post->getPostById($_POST['post_id'])[0];
        
        $id = $_POST['post_id'];
        return Redirect("postView/".$id);
    }

}
