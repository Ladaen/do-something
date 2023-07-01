@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row d-flex text-center justify-content-center">
    <div class="col-md-5">
      <div class="row">
        <div class="col-md-12 pt-2">
          <img src="https://www.21kschool.com/blog/wp-content/uploads/2022/09/Top-5-Benefits-of-Co-Curricular-Activities-for-Students.png" alt="picture" height="20%" class="img-fluid rounded">
        </div>
            <div class="col-sm-12 pt-2">
          <div class="h1 fw-bold"><span class="text-primary">Do</span> Something</div>
          <div class="h2">let's find something to do</div>
          <div class="p">Welcome to Do Something where the fun begin when you actually do it.</div>
          <div class="p text-break">Do something is an application that suggest you about activities you could do, it also track your saved activities and get you information about activities done around you. Let's start</div>
                                                <a class="btn btn-primary" href="{{ route('login') }}">
                                                    {{ __('Login') }}
                                                </a>
                                            @if (Route::has('register'))
                                                 or 
                                                <a class="btn btn-success" href="{{ route('register') }}">
                                                    {{ __('Register') }}
                                                </a>
                                            @endif
          </div>  
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
