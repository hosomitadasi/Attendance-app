@extends('layouts')

@section('title','スタッフ一覧ページ（管理者）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css')  }}">
@endsection

@section('content')
@include('components.header')
<div class="container">
    <h2>スタッフ一覧</h2>

    <div class="list-table">
        <table>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>月次詳細</th>
            </tr>
            @foreach()
            <tr>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td></td>
                <td><a href="{{ route('admin.attendance.detail', $attendance->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection