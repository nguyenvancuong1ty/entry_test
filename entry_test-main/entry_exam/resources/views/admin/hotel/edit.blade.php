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
            <h2 class="title">ホテル編集（入力画面）</h2>
            <p class="subtitle">変更内容を入力し、「確認画面へ進む」ボタンをクリックしてください。</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-item active">
                <span class="step-number">1</span>
                <span class="step-label">情報の入力</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <span class="step-number">2</span>
                <span class="step-label">内容の確認</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <span class="step-number">3</span>
                <span class="step-label">更新完了</span>
            </div>
        </div>

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

        <div class="form-card">
            <form action="{{ route('adminHotelEditConfirm') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotel->hotel_id }}">
                <input type="hidden" name="current_new_file_path" value="{{ old('current_new_file_path', $current_new_file_path ?? '') }}">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>
                                <div class="th-label-wrapper">
                                    <label>ホテルID</label>
                                </div>
                            </th>
                            <td>
                                <strong style="color: #64748b;">#{{ $hotel->hotel_id }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="th-label-wrapper">
                                    <label for="hotel_name">ホテル名</label>
                                    <span class="badge-required">必須</span>
                                </div>
                            </th>
                            <td>
                                <input type="text" id="hotel_name" name="hotel_name" class="form-input @error('hotel_name') is-invalid @enderror" value="{{ old('hotel_name', $hotel->hotel_name) }}">
                                @error('hotel_name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="th-label-wrapper">
                                    <label for="prefecture_id">都道府県</label>
                                    <span class="badge-required">必須</span>
                                </div>
                            </th>
                            <td>
                                <select id="prefecture_id" name="prefecture_id" class="form-select @error('prefecture_id') is-invalid @enderror">
                                    <option value="">都道府県を選択してください</option>
                                    @foreach ($prefectures as $prefecture)
                                        <option value="{{ $prefecture->prefecture_id }}" {{ old('prefecture_id', $hotel->prefecture_id) == $prefecture->prefecture_id ? 'selected' : '' }}>
                                            {{ $prefecture->prefecture_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prefecture_id')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <div class="th-label-wrapper">
                                    <label for="file">ホテル画像</label>
                                    <span class="badge-optional">任意</span>
                                </div>
                            </th>
                            <td>
                                @if ($hotel->image_url)
                                    <div class="image-preview">
                                        <span class="preview-badge current">現在の画像</span>
                                        <img src="{{ $hotel->image_url }}" alt="{{ $hotel->hotel_name }}">
                                    </div>
                                @endif
                                <div class="form-file-container">
                                    <input type="file" id="file" name="file" class="form-file @error('file') is-invalid @enderror" accept="image/*">
                                    <p class="file-hint">※新しい画像に変更する場合のみ選択してください (最大2MB)</p>
                                </div>
                                @error('file')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="btn-group">
                    <button type="submit" class="btn-primary">
                        確認画面へ進む <span>→</span>
                    </button>
                    <a href="{{ route('adminHotelSearchPage') }}" class="btn-secondary">戻る</a>
                </div>
            </form>
        </div>
    </div>
@endsection
