@layout('master')
@include('common.login')

@section('maincontent')
    <?php $validation_errors = Session::get('validation_errors');   ?>

        @if ( $validation_errors )
            @foreach ($validation_errors as $error)
                {{ $error }} <br>
            @endforeach
        @endif
        
    <iframe 
        src="https://www.facebook.com/plugins/registration?
                 client_id=129280210602890&
                 fb_only=true&
                 redirect_uri={{ URL::to('users/create'); }}&
                 fields=name,email,password"
        scrolling="auto"
        frameborder="no"
        style="border:none"
        allowTransparency="true"
        width="500"
        height="330">
    </iframe>
@endsection
