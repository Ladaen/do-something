@extends('Shared._Layout')

@section('content')
<div class="container">
    <h3 class="mt-4">List Product</h3>
 @foreach($breeds as $breed)
                <div class="col-lg-2 ">
                    <div class="feature-with-icon" data-aos="flip-up" >
                        <h5><strong>{{ucfirst($breed['activity'])}}</strong></h5>
                    </div>
                </div>
            @endforeach
</div>
@endsection