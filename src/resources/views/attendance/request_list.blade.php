@extends('layouts.default')

@section('title','申請一覧ページ（一般ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="center">
    <h2 class="list__title"><span>|</span>申請一覧</h2>
    <div class="list__tabs">
        <a href="?tab=pending" class="list__tab {{ $tab === 'pending' ? 'list__tab--active' : '' }}">承認待ち</a>
        <a href="?tab=approved" class="list__tab {{ $tab === 'approved' ? 'list__tab--active' : '' }}">承認済み</a>
    </div>
    <table class="list__table">
        <tr>
            <th>状態</th>
            <th>対象日</th>
            <th>理由</th>
            <th>申請日</th>
            <th>詳細</th>
        </tr>

        @foreach($requests as $request)
        <tr>
            <td>{{ $editRequest->status }}</td>
            <td>{{ $editRequest->attendance->date }}</td>
            <td>{{ $editRequest->reason }}</td>
            <td>{{ $editRequest->created_at->format('Y/m/d') }}</td>
            <td><a href="{{ route('attendance.detail', $request->attendance->id) }}">詳細</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection