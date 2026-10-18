<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <div class="page-header">
            <h2 class="title">予約情報検索</h2>
            <p class="subtitle">宿泊予約情報の検索・管理が行えます。</p>
        </div>

        @if (session('success_message'))
            <div class="alert-banner alert-success">
                <span class="alert-icon">✓</span>
                <span>{{ session('success_message') }}</span>
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert-banner alert-danger">
                <span class="alert-icon">⚠️</span>
                <span>{{ session('error_message') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-banner alert-danger">
                <div>
                    <strong style="display: block; margin-bottom: 4px;">入力内容にエラーがあります:</strong>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="search-card">
            <form action="{{ route('adminBookingSearchResult') }}" method="get" class="search-form">
                <div class="form-group">
                    <label class="form-label" for="customer_name">顧客名</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $filters['customer_name'] ?? '') }}" placeholder="例: 佐藤 太郎" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label" for="customer_contact">顧客連絡先</label>
                    <input type="text" id="customer_contact" name="customer_contact" value="{{ old('customer_contact', $filters['customer_contact'] ?? '') }}" placeholder="例: 090-xxxx-xxxx / email" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label" for="chekin_time">チェックイン日時</label>
                    <input type="date" id="chekin_time" name="chekin_time" value="{{ old('chekin_time', $filters['chekin_time'] ?? '') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label" for="checkout_time">チェックアウト日時</label>
                    <input type="date" id="checkout_time" name="checkout_time" value="{{ old('checkout_time', $filters['checkout_time'] ?? '') }}" class="form-control">
                </div>
                <div class="form-action">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon">🔍</span> 検索
                    </button>
                </div>
            </form>
        </div>

        @yield('search_results')
    </div>
@endsection
