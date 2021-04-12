@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Proceso de verificación') }}</div>

                <div class="card-body">

                    <div class="alert alert-success" role="alert">
                        <h2>Estas en proceso de verificación, esto puede tardar varios días</h2>
                        <button class="btn btn-primary">

                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                         {{ __('Logout') }}
                        </a>
                    </button>
                   
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                         @csrf
                     </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection