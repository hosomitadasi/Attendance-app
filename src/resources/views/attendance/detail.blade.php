@extends('layouts.default')

@section('title', '勤怠詳細画面（一般ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css') }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>勤怠詳細</h2>

    {{-- エラーメッセージ一覧 --}}
    @if ($errors->any())
    <div class="request__error-messages">
        <ul>
            @foreach ($errors->all() as $error)
            <li class="request__error">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
                        <input type="time" name="new_start_time" value="{{ old('new_start_time', $attendance->start_time) }}" class="request__input-time"> ～
                        <input type="time" name="new_end_time" value="{{ old('new_end_time', $attendance->end_time) }}" class="request__input-time">
                        {{-- 個別エラー表示（オプション） --}}
                        @error('new_start_time')<p class="request__error">{{ $message }}</p>@enderror
                        @error('new_end_time')<p class="request__error">{{ $message }}</p>@enderror
                    </td>
                    <td>
                        @foreach($attendance->rests as $index => $rest)
                        <div class="request__rest">
                            <input type="time" name="new_rests[{{ $index }}][start_time]" value="{{ old("new_rests.$index.start_time", $rest->start_time) }}" class="request__input-time"> ～
                            <input type="time" name="new_rests[{{ $index }}][end_time]" value="{{ old("new_rests.$index.end_time", $rest->end_time) }}" class="request__input-time">
                            {{-- 個別エラー表示 --}}
                            @error("new_rests.$index.start_time")<p class="request__error">{{ $message }}</p>@enderror
                            @error("new_rests.$index.end_time")<p class="request__error">{{ $message }}</p>@enderror
                        </div>
                        @endforeach
                    </td>
                    <td>
                        <textarea name="note" class="request__textarea">{{ old('note', $attendance->note) }}</textarea>
                        @error('note')<p class="request__error">{{ $message }}</p>@enderror
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