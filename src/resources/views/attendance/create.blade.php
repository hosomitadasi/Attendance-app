@extends('layouts.default')

@section('title', '勤怠登録')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/attendance.css') }}">
@endsection

@section('content')
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
        @if ($status === 'before_work')
        <form action="{{ route('attendance.start') }}" method="POST">
            @csrf
            <button class="btn">出勤</button>
        </form>
        @elseif ($status === 'working')
        <div class="btn-group">
            <form action="{{ route('attendance.end') }}" method="POST">
                @csrf
                <button class="btn">退勤</button>
            </form>
            <form action="{{ route('attendance.break_start') }}" method="POST">
                @csrf
                <button class="btn btn--white">休憩入</button>
            </form>
        </div>
        @elseif ($status === 'resting')
        <form action="{{ route('attendance.break_end') }}" method="POST">
            @csrf
            <button class="btn btn--white">休憩戻</button>
        </form>
        @elseif ($status === 'after_work')
        <p class="thanks-message">お疲れ様でした。</p>
        @endif
    </div>
</div>
@endsection