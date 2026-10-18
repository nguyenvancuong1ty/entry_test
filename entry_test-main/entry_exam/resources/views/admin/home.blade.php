<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/home.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="page-wrapper admin-home-wrapper">
        <div class="page-header">
            <h2 class="title">THK Travel 管理ダッシュボード</h2>
            <p class="subtitle">THK Holdings Vietnam Hanoi Entrance Examination Admin Panel</p>
        </div>

        <div class="dashboard-hero">
            <div class="hero-content">
                <h3 class="hero-title">ようこそ 管理者画面へ 👋</h3>
                <p class="hero-desc">
                    この画面は宿泊予約システムの管理コンソールです。<br>
                    左側のサイドメニューまたは下記クイックリンクから各機能へアクセスできます。
                </p>
                <div class="hero-actions">
                    <a href="{{ route('adminHotelSearchPage') }}" class="btn-hero-primary">
                        <span>🔍</span> ホテル検索・一覧
                    </a>
                    <a href="{{ route('adminHotelCreatePage') }}" class="btn-hero-secondary">
                        <span>➕</span> ホテル新規登録
                    </a>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <span class="info-icon">🏨</span>
                <div class="info-body">
                    <h4 class="info-card-title">ホテル管理機能</h4>
                    <p class="info-card-text">登録済みホテルの検索、都道府県別フィルタリング、情報の編集および安全な削除が行えます。</p>
                </div>
            </div>
            <div class="info-card">
                <span class="info-icon">⚡</span>
                <div class="info-body">
                    <h4 class="info-card-title">リアルタイム反映</h4>
                    <p class="info-card-text">追加・変更されたホテル情報や画像は、ユーザー画面のホテル一覧へ即時に反映されます。</p>
                </div>
            </div>
        </div>
    </div>
@endsection