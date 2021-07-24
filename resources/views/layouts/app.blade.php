<!DOCTYPE html>
<html lang="en">

@include('layouts.header')
<body>
@include('layouts.menu')
  <div class="container">
  @if (Session::has('message'))
    <div class="flash alert-info">
      <p class="panel-body">
        {{ __(Session::get('message')) }}
      </p>
    </div>
    @endif
    @if ($errors->any())
    <div class='flash alert-danger'>
      <ul class="panel-body">
        @foreach ( $errors->all() as $error )
        <li>
          {{ __($error) }}
        </li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2>@yield('title')</h2>
            @yield('title-meta')
          </div>
          <div class="panel-body">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <p>Copyright © 2015 | <a href="https://www.flowkl.com">Flowkl</a></p>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/components/metisMenu.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>

</html>