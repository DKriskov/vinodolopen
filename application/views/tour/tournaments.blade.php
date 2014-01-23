@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Izaberi turnir</h1>
		
		<div class="separator"></div>
	</div>

	<?php 
	$errors = Session::get('errors');	?>

	@if ( $errors )
	   	@foreach ($errors as $error)
		   <p style="color:red">{{ $error }}</p>
		@endforeach
	@endif
	
	@if ( $turniri )
	   	@foreach ($turniri as $turnir)
	   		<div class='turniri'>
		    	<h4>{{HTML::link_to_action('tour@single_draw', 'Turnir: '.$turnir->start_date, array($turnir->id))}}
		    	</h4>
		    <?php if(!is_null($turnir->winner)){ ?>
		    	<h4>{{'<span class="pobjednik">Pobjednik: '.$turnir->winner.'</span>'}}</h4>
		   	<?php } ?>
		    </div>
		@endforeach
	@else
		<div class="turniri"><h4>Nema turnira za prikaz</h4></div>
	@endif	
@endsection