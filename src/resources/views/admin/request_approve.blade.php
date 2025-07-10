@extends('layouts')

@section('title','申請承認ページ')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css')  }}">
@endsection

@section('content')
@include('components.header')
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>勤怠詳細</h2>
    <form>
        <table class="detail-table">
            <tr>
                <th>名前</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>{{ $attendance->date->format('Y年n月j日') }}</td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td>{{ $attendance->start_time }} ～ {{ $attendance->end_time }}</td>
            </tr>

            @foreach ($attendance->rests as $index => $rest)
            <tr>
                <th>休憩{{ $index + 1 }}</th>
                <td>{{ $rest->start_time }} ～ {{ $rest->end_time }}</td>
            </tr>
            @endforeach

            <tr>
                <th>備考</th>
                <td>{{ $attendance->note }}</td>
            </tr>
        </table>
        <div class="detail-button">
            <button>承認</button>
        </div>
    </form>
</div>
@endsection