@extends('layouts.default')

@section('title','スタッフ別勤怠一覧画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>{{ $attendance->user->name }}さんの勤怠</h2>
    <div class="list__header">
        <a href="?month={{ \Carbon\Carbon::parse($targetMonth)->subMonth()->format('Y-m') }}" class="list__prev">← 前月</a>
        <span class="list__month">{{ \Carbon\Carbon::parse($targetMonth)->format('Y年m月') }}</span>
        <a href="?month={{ \Carbon\Carbon::parse($targetMonth)->addMonth()->format('Y-m') }}" class="list__next">翌月 →</a>
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
            @foreach($dates as $date)
            @php
            $attendance = $attendances->get($date->format('Y-m-d'));
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($date)->formatLocalized('%m/%d（%a）') }}</td>
                <td>{{ optional($attendance)->start_time ?? '-' }}</td>
                <td>{{ optional($attendance)->end_time ?? '-' }}</td>
                <td>{{ optional($attendance)->rest_sum ?? '-' }}</td>
                <td>{{ optional($attendance)->work_time ?? '-' }}</td>
                <td>
                    @if($attendance)
                    <a href="{{ route('attendance.detail', $attendance->id) }}">詳細</a>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection