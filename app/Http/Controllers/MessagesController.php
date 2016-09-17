<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

use App\Repositories\MessagesRepository;

use App\User;

use App\Message;

use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    public $currentPost=0;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessagesRepository $message) {
        $this->middleware('auth');
        $this->message = $message;
    }
    
	public function showMessages() {	
        $messages = array_reverse($this->message->getMessages());
        $items= array();
        $users = $this->message->getUsers(); 
        $newMessages = array();
        foreach ($messages as $m) {
            if ($m->sender_id != Auth::user()->id){
                $m->io='received';
                $m->user_id = $m->sender_id;
                $m->name=$this->message->getUserById($m->sender_id)->getAttributes()['name'];
                if ($m->type == 'new') {array_push($newMessages, $m);}
            } else {
                $m->io='sended';
                $m->user_id = $m->receiver_id; 
                $m->name=$this->message->getUserById($m->receiver_id)->getAttributes()['name'];
            }
            if (!in_array($m->user_id, $items)) {
                $items[$m->user_id] = $m->name;
            }
        }   //dd($messages);

        return view('messages', array(
            'items'=>$items,
            'messages'=>$messages,
            'newMessages'=>$newMessages
            ));
	}

    public function serviceNewMessage(Request $request) {			//sent from editProfil page
        $this->validate($request, [
            'content'=> 'required',
            'receiver_id'=>'required|max:255',
            ]);
        $message = new Message();
        $message->content=$_POST['content'];
        $message->receiver_id=$_POST['receiver_id'];
        $message->sender_id=Auth::user()->getAttributes()['id'];
        $message->type='new';
        if ($message->receiver_id == $message->sender_id) {
            Session::flash('message', 'Vous ne pouvez pas vous envoyer des messages!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('editProfil');
        }
        $message->save();

        Session::flash('message', 'Message envoyé!'); 
        Session::flash('alert-class', 'alert-success'); 

        $id = $_POST['receiver_id'];
        return Redirect("profil/".$id);
    }

    public function serviceMessage(Request $request) { 				//sent from messages page
        $this->validate($request, [
            'content'=> 'required',
            'receiver_id'=>'required|max:255',
            ]);
        $message = new Message();
        $message->content=$_POST['content'];
        $message->receiver_id=$_POST['receiver_id'];
        $message->sender_id=Auth::user()->getAttributes()['id'];
        $message->type='new';
        if ($message->receiver_id == $message->sender_id) {
            Session::flash('message', 'Vous ne pouvez pas vous envoyer des messages!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('messages');
        }
        $message->save();

        Session::flash('message', 'Message envoyé!'); 
        Session::flash('alert-class', 'alert-success'); 

        return redirect()->route('messages');
    }    

    public function uploadTypeMessages() {
        $sender_id = ($_POST['userid']);
        $receiver_id = Auth::user()->getAttributes()['id'];

        $message = $this->message->uploadMessages($sender_id, $receiver_id);
        foreach ($message as $m) {
            $mess = Message::find($m->id);
            $mess->type = 'seen';
            $mess->save();
        }
        $messages = count($message);
        $count = Session::get('messages');
        $count = $count - $messages;
        $messages = count($this->message->getNewMessages());
        Session::set('messages', $messages);

        $messages = array_reverse($this->message->getMessages());
        $items= array();
        $users = $this->message->getUsers(); 
        $newMessages = array();
        foreach ($messages as $m) {
            if ($m->sender_id != Auth::user()->id){
                $m->io='received';
                $m->user_id = $m->sender_id;
                $m->name=$this->message->getUserById($m->sender_id)->getAttributes()['name'];
                if ($m->type == 'new') {array_push($newMessages, $m);}
            } else {
                $m->io='sended';
                $m->user_id = $m->receiver_id;
                $m->name=$this->message->getUserById($m->receiver_id)->getAttributes()['name'];
            }
            if (!in_array($m->user_id, $items)) {
                $items[$m->user_id] = $m->name;
            }
        }   //dd($messages);

        return view('messages', array(
            'sender_id'=>$sender_id,
            'items'=>$items,
            'messages'=>$messages,
            'newMessages'=>$newMessages
            ));


    }
}
