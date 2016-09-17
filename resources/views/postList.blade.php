@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Liste de postes</div>

    <?php 
    $posts = array_reverse($posts);
    foreach($posts as $p): ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="profil/<?=$p->poster?>" lambdaeverupdated="2"><?=$p->name?></a> <small>dit</small>
                    <div>
                        <?= date($p->created_at)?>
                        <span aria-hidden="true" class="glyphicon glyphicon-comment"></span>
                        <?=$p->comments?>
                    </div>
                    <a href="postView/<?=$p->id?>"><h2><?=$p->title?></h2></a>
                    <?=$p->description?>...
                </div>
             </div>      
    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
@endsection