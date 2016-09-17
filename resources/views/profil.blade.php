@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading"><h2><?=$user->getAttributes()['name']?></h2></div>

                <div class="panel-body">
                    <i class="glyphicon glyphicon-envelope" style="display:inline-block;"></i><a href="mailto:<?=$user->email?>"> <?=$user->email?></a></p>
                    <br />
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" data-toggle="collapse" data-target="#demo">Envoyer message</button><br><br>              
                        <div id="demo" class="collapse">
                            {{Form::open(array('route'=>'messageNewService'))}}
                                {{ Form::hidden('receiver_id', $user->getAttributes()['name'])}}                   
                                {{ Form::textarea('content', '', array(
                                    'class'=>'col-xs-4 form-control'
                                    ))}}  
                                {{ Form::button('Envoyer', array(
                                    'type'=>'submit',
                                    'class'=>'btn btn-primary',
                                    ))}}  <br>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <?php 
                    if(isset($posts)) {
                        $posts = array_reverse($posts);
                        foreach($posts as $p):?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?= date($p->created_at)?>
                                    <span aria-hidden="true" class="glyphicon glyphicon-comment"></span>
                                    <?=$p->quantite?>
                                    <a href="../postView/<?=$p->id?>"><h2><?=$p->title?></h2></a>
                                    <?=$p->description?>...
                                </div>
                            </div>
                        <?php endforeach; 
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection