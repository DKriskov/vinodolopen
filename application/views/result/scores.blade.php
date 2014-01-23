@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Svi rezultati</h1>
		
		<div class="separator"></div>
	</div>

	<?php $errors = Session::get('errors');	

	if( $errors ){
	   	foreach ($errors as $error){
		    echo $error.'<br>';
		}
	}

	$i=0;
	$mjesec=array(
			1=>'sijecanj',
			2=>'veljaca',
			3=>'ozujak',
			4=>'travanj',
			5=>'svibanj',
			6=>'lipanj',
			7=>'srpanj',
			8=>'kolovoz',
			9=>'rujan',
			10=>'listopad',
			11=>'studeni',
			12=>'prosinac'
		);
		foreach ($dates as $date){ ?>
			
			<div class="buttonwrap">				
				<button class="btn btn-block btn-warning buttonrezultati <?php if($i==0) echo "prvi"; else echo "ostali" ?> " type="button">{{$mjesec[$date->mjesec]}} <span class='godina'>{{$date->godina}}</span><span class='mjesec' style="display:none;">{{$date->mjesec}}</span></button></br>
				
				<div class='scores'></div>
			</div>
			<?php $i++;
			} ?> 		
@endsection