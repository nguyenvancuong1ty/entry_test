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
            <h2 class="title">ホテル追加</h2>
            <p class="subtitle">新しく掲載するホテルの基本情報を登録します。</p>
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

        <div class="form-card">
            <form action="{{ route('adminHotelCreateProcess') }}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>
                                <div class="th-label-wrapper">
                                    <label for="hotel_name">ホテル名</label>
                                    <span class="badge-required">必須</span>
                                </div>
                            </th>
                            <td>
                                <input type="text" id="hotel_name" name="hotel_name" class="form-input @error('hotel_name') is-invalid @enderror" value="{{ old('hotel_name') }}" placeholder="例: ホテルサクラ">
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
                                        <option value="{{ $prefecture->prefecture_id }}" @selected((string) old('prefecture_id') === (string) $prefecture->prefecture_id)>
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
                                <div class="form-file-container">
                                    <input type="file" id="file" name="file" class="form-file @error('file') is-invalid @enderror" accept="image/*">
                                    <p class="file-hint">※JPEG, PNG, JPG, GIF, WebP (最大2MB)</p>
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
                        <span>➕</span> 登録する
                    </button>
                    <a href="{{ route('adminHotelSearchPage') }}" class="btn-secondary">キャンセル</a>
                </div>
            </form>
        </div>
    </div>
@endsection
