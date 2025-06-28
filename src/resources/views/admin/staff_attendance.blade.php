@extends('layouts')

@section('title','スタッフ別勤怠一覧ページ（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="container">
    <h2>ユーザーの名前</h2>
    <div class="month-switcher">
        <a href="?month={{ $prevMonth }}">← 前月</a>
        <span>{{ $currentMonth->format('Y/m') }}</span>
        <a href="?month={{ $nextMonth }}">翌月 →</a>
    </div>

    <div class="list-table">
        <table>
            <tr>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td></td>
                <td><a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection