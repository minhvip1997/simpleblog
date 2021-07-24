<nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="https://www.flowkl.com">Flowkl</a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li>
            <a href="{{ url('/') }}">{{ __('Home') }}</a>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          @if (Auth::guest())
          <li>
            <a href="{{ url('/auth/login') }}">{{ __('Login') }}</a>
          </li>
          <li>
            <a href="{{ url('/auth/register') }}">{{ __('Register') }}</a>
          </li>
          <li  class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#">
               <i class="flag-icon flag-icon-us">{{ __('Language') }}</i>
               </a>
               <div class="dropdown-menu dropdown-menu-right p-0">
                  <a class="navbar-brand" 
                     href="{{route('language.index',['en'])}}">
                  <i>English</i>
                  </a>
                  <a class="navbar-brand"  
                     href="{{route('language.index',['vi'])}}">
                  <i>Tiếng Việt</i>
                  </a>
               </div>
            </li>
          @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              @if (Auth::user()->can_post())
              <li>
                <a href="{{url('post/create')}}">{{ __('Add New Post') }}</a>
              </li>
              <li>
                <a href="{{ url('/user/'.Auth::id().'/posts') }}">{{ __('My Posts') }}</a>
              </li>
              @endif
              <li>
                <a href="{{ url('/user/'.Auth::id()) }}">{{ __('My Profile') }}</a>
              </li>
              <li>
                <a href="logout">{{ __('Logout') }}</a>
              </li>
            </ul>
          </li>
          <li  class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#">
               <i class="flag-icon flag-icon-us">{{ __('Language') }}</i>
               </a>
               <div class="dropdown-menu dropdown-menu-right p-0">
                  <a class="navbar-brand" 
                     href="{{route('language.index',['en'])}}">
                  <i>English</i>
                  </a>
                  <a class="navbar-brand"  
                     href="{{route('language.index',['vi'])}}">
                  <i>Tiếng Việt</i>
                  </a>
               </div>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>