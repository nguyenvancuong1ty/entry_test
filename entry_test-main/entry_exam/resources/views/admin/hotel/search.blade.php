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
            <h2 class="title">ホテル検索</h2>
            <p class="subtitle">登録されているホテル情報を名前や都道府県で検索・管理できます。</p>
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
            <form action="{{ route('adminHotelSearchResult') }}" method="get" class="search-form">
                <div class="form-group">
                    <label class="form-label" for="hotel_name">ホテル名</label>
                    <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $hotel_name ?? '') }}" placeholder="例: ホテルサクラ" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label" for="prefecture_id">都道府県</label>
                    <select id="prefecture_id" name="prefecture_id" class="form-select">
                        <option value="">すべての都道府県</option>
                        @if (!empty($prefectures))
                            @foreach ($prefectures as $prefecture)
                                <option value="{{ $prefecture->prefecture_id }}" {{ old('prefecture_id', $prefecture_id ?? '') == $prefecture->prefecture_id ? 'selected' : '' }}>
                                    {{ $prefecture->prefecture_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-action">
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon">🔍</span> 検索
                    </button>
                </div>
            </form>
            @if (!empty($errorMessage))
                <p class="search-error-message" style="color: red;">{{ $errorMessage }}</p>
            @endif
        </div>

        @yield('search_results')
    </div>
@endsection