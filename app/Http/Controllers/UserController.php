<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\UsersRepository;
use App\User;
use App\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct(UsersRepository $user) {
		$this->middleware('auth');
        $this->user = $user;
	}

    public function index() {
        $messages = count($this->user->getMessages());
        Session::set('messages', $messages);
        return view('welcome');
    }

	public function showProfil($id) {
		$posts = $this->user->getPostsById($id); 
        foreach ($posts as $p) {
            $p->comments = $this->user->getCommentsByPostId($p->id);
            $p->quantite = count($this->user->getCommentsByPostId($p->id));
        } 
        $user = $this->user->getUserById($id); //dd($user);
	    return view('profil', array(
        	'posts'=>$posts,
        	'user'=>$user
        ));
	}

    public function editProfil() {
        return view('editProfil');
    }

    public function profilService(Request $request) {
        $this->validate($request, [
            'name'=> 'required|max:255',
            'email'=>'required|max:255',
            ]);
        $user = User::find(Auth::user()->getAttributes()['id']); 
        $user->name=$_POST['name'];
        $user->email=$_POST['email'];
        $user->save();
        //dd($user);
        return redirect()->route('editProfil'); 
    }

    public function userList() {
        $users = $this->user->getUsers();
        return view('users', array(
            'users'=>$users
            ));
    }

    public function countMessages() {
        $messages = $this->user->getMessages();
    }

    public function files() {
        return view('pagesUpload');  
    }

    
    public function upload() {
        $file = array('image' => Input::file('image'));
        $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000

        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return Redirect::to('upload')->withInput()->withErrors($validator);
        } else {
            if (Input::file('image')->isValid()) {
                $destinationPath = 'uploads';
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111, 99999) . '.' . $extension;
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                \Illuminate\Support\Facades\Session::flash('success', 'Upload successfully');
                return Redirect::to('upload');
            } else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('upload');
            }
        }
    }

    public function backUpload() {
        return view('upload');
    }
}
