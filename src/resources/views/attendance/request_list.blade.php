@extends('layouts.default')

@section('title', '申請一覧画面（一般ユーザー）')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/list.css') }}">
@endsection

@section('content')
<div class="center">
    <h2 class="list__title"><span>|</span>申請一覧</h2>

    <div class="tabs">
        <div class="tab-button active" data-target="pending">承認待ち</div>
        <div class="tab-button" data-target="approved">承認済み</div>
    </div>

    <div class="tab-content active" id="pending">
        <table>
            <tr>
                <th>状態</th>
                <th>対象日</th>
                <th>理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
            @foreach($pendingRequests as $editRequest)
            <tr>
                <td>承認待ち</td>
                <td>{{ $editRequest->attendance->date }}</td>
                <td>{{ $editRequest->reason }}</td>
                <td>{{ $editRequest->created_at->format('Y/m/d H:i') }}</td>
                <td><a href="{{ route('admin.request_approve', $editRequest->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="tab-content" id="approved">
        <table>
            <tr>
                <th>状態</th>
                <th>対象日</th>
                <th>理由</th>
                <th>承認日時</th>
                <th>詳細</th>
            </tr>
            @foreach($approvedRequests as $editRequest)
            <tr>
                <td>承認済み</td>
                <td>{{ $editRequest->attendance->date }}</td>
                <td>{{ $editRequest->reason }}</td>
                <td>{{ $editRequest->updated_at->format('Y/m/d H:i') }}</td>
                <td><a href="{{ route('admin.request_approve', $editRequest->id) }}">詳細</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');

                // ボタンのクラス切替
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // コンテンツの表示切替
                tabContents.forEach(content => {
                    if (content.id === targetId) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });
    });
</script>
@endsection