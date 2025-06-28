@extends('layouts')

@section('title','申請一覧ページ（ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="container">
    <h2>申請一覧</h2>

    <div class="tab-switcher">
        <a href="?status=pending" class="{{ $status == 'pending' ? 'active' : '' }}">承認待ち</a>
        <a href="?status=approved" class="{{ $status == 'approved' ? 'active' : '' }}">承認済み</a>
    </div>

    <table class="list-table">
        <thead>
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
            <tr>
                <td>{{ $request->status == 'pending' ? '承認待ち' : '承認済み' }}</td>
                <td>{{ $request->user->name }}</td>
                <td>{{ $request->attendance->date->format('Y/m/d') }}</td>
                <td>{{ $request->reason }}</td>
                <td>{{ $request->created_at->format('Y/m/d') }}</td>
                <td><a href="{{ route('request.detail', $request->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection