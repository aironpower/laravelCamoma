@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <h2><?= $post->title?></h2>
            <div class="col-xs-5">
                <h4><span>Ecrit par </span><a href="../profil/<?=$post->poster?>"><?=$post->name?></a></h4>
            </div>
            <?php if($post->poster == Auth::user()->id) {?>
            <div class="col-xs-7">
                <button class="pull-right btn btn-primary" data-toggle="collapse" data-target="#demo">Editer poste</button>
            </div>
            <?php } ?>
            <br><br>
            <div id="demo" class="collapse">
                {{Form::open(array('route'=>'updatePostService'))}} 
                    {{ Form::hidden('post_id', $post->id)}}              
                    {{ Form::label('title', 'Titre')}}    <br>                 
                    {{ Form::text('title', $post->title)}}        <br>           
                    {{ Form::label('texte', 'Contenu')}}   <br>                   
                    {{ Form::textarea('texte', $post->description)}}  <br>
                    {{ Form::button('Envoyer', array(
                        'type'=>'submit',
                        'class'=>'btn btn-primary',
                        ))}}  <br>
                {{Form::close()}}
            </div>
            <div class="panel panel-default">
            <div class="panel-body">
                <h4><?= $post->description?></h4>
            </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if(!empty($post)):?>
                        <h3>Commentaires</h3>
                        <?php if(!empty($comments)): ?>
                            <?php foreach($comments as $c):?>
                                <div class="col-sm-11">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <strong><?=$c->name?></strong><span class="text-muted"> a commenté le 
                                            <?=Carbon\Carbon::parse($c->created)->format('d/m/Y')?></span>
                                        </div>
                                        <div class="panel-body">
                                            <?=$c->comment?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                        <h3>Répondre:</h3>
                        {{Form::open(array('route'=>'newCommentService'))}}  
                            {{ Form::hidden('post_id', $post->id, array(
                                'value'=>$post->id,
                            ))}}                  
                            {{ Form::textarea('comment','',array(
                                'placeholder'=>'Écrivez ici!',
                                'class'=>'form-control'
                            ))}}  <br>
                            {{ Form::button('Envoyer', array(
                                'type'=>'submit',
                                'class'=>'btn btn-primary',
                            ))}}  <br>
                        {{Form::close()}}
                        <!--<form action="newCommentService" method="post">
                            <div class="form-groups">
                                <input name="post_id" value="<?= $post->id?>" type="hidden" />
                                <input name="subjet_id" value="" type="hidden" />
                                <textarea name="comment" class="form-control"></textarea>
                            </div>
                            <div class="form-groups">
                            <button class="btn btn-primary" type="submit">Répondre</button>
                            </div>
                        </form>-->
                    <?php   else: echo "Cet poste n'existe pas";
                            endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection