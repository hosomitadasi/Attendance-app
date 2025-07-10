@extends('layouts')

@section('title','勤怠詳細ページ（ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/request.css')  }}">
@endsection

@section('content')
@include('components.header')
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>勤怠詳細</h2>
    <form>
        <table class="detail-table">
            <tr>
                <th>名前</th>
                <td>データベースからユーザーの名前を取得する</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>実際の日付を表示していく</td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td>出勤ボタンを押した時間 ～ 退勤ボタンを押した時間</td>
            </tr>

            @foreach
            <tr>
                <th>休憩</th>
                <td>休憩入ボタンを押した時間 ～ 休憩戻ボタンを押した時間</td>
            </tr>
            @endforeach

            <tr>
                <th>備考</th>
                <td>備考欄</td>
            </tr>
        </table>
        <div class="detail-button">
            <button>修正</button>
        </div>
    </form>
</div>
@endsection