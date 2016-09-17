@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <div class="panel panel-default">
                        <div class="col-sm-12"><br>
                    <div id="userSearch">
                            <form action="" class="search-form">
                                <div class="form-group has-feedback">
                                    <label for="search" class="sr-only">Search</label>
                                    <input type="text" class="form-control" name="search" id="search" placeholder="search">
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                foreach ($items as $key => $value):
                    $count='0';
                    foreach($newMessages as $n) {
                        if($n->user_id == $key) { $count++;}
                    }
                    if ($count == '1') {$count.= ' nouveau message';}
                    elseif ($count == '0') {$count= '';}
                    else {$count.= ' nouveaux messages';} ?>

                    <div id="chatUser-<?=$key?>" class="panel-body messageList">
                        <li><?=$value?><span id="count-<?=$key?>" class="pull-right"><?= $count; ?></span></li>
                    </div>      
                    <?php
                endforeach; ?>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">Liste des messages</div>
                <?php 
                foreach ($items as $key => $value): ?>
                    <div id="chat-<?=$key?>" class="displayNone">
                        <?php   
                        foreach($messages as $m) {
                            if($m->sender_id == $key) { ?>
                                    <div class="panel-body received">
                                        <span>{{$m->updated_at}}</span>
                                        <h3>{{$m->content}}</h3>
                                </div>
                           <?php } elseif ($m->receiver_id == $key) { ?>
                                    <div class="panel-body sended">
                                        <span>{{$m->updated_at}}</span>
                                        <h3>{{$m->content}}</h3>
                                    </div>
                           <?php }
                        } ?>
                    </div>
                    <?php 
                endforeach; ?>
            </div>
        </div>
    </div>
</div>
@endsection





