@extends('layouts.default')

@section('title', '勤怠詳細画面（一般ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css') }}">
@endsection

@section('content')
@include('components.header')
<div class="center">
    <form>
        <h2 class="list__title"><span>|</span>勤怠詳細</h2>
        <table>
            <tr>
                <th>名前</th>
                <th>日付</th>
                <th>出勤・退勤</th>
                <th>休憩</th>
                <th>休憩２</th>
                <th>備考</th>
            </tr>
            @foreach()
            <tr>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td>{{}}</td>
                <td></td>
            </tr>
            @endforeach
        </table>
        <button></button>
    </form>
</div>
@endsection