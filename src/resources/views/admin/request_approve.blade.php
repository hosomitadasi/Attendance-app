@extends('layouts.default')

@section('title','修正申請承認画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css') }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>勤怠詳細</h2>
    <form action="{{ route('admin.approve', $attendance->id) }}" method="POST">
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
                @foreach($editRequests as $editRequest)
                <tr>
                    <td>{{ $editRequest->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($editRequest->attendance->date)->format('Y年 m月d日') }}</td>
                    <td>{{ $editRequest->new_start_time }} ～ {{ $editRequest->new_end_time }}</td>
                    <td>
                        @foreach($editRequest->attendance->rests as $rest)
                        {{ $rest->start_time }} ～ {{ $rest->end_time }}<br>
                        @endforeach
                    </td>
                    <td>{{ $editRequest->note }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <button type="submit" class="btn btn--small">承認</button>
    </form>
</div>
@endsection