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
            <h2 class="title">ホテル編集（確認画面）</h2>
            <p class="subtitle">以下の内容で更新します。よろしければ「更新する」ボタンを押してください。</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-item completed">
                <span class="step-number">✓</span>
                <span class="step-label">情報の入力</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item active">
                <span class="step-number">2</span>
                <span class="step-label">内容の確認</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <span class="step-number">3</span>
                <span class="step-label">更新完了</span>
            </div>
        </div>

        <div class="form-card">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th>ホテルID</th>
                        <td><strong style="color: #64748b;">#{{ $hotel->hotel_id }}</strong></td>
                    </tr>
                    <tr>
                        <th>ホテル名</th>
                        <td><strong>{{ $hotel_name }}</strong></td>
                    </tr>
                    <tr>
                        <th>都道府県</th>
                        <td><span class="badge-optional">{{ $prefecture->prefecture_name }}</span></td>
                    </tr>
                    <tr>
                        <th>ホテル画像</th>
                        <td>
                            @if (!empty($new_image_url))
                                <div class="image-preview">
                                    <span class="preview-badge new">※変更後の新しい画像</span>
                                    <img src="{{ $new_image_url }}" alt="{{ $hotel_name }}">
                                </div>
                            @elseif ($hotel->image_url)
                                <div class="image-preview">
                                    <span class="preview-badge current">※現在の画像（変更なし）</span>
                                    <img src="{{ $hotel->image_url }}" alt="{{ $hotel_name }}">
                                </div>
                            @else
                                <span style="color: #94a3b8; font-size: 13px;">画像なし</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <form action="{{ route('adminHotelEditProcess') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="hotel_id" value="{{ $hotel->hotel_id }}">
                <input type="hidden" name="hotel_name" value="{{ $hotel_name }}">
                <input type="hidden" name="prefecture_id" value="{{ $prefecture_id }}">
                <input type="hidden" name="new_file_path" value="{{ $new_file_path }}">

                <div class="btn-group">
                    <button type="submit" class="btn-primary">
                        <span>✓</span> 更新する
                    </button>
                    <button type="button" class="btn-secondary" onclick="history.back();">
                        <span>←</span> 修正する
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
