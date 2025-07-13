@extends('layouts.default')

@section('title', '勤怠登録')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/attendance.css') }}">
@endsection

@section('content')
@include('components.header')
<div class="center">
    {{-- 勤務状態ラベル --}}
    <div class="status-label">
        <span class="status status--{{ $status }}">{{ $statusLabel }}</span>
    </div>

    {{-- 日付 --}}
    <p class="page__title">{{ $date }}</p>

    {{-- 時刻 --}}
    <h1 class="clock-time">{{ $time }}</h1>

    {{-- ボタン表示（勤務ステータスによって切り替え） --}}
    <div class="btn-group">
        @if ($status === '未出勤')
        <form action="{{ route('attendance.start') }}" method="POST">
            @csrf
            <button class="btn">出勤</button>
        </form>
        @elseif ($status === '出勤中')
        <form action="{{ route('attendance.end') }}" method="POST">
            @csrf
            <button class="btn">退勤</button>
        </form>
        <form action="{{ route('attendance.break_start') }}" method="POST">
            @csrf
            <button class="btn">休憩入</button>
        </form>
        @elseif ($status === '休憩中')
        <form action="{{ route('attendance.break_end') }}" method="POST">
            @csrf
            <button class="btn">休憩戻</button>
        </form>
        @elseif ($status === '退勤済')
        <p class="thanks-message">お疲れ様でした。</p>
        @endif
    </div>
</div>
@endsection