@layout('master')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Head to head</h1>
		
		<div class="separator"></div>
	</div>
	{{ Form::open('results/Head2head', 'GET') }}
	<table class='headtohead'>
      	<tr>
        	<td>
          		<select name="player1" id="player1">
          			<option value='0'>izaberi igraca 1</option>
           			@foreach ($users as $user)
      				  <?php  
          				$selected_first = '';
          				if(isset($_GET['player1'])) {                   
            					if($_GET['player1'] == $user->id) {
              				$selected_first = 'selected="selected"';
            					}
          				}
     			 	    ?>
              		<option {{ $selected_first }} value='{{ $user->id }}'>{{ $user->name }}</option>
            		@endforeach
          		</select>
          	</td>
          	<td id='versus'>Vs</td>
          	<td>
          		<select name="player2" id="player2">
	          		<option value='0'>izaberi igraca 2</option>
	            	@foreach ($users as $user)
	              	<?php  
	                	$selected_second = '';
	                	if(isset($_GET['player2'])) {                   
	                	  if($_GET['player2'] == $user->id) {
	                    	$selected_second = 'selected="selected"';
	                  		}
	                	}
	              	?>
	              	<option {{ $selected_second }} value='{{ $user->id }}'>{{ $user->name }}</option>
            		@endforeach
         	 	</select>
      		</td>
        </tr>
        <tr>
         	<td class='center' colspan='3'>{{Form::submit('Pretraži', array('class' => 'btn btn-warning', 'id' => 'submit'))}}</td>
       	</tr>
    </table>
    {{ Form::close() }}

@if(isset($player2w))
  
    <div class='tablewrapper'>
      <table class="upisrezultata glava">
        <tr>
          @foreach ($users as $user)

            <?php if($_GET['player1'] == $user->id){ ?>
            <td class="ime">{{ $user->name }}</td>
            <td>
              <img class="img-circle" src="http://graph.facebook.com/{{ $user->fb_id }}/picture?width=75&height=75&r">
            </td>
            <td class="score">{{ $player1w }}</td>
            <?php } ?>

          @endforeach
          <td> - </td>
          @foreach($users as $user)

            <?php if($_GET['player2'] == $user->id){ ?>
            <td class="score">{{ $player2w }}</td>
            <td>
              <img class="img-circle" src="http://graph.facebook.com/{{ $user->fb_id }}/picture?width=75&height=75&r">
            </td>
            <td class="ime">{{ $user->name }}</td>
            <?php } ?>

          @endforeach
        </tr>
      </table>
    </div>
  <p class='draw'>Nerjeseno: <span>{{$nerj}}</span></p></br>
  <?php $i=0; ?>
  @foreach ($rezultati as $rezultat)
    @if(($i==0) || ($i==1))
      <button class="btn btn-block btn-warning <?php if($i==0) echo "zadnji"; if ($i==1) echo "stariji" ?> " type="button"><?php if($i==0) echo 'Zadnji meč';  if ($i==1) echo 'Stariji'; ?></button>
    @endif
      <div class='row-fluid head2head <?php if($i != 0) echo "older" ?>'>
        <div class='span7'>
          <table class="upisrezultata"> 
            <tr>
              <td>{{ $rezultat->user->name }}</td>
              <td class="set">{{ $rezultat->u_final }}</td>
              @if ( $rezultat->u1 != -1 )
                  <td class="game">{{ $rezultat->u1 }}</td>
              @endif
              @if ( $rezultat->u2 != -1 )
                  <td class="game">{{ $rezultat->u2 }}</td>
              @endif
              @if ( $rezultat->u3 != -1 )
                  <td class="game">{{ $rezultat->u3 }}</td>
              @endif
              @if ( $rezultat->u4 != -1 )
                  <td class="game">{{ $rezultat->u4 }}</td>
              @endif
              @if ( $rezultat->u5 != -1 )
                  <td class="game">{{ $rezultat->u5 }}</td>
              @endif
            </tr>
            <tr>
              <td>{{ $rezultat->suparnik->name }}</td>
              <td class="set">{{ $rezultat->s_final }}</td>           
              @if ( $rezultat->s1 != -1 )
                  <td class="game">{{ $rezultat->s1 }}</td>
              @endif
              @if ( $rezultat->s2 != -1 )
                  <td class="game">{{ $rezultat->s2 }}</td>
              @endif
              @if ( $rezultat->s3 != -1 )
                  <td class="game">{{ $rezultat->s3 }}</td>
              @endif
              @if ( $rezultat->s4 != -1 )
                  <td class="game">{{ $rezultat->s4 }}</td>
              @endif
              @if ( $rezultat->s5 != -1 )
                  <td class="game">{{ $rezultat->s5 }}</td>
              @endif
            </tr>
          </table>
        </div>
        <div class='span5'>
          <table class="upisrezultata">
            <tr>
              <td>Teren:</td>
              <td>{{ $rezultat->teren->naziv }}</td>
            </tr>
            <tr>
              <td>Podloga:</td>
              <td>{{ $rezultat->podloga->naziv }}</td>
            </tr>
            <tr>
              <td>Datum:</td>
              <td>{{ $rezultat->datum }}</td>
            </tr> 
          </table>
        </div>
      </div>    
    <?php $i++; ?>
  @endforeach

@endif

@if(isset($no_scores))
  <div class='tablewrapper'>
      <table class="upisrezultata">
        <tr>
          @foreach ($users as $user)

            <?php if($_GET['player1'] == $user->id){ ?>
            <td class="ime">{{ $user->name }}</td>
            <td>
              <img class="img-circle" src="http://graph.facebook.com/{{ $user->fb_id }}/picture?width=75&height=75&r">
            </td>
            <td class="score">{{ $no_scores }}</td>
            <?php } ?>

          @endforeach
          <td> - </td>
          @foreach($users as $user)

            <?php if($_GET['player2'] == $user->id){ ?>
            <td class="score">{{ $no_scores }}</td>
            <td>
              <img class="img-circle" src="http://graph.facebook.com/{{ $user->fb_id }}/picture?width=75&height=75&r">
            </td>
            <td class="ime">{{ $user->name }}</td>
            <?php } ?>

          @endforeach
        </tr>
      </table>
    </div>
@endif

@endsection