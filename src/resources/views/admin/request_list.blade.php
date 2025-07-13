@extends('layouts.default')

@section('title','申請一覧ページ（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
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
            <tr>
                <td>承認待ち</td>
                <td>西伶奈</td>
                <td>2023/06/01</td>
                <td>遅延のため</td>
                <td>2023/06/02</td>
                <td><a href="#">詳細</a></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection