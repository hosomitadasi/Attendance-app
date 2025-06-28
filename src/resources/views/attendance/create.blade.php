@extends('layouts')

@section('title','勤怠ページ')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/create.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="container">
    <div>
        @if ($status === 'before_work')
        <p>勤務外</p>
        @elseif ($status === 'working')
        <p>出勤中</p>
        @elseif ($status === 'resting')
        <p>休憩中</p>
        @elseif ($status === 'after_work')
        <p>退勤済</p>
        @endif
    </div>

    <h1>日付</h1>
    <h2>現在時刻</h2>

    <div class="text-container">
        @if ($status === 'before_work')
        <form action="{{ route('attendance.start') }}" method="POST">
            @csrf
            <button type="submit">出勤</button>
        </form>

        @elseif ($status === 'working')
        <form action="{{ route('attendance.end') }}" method="POST">
            @csrf
            <button type="submit">退勤</button>
        </form>
        <form action="{{ route('rest.start') }}" method="POST">
            @csrf
            <button type="submit">休憩入</button>
        </form>

        @elseif ($status === 'resting')
        <form action="{{ route('rest.end') }}" method="POST">
            @csrf
            <button type="submit">休憩戻</button>
        </form>

        @elseif ($status === 'after_work')
        <p>お疲れ様でした</p>
        @endif
    </div>

</div>

@endsection