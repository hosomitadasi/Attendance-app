@extends('layouts.default')

@section('title', '勤怠詳細画面（一般ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css') }}">
@endsection

@section('content')
@include('components.header')
<div class="center">
    <h2 class="list__title"><span>|</span>勤怠詳細</h2>
    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
        <div class="list__table">
            <table>
                <tr>
                    <th>名前</th>
                    <th>日付</th>
                    <th>出勤・退勤</th>
                    <th>休憩</th>
                    <th>備考</th>
                </tr>
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y年m月d日') }}</td>
                    <td>
                        <input type="time" name="start_time" value="{{ $attendance->start_time }}" class="request__input-time"> ～
                        <input type="time" name="end_time" value="{{ $attendance->end_time }}" class="request__input-time">
                    </td>
                    <td>
                        @foreach($attendance->rests as $index => $rest)
                        <div class="request__rest">
                            <input type="time" name="rest[{{ $index }}][start_time]" value="{{ $rest->start_time }}" class="request__input-time"> ～
                            <input type="time" name="rest[{{ $index }}][end_time]" value="{{ $rest->end_time }}" class="request__input-time">
                        </div>
                        @endforeach
                    </td>
                    <td>
                        <textarea name="note" class="request__textarea">{{ $attendance->note }}</textarea>
                    </td>
                </tr>
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