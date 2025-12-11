@extends('layouts.master')

@section('title', $sectionTitle ?? 'Main View')

@section('content')

<x-app-layout>
    @if ($errors->has('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-sm">
            {{ $errors->first('error') }}
        </div>
    @endif
    @if(session('status'))
        @php
            $status = session('status');
            $color = match ($status['type']) {
                'success'  => 'bg-green-100 text-green-800 border-green-300',
                'deleted'  => 'bg-red-100 text-red-800 border-red-300',
                'restored' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                default    => 'bg-gray-100 text-gray-800 border-gray-300',
            };
        @endphp
    
        <div class="p-4 mb-4 border rounded-lg {{ $color }}">
            {{ $status['message'] }}
                <button onclick="this.parentElement.style.display='none'" class="float-right font-bold"><i class="fa fa-times"></i></button>
        </div>
    @endif
    {{ $slot }}
</x-app-layout>

@endsection

@section('css')
@endsection

@section('js')
@endsection