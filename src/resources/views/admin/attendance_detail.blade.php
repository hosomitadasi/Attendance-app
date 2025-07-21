@extends('layouts.default')

@section('title', '勤怠詳細画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css') }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>勤怠詳細</h2>
    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="list__table">
            <table>
                <tr>
                    <th>名前</th>

                    <th>日付</th>

                    <th>出勤・退勤</th>

                    <th>休憩</th>

                    <th>休憩２</th>

                    <th>備考</th>
                </tr>
                @foreach($attendances as $attendance)
                <tr>
                    <td>
                        {{ $attendance->user->name }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($attendance->date)->format('Y年 m月d日') }}
                    </td>

                    <td>
                        @if($attendance->status === 'pending')
                        {{ $attendance->start_time }} ～ {{ $attendance->end_time }}
                        @else
                        <input type="time" name="start_time" value="{{ $attendance->start_time }}" class="request__input-time"> ～
                        <input type="time" name="end_time" value="{{ $attendance->end_time }}" class="request__input-time">
                        @endif
                    </td>

                    <td>
                        @if($attendance->status === 'pending')
                        {{ $attendance->break_start }} ～ {{ $attendance->break_end }}
                        @else
                        <input type="time" name="break_start" value="{{ $attendance->break_start }}" class="request__input-time"> ～
                        <input type="time" name="break_end" value="{{ $attendance->break_end }}" class="request__input-time">
                        @endif
                    </td>

                    <td>
                        @if($attendance->status === 'pending')
                        {{ $attendance->break2_start ?? '-' }} ～ {{ $attendance->break2_end ?? '-' }}
                        @else
                        <input type="time" name="break2_start" value="{{ $attendance->break2_start }}" class="request__input-time"> ～
                        <input type="time" name="break2_end" value="{{ $attendance->break2_end }}" class="request__input-time">
                        @endif
                    </td>

                    <td>
                        @if($attendance->status === 'pending')
                        {{ $attendance->note }}
                        @else
                        <textarea name="note" class="request__textarea">{{ $attendance->note }}</textarea>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        @if($attendance->status === 'pending')
        <p class="request__error">※承認待ちのため修正はできません。</p>
        @else
        <button type="submit" class="btn btn--small">修正</button>
        @endif
    </form>
</div>
@endsection