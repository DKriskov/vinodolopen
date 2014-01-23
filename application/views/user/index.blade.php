@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Svi igrači</h1>
		
		<div class="separator"></div>
	</div>
	<div class="row-fluid">
	<?php 
	$players_num = count($users); 
	echo '<div class="span6">';	
	foreach($users as $key => $user){ 
		if($key < $players_num/2){
			echo '<h4><img class="img-circle" src="http://graph.facebook.com/'.$user->fb_id.'/picture?width=60&height=60&r">'.HTML::link_to_action('users@profil', $user->name, array($user->id)).'</h4></br>';
		}
	}
	echo '</div>';
	echo '<div class="span6">';	
	foreach($users as $key => $user){ 
		if($key >= $players_num/2){
			echo '<h4><img class="img-circle" src="http://graph.facebook.com/'.$user->fb_id.'/picture?width=60&height=60&r">'.HTML::link_to_action('users@profil', $user->name, array($user->id)).'</h4></br>';
		}
	}
	echo '</div>';
	?>
	</div>
@endsection