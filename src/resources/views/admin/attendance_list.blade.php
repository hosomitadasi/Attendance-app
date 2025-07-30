@extends('layouts.default')

@section('title','勤怠一覧画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css') }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>{{ $targetDate }} の勤怠</h2>

    @php
    $current = \Carbon\Carbon::parse($targetDate);
    $prev = $current->copy()->subDay()->toDateString();
    $next = $current->copy()->addDay()->toDateString();
    @endphp

    <div class="list__header">
        <a href="{{ route('admin.attendance_list', ['date' => $prev]) }}" class="list__prev">←前日</a>
        <span class="list__month">{{ $current->format('Y年m月d日') }}</span>
        <a href="{{ route('admin.attendance_list', ['date' => $next]) }}" class="list__next">翌日→</a>
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
            @forelse($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name ?? '-' }}</td>
                <td>{{ $attendance->start_time ?? '-' }}</td>
                <td>{{ $attendance->end_time ?? '-' }}</td>
                <td>{{ $attendance->rest_sum }}</td>
                <td>{{ $attendance->work_time }}</td>
                <td><a href="{{ route('admin.attendance_detail', $attendance->id) }}">詳細</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="6">データがありません</td>
            </tr>
            @endforelse
        </table>
    </div>
</div>
@endsection