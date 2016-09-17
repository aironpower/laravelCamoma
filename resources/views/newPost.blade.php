@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

				@if (count($errors)>0)
			        <div class="alert alert-danger">
			            <ul>
			                @foreach ($errors->all() as $error)
			                    <li>{{$error}}</li>
			                @endforeach
			            </ul>
			        </div>
			    @endif
			    <div class="container">
			        <div class="content">
			        	<h1>Nouveau Poste</h1>
						<div class="col-md-5">
				            {{Form::open(array('route'=>'newPostService'))}}               
				                {{ Form::label('title', 'Titre')}}    <br>                 
				                {{ Form::text('title', '', array(
									'class'=>'form-control'
				                ))}}        <br>           
				                {{ Form::label('texte', 'Contenu')}}   <br>                   
				                {{ Form::textarea('texte','', array(
				                	'placeholder'=>'Écrivez ici!',
									'class'=>'form-control col-xs-4',
									'rows'=>'5',
				                ))}}  <br>
				                {{ Form::button('Envoyer', array(
				                    'type'=>'submit',
				                    'class'=>'btn btn-primary',
				                ))}}  <br>
				            {{Form::close()}}
				        </div>
			        </div>  <br>
			    </div>
	        </div>
	    </div>
    </div>
</div>


@endsection