@extends('theme.master')
@section('title', "Guest User")
@section('content')

@include('admin.message')
<!-- course detail header start -->

<section id="gift-block" class="gift-main-block btm-60">
  <!-- <div class="container-xl">
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-6">
          <h1 class="student-heading text-center top-30 btm-60">{{ __('Guest User Register') }}</h1>

          <form id="demo-form2" method="post" action="{{ route('guest.checkout') }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fname">{{ __('First Name') }}:<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="fname" id="{{ __('title')}}" placeholder="{{ __('Enter First Name') }}" value="{{ old('fname') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="lname">{{ __('LastName') }}:<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="lname" id="{{ __('title')}}" placeholder="{{ __('EnterLastName') }}" value="{{ old('lname') }}" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="email">{{ __('Email') }}:<sup class="redstar">*</sup></label>
                  <input type="email" value="" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="title" placeholder="Enter {{ __('Email') }}" value="{{ old('email') }}" required>
                </div>
              </div>

            </div>

            <br>
            <div class="box-footer">
              <button type="submit" class="btn btn-lg btn-primary">{{ __('Guest Checkout') }}</button>
            </div>
          </form>

        </div>
        <div class="col-lg-6">
          <h1 class="student-heading text-center top-30 btm-60">{{ __('Already registered') }}</h1>
          <form method="POST" action="{{ route('guest.login') }}">
            @csrf

            <div class="form-group">
              <label for="fname">{{ __('Email') }}:<sup class="redstar">*</sup></label>
              <input id="email" type="email" class="form-control" placeholder="{{ __('Enter Your E-Mail')}}" name="email" required autofocus>

              @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>

            <div class="form-group">
              <label for="fname">{{ __('Password') }}:<sup class="redstar">*</sup></label>
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Your Password')}}" name="password" required>

              @if ($errors->has('password'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>

            <br>


            <div class="box-footer">
              <button type="submit" class="btn btn-lg btn-primary">
                {{ __('Login') }}
              </button>

            </div>

          </form>
        </div>
      </div>
    </div>
  </div> -->
  @if(Session::has('message'))
    <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      <p>{{ Session::get('message') }}</p>
    </div>
  @endif
  <div class="Register-section">
    <div class="d-flex flex-wrap py-md-5 py-1 mx-md-0 mx-2 justify-content-center">
      <div class="col-md-5 col-12 my-md-5 my-2 " id="G-u-Register">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs justify-content-center border-0" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#menu1">Guest User Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Already registered</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div id="menu1" class="container tab-pane active">
            <div class="w-100 d-flex justify-content-center">
              <div class="col-lg-12">
                <h1 class="student-heading text-center top-30 btm-60">{{ __('Guest User Register') }}</h1>

                <form id="demo-form2" method="post" action="{{ route('guest.checkout') }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="fname">{{ __('First Name') }}:<sup class="redstar">*</sup></label>
                        <input type="text" class="form-control" name="fname" id="{{ __('title')}}" placeholder="{{ __('Enter First Name') }}" value="{{ old('fname') }}" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lname">{{ __('LastName') }}:<sup class="redstar">*</sup></label>
                        <input type="text" class="form-control" name="lname" id="{{ __('title')}}" placeholder="{{ __('EnterLastName') }}" value="{{ old('lname') }}" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="email">{{ __('Email') }}:<sup class="redstar">*</sup></label>
                        <input type="email" value="" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="title" placeholder="Enter {{ __('Email') }}" value="{{ old('email') }}" required>
                      </div>
                    </div>

                  </div>

                  <br>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary">{{ __('Guest Checkout') }}</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
          <div id="menu2" class="container tab-pane fade">
            <div class="w-100 d-flex justify-content-center">
              <div class="col-lg-12">
                <h1 class="student-heading text-center top-30 btm-60">{{ __('Already registered') }}</h1>
                <form method="POST" action="{{ route('guest.login') }}">
                  @csrf

                  <div class="form-group">
                    <label for="fname">{{ __('Email') }}:<sup class="redstar">*</sup></label>
                    <input id="email" type="email" class="form-control" placeholder="{{ __('Enter Your E-Mail')}}" name="email" required autofocus>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="fname">{{ __('Password') }}:<sup class="redstar">*</sup></label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Your Password')}}" name="password" required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>

                  <br>


                  <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary">
                      {{ __('Login') }}
                    </button>

                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- <script>
  // Get the tab elements
  const homeTab = document.querySelector('a[href="#menu1"]');
  const menu1Tab = document.querySelector('a[href="#menu2"]');
  const registerSection = document.querySelector('.Register-section');

  function handleTabClick(event) {
    registerSection.classList.remove('menu1-active');
    if (event.target === menu1Tab) {
      registerSection.classList.add('menu1-active');
    }
  }
  homeTab.addEventListener('click', handleTabClick);
  menu1Tab.addEventListener('click', handleTabClick);
</script> -->

<!-- course detail end -->
@endsection