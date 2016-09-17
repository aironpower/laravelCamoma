@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">Liste des utilisateurs</div>

    <?php 
    $users = array_reverse($users);
    foreach($users as $u): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="profil/<?=$u->id?>"><?=$u->name?></a>
            </div>
         </div>      
    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
@endsection