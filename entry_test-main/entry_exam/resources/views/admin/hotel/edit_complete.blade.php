<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/form.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="page-wrapper form-page-wrapper">
        <div class="page-header">
            <h2 class="title">ホテル編集（完了画面）</h2>
            <p class="subtitle">ホテル情報の更新処理が正常に完了しました。</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-item completed">
                <span class="step-number">✓</span>
                <span class="step-label">情報の入力</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item completed">
                <span class="step-number">✓</span>
                <span class="step-label">内容の確認</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item active">
                <span class="step-number">3</span>
                <span class="step-label">更新完了</span>
            </div>
        </div>

        <div class="complete-card">
            <div class="complete-icon">✓</div>
            <h3 class="complete-message">ホテル情報の更新が完了しました。</h3>

            <div class="complete-table-wrapper">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>ホテルID</th>
                            <td><strong style="color: #64748b;">#{{ $hotel->hotel_id }}</strong></td>
                        </tr>
                        <tr>
                            <th>ホテル名</th>
                            <td><strong>{{ $hotel->hotel_name }}</strong></td>
                        </tr>
                        <tr>
                            <th>都道府県</th>
                            <td><span class="badge-optional">{{ $hotel->prefecture->prefecture_name ?? '' }}</span></td>
                        </tr>
                        @if ($hotel->image_url)
                            <tr>
                                <th>ホテル画像</th>
                                <td>
                                    <div class="image-preview" style="margin: 0;">
                                        <img src="{{ $hotel->image_url }}" alt="{{ $hotel->hotel_name }}">
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="btn-group center">
                <a href="{{ route('adminHotelSearchPage') }}" class="btn-primary">
                    <span>🔍</span> ホテル検索画面へ
                </a>
                <a href="{{ route('adminTop') }}" class="btn-secondary">
                    <span>🏠</span> 管理者トップへ
                </a>
            </div>
        </div>
    </div>
@endsection
