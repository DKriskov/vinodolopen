<?php if (Auth::guest()) {	?>
	@section('login')
	<?php $login_errors = Session::get('login_errors');	?>

	@if ( $login_errors )
	   	@foreach ($login_errors as $error)
		   <p style="color:red">{{ $error }}</p>
		@endforeach
	@endif

	<div class="sidebar-widget sidebar-block sidebar-color">
		<div class="sidebar-header">
			<h4>Prijava</h4>
		</div>
		<div class="sidebar-content login-widget">
			{{ Form::open('users/login','POST') }}
				<div class="input-prepend">
					<span class="add-on "><i class="icon-user"></i></span>
					<input name="username" type="email" class="input-large" placeholder="E-mail">
				</div>
				<div class="input-prepend">
					<span class="add-on "><i class="icon-lock"></i></span>
					<input name="password" type="password" class="input-large" placeholder="Password">
				</div>
				<label class="checkbox">
					<input name="remember" type="checkbox">
					Remember me
				</label>
				<div class="controls">
					<button class="btn signin" type="submit">Prijava</button>
					<button data-href="{{ URL::to('users/new') }}" class="btn signup">Registracija</button>
				</div>
			</form>
		</div>
	</div>
	@endsection

<?php } else { $user = Auth::user(); ?>
	@section('login')
	<div class="sidebar-widget sidebar-block sidebar-color">
		<div class="sidebar-header">		
			<h4>Odlican return, {{ $user->name }}!</h4>
		</div>
		<div class="sidebar-content login-widget">
			<ul>
				<li>{{ HTML::link_to_action('results@new','Novi rezultat'); }}</li>
				<li>{{ HTML::link_to_action('results@edit','Ispravak rezultata'); }}</li>
				<li>{{ HTML::link_to_action('users@logout','Odjava'); }}</li>
			</ul>
		</div>
	</div>
	@endsection
<?php } ?>