@extends('layouts.default')

@section('title','スタッフ別勤怠一覧画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>{{ $attendance->user->name }}さんの勤怠</h2>
    <div class="list__header">
        <a href="#" class="list__prev">←前月</a>
        <span class="list__month"></span>
        <a href="#" class="list__next">翌月→</a>
    </div>
    <div class="list__table">
        <table>
            <tr>
                <th>名前</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            @foreach($attendances as attendance)
            <tr>
                <td>{{ $attendance->use->name }}</td>
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