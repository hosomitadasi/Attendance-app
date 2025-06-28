@extends('layouts')

@section('title','勤怠一覧ページ（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="container">
    <h2>{{}}の勤怠</h2>
    <div class="month-switcher">
        <a href="?day={{ $prevDay }}">← 前日</a>
        <span>{{ $currentMonth->format('Y/m') }}</span>
        <a href="?day={{ $nextDay }}">翌日 →</a>
    </div>

    <div class="list-table">
        <table>
            <tr>
                <th>名前</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            @foreach()
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