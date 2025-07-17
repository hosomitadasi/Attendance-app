@extends('layouts.default')

@section('title','勤怠一覧画面（一般ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="center">
    <h2 class="list__title"><span>|</span>勤怠一覧</h2>
    <div class="list__header">
        <a href="?month={{ \Carbon\Carbon::parse($targetMonth)->subMonth()->format('Y-m') }}" class="list__prev">←前月</a>
        <span class="list__month">{{ \Carbon\Carbon::parse($targetMonth)->format('Y年m月') }}</span>
        <a href="?month={{ \Carbon\Carbon::parse($targetMonth)->addMonth()->format('Y-m') }}" class="list__next">翌月→</a>
    </div>
    <div class="list__table">
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
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('m/d（D）') }}</td>
                <td>{{ $attendance->start_time }}</td>
                <td>{{ $attendance->end_time }}</td>
                <td>{{ $attendance->rest_sum }}</td>
                <td>{{ $attendance->work_time }}</td>
                <td><a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection