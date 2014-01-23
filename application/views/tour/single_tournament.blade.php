@layout('tour')
@include('common.login')

@section('maincontent')
	<div class="article-header">
		<h1 class="title">Turnir <?php echo $date; ?></h1>
		
		<div class="separator"></div>
	</div>
	<div class="row-fluid stages">
		<div class="span3 outer">
	<?php
		if($seeded_pairs){
			echo '<div class="stage">1/'.count($seeded_pairs).' finala</div>';
		}
		foreach($seeded_pairs as $a_stage){
			echo '<div class="pairs"><p>'.$a_stage->player1->name.'<span class="tour_rez">';
			if($a_stage->p1_set1 != -1){
				echo $a_stage->p1_set1.' ';
			}
			if($a_stage->p1_set2 != -1){
				echo $a_stage->p1_set2.' ';
			}
			if($a_stage->p1_set3 != -1){
				echo $a_stage->p1_set3;
			}
			echo '</span></p>';
			if(!empty($a_stage->player2)){
				echo '<p>'.$a_stage->player2->name.'<span class="tour_rez">';
				if($a_stage->p1_set1 != -1){
					echo $a_stage->p2_set1.' ';
				}
				if($a_stage->p2_set2 != -1){
					echo $a_stage->p2_set2.' ';
				}
				if($a_stage->p2_set3 != -1){
					echo $a_stage->p2_set3;
				}
				echo '</span></p></div>';
			}else{
				echo '<p>SLOBODAN</p></div>';
			}	
		}
	echo '</div>';

	if(!empty($b_stages)){
		echo '<div class="span3 outer b_stage">';
		if($seeded_pairs){
			echo '<div class="stage">1/'.count($b_stages).' finala</div>';
		}
		foreach($b_stages as $b_stage){
			if($b_stage->p1_id != 0){
				echo '<div class="pairs"><p>'.$b_stage->player1->name.'<span class="tour_rez">';
			}
			if($b_stage->p1_set1 != -1){
				echo $b_stage->p1_set1.' ';
			}
			if($b_stage->p1_set2 != -1){
				echo $b_stage->p1_set2.' ';
			}
			if($b_stage->p1_set3 != -1){
				echo $b_stage->p1_set3;
			}
			if($b_stage->p1_id == 0){
				echo '<div class="pairs"><p class="unknown"></p>';
			}
			
			if(!empty($b_stage->player2)){
				if($b_stage->p2_id != 0){
					echo '<p>'.$b_stage->player2->name.'<span class="tour_rez">';
				}
				if($b_stage->p1_set1 != -1){
					echo $b_stage->p2_set1.' ';
				}
				if($b_stage->p2_set2 != -1){
					echo $b_stage->p2_set2.' ';
				}
				if($b_stage->p2_set3 != -1){
					echo $b_stage->p2_set3;
				}
				echo '</span></p></div>';
			}else{
				echo '<p class="unknown"></p></div>';
			}	
		}
		echo '</div>';
	}
	if(!empty($c_stages)){
		echo '<div class="span3 outer c_stage">';
		if(count($seeded_pairs)==8){
			echo '<div class="stage">1/2 finala</div>';
		}
		if(count($seeded_pairs)==4){
			echo '<div class="stage">finale</div>';
		}
		foreach($c_stages as $c_stage){
			if($c_stage->p1_id != 0){
				echo '<div class="pairs"><p>'.$c_stage->player1->name.'<span class="tour_rez">';
			}
			if($c_stage->p1_set1 != -1){
				echo $c_stage->p1_set1.' ';
			}
			if($c_stage->p1_set2 != -1){
				echo $c_stage->p1_set2.' ';
			}
			if($c_stage->p1_set3 != -1){
				echo $c_stage->p1_set3;
			}
			if($c_stage->p1_id == 0){
				echo '<div class="pairs"><p class="unknown"></p>';
			}
			
			if(!empty($c_stage->player2)){
				if($c_stage->p2_id != 0){
					echo '<p>'.$c_stage->player2->name.'<span class="tour_rez">';
				}
				if($c_stage->p1_set1 != -1){
					echo $c_stage->p2_set1.' ';
				}
				if($c_stage->p2_set2 != -1){
					echo $c_stage->p2_set2.' ';
				}
				if($c_stage->p2_set3 != -1){
					echo $c_stage->p2_set3;
				}
				echo '</span></p></div>';
			}else{
				echo '<p class="unknown"></p></div>';
			}	
		}
		echo '</div>';
	} ?>
		<?php if(!empty($d_stages)){
		if(count($seeded_pairs)==8){
			echo '<div class="span3 outer final">';
			echo '<div class="stage_winner stage_winner_d">finale</div>';
			foreach($d_stages as $d_stage){
				if($d_stage->p1_id != 0){
					echo '<div class="pairs"><p>'.$d_stage->player1->name.'<span class="tour_rez">';
				}
				if($d_stage->p1_set1 != -1){
					echo $d_stage->p1_set1.' ';
				}
				if($d_stage->p1_set2 != -1){
					echo $d_stage->p1_set2.' ';
				}
				if($d_stage->p1_set3 != -1){
					echo $d_stage->p1_set3;
				}
				if($d_stage->p1_id == 0){
					echo '<div class="pairs"><p class="unknown"></p>';
				}
				
				if(!empty($d_stage->player2)){
					if($d_stage->p2_id != 0){
						echo '<p>'.$d_stage->player2->name.'<span class="tour_rez">';
					}
					if($d_stage->p1_set1 != -1){
						echo $d_stage->p2_set1.' ';
					}
					if($d_stage->p2_set2 != -1){
						echo $d_stage->p2_set2.' ';
					}
					if($d_stage->p2_set3 != -1){
						echo $d_stage->p2_set3;
					}
					echo '</span></p></div>';
				}else{
					echo '<p class="unknown"></p></div>';
				}	
			}
		} /*else {
			echo '<div class="span6 outer">';
			echo '<div class="stage_winner stage_winner_d">Pobjednik</div>';
			foreach($d_stages as $d_stage){
				if($d_stage->p1_id != 0){
					echo '<div class="pairs">';
					echo '<p class="winner">'.$d_stage->player1->name.'</p>';
				}
			}
			echo '</div>';
		}*/
		echo '</div>';
	} 
	/*if(!empty($e_stages)){
		echo '<div class="span4 pairs outer">';
		echo '<div class="stage_winner top_offset"><span>Pobjednik</span></div>';
		foreach($e_stages as $e_stage){
			if($e_stage->p1_id != 0){
				echo '<p class="winner">'.$e_stage->player1->name.'</p>';
			}
		}
		echo '</div>';
	}*/?>
	
	</div>	
	
@endsection