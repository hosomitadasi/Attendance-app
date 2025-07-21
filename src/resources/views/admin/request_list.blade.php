@extends('layouts.default')

@section('title','申請一覧画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>申請一覧</h2>

    <div class="list__tabs">
        <span class="list__tab list__tab--active">承認待ち</span>
        <span class="list__tab">承認済み</span>
    </div>

    <table class="list__table">
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
            @foreach($editRequests as $editRequest)
            <tr>
                <td>承認待ち</td>
                <td>{{ $editRequest->user->name }}</td>
                <td>{{ $editRequest->attendance->date }}</td>
                <td>{{ $editRequest->reason }}</td>
                <td>{{ $editRequest->created_at }}</td>
                <td><a href="{{ route('admin.approve', $editRequest->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection