@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
  {{ 'ICBA' }}
  @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
  @hasSection('content_header_title')
    <h1 class="text-muted">
      @yield('content_header_title')

      @hasSection('content_header_subtitle')
        <small class="text-dark">
          <i class="fa fa-xs fa-angle-right text-muted"></i>
          @yield('content_header_subtitle')
        </small>
      @endif
    </h1>
  @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
  @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
  <div class="float-right">
    Version: {{ config('app.version', '1.0.2') }}
  </div>

  <strong>
    <a href="{{ config('app.company_url', 'https://www.icba-sucre.edu.bo') }}">
      {{ config('app.company_name', 'Instituto Cultural Boliviano Alemán') }}
    </a>
  </strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 1000
    })
  </script>
@endif
@endpush

{{-- Add common CSS customizations --}}

@push('css')
  <style type="text/css">

  </style>
@endpush
