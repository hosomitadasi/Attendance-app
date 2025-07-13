@extends('layouts.default')

@section('title','スタッフ一覧画面（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="center">
    <h2 class="list__title"><span>|</span>スタッフ一覧</h2>

    <div class="list__table">
        <table>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>月次勤怠</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{}}</td>
                <td>{{}}</td>
                <td><a href="{{ route('admin.attendance.detail', $attendance->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection