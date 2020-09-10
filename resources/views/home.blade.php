@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
    Seu código
@endsection

@section('footer')
<form>
    <div class="custom-control custom-switch">
      <input type="checkbox" class="custom-control-input" id="switch1">
      <label class="custom-control-label" for="switch1"></label>
    </div>
  </form>
@endsection
