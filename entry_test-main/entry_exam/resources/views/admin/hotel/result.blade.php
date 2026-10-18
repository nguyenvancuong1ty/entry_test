@extends('admin.hotel.search')

@section('search_results')
    <div class="result-card">
        <div class="result-header">
            <h3 class="result-title">検索結果</h3>
            @if (!empty($hotelList) && count($hotelList) > 0)
                <span class="result-badge">{{ count($hotelList) }} 件</span>
            @endif
        </div>

        @if (!empty($hotelList) && count($hotelList) > 0)
            <div class="table-responsive">
                <table class="hotel-table">
                    <thead>
                        <tr>
                            <th class="col-name">ホテル名</th>
                            <th class="col-pref">都道府県</th>
                            <th class="col-date">登録日</th>
                            <th class="col-date">更新日</th>
                            <th class="col-action">編集</th>
                            <th class="col-action">削除</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotelList as $hotel)
                            <tr>
                                <td class="cell-name">
                                    <div class="hotel-info">
                                        @if ($hotel->image_url)
                                            <img src="{{ $hotel->image_url }}" alt="{{ $hotel->hotel_name }}" class="hotel-thumb">
                                        @else
                                            <div class="hotel-thumb-placeholder">🏨</div>
                                        @endif
                                        <a href="{{ route('hotelDetail', ['hotel_id' => $hotel->hotel_id]) }}" target="_blank" class="hotel-link">
                                            {{ $hotel->hotel_name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="pref-badge">{{ $hotel->prefecture->prefecture_name ?? '' }}</span>
                                </td>
                                <td class="text-muted">
                                    {{ (string) $hotel->created_at }}
                                </td>
                                <td class="text-muted">
                                    {{ (string) $hotel->updated_at }}
                                </td>
                                <td class="cell-action">
                                    <form action="{{ route('adminHotelEditPage') }}" method="get">
                                        <input type="hidden" name="hotel_id" value="{{ $hotel->hotel_id }}">
                                        <button type="submit" class="btn-action-edit">編集</button>
                                    </form>
                                </td>
                                <td class="cell-action">
                                    <form action="{{ route('adminHotelDeleteProcess') }}" method="post" class="delete-form"
                                          data-confirm="本当に削除しますか？"
                                          data-confirm-title="ホテル削除の確認"
                                          data-confirm-target="{{ $hotel->hotel_name }}"
                                          data-confirm-btn="OK"
                                          data-confirm-type="danger">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="hotel_id" value="{{ $hotel->hotel_id }}">
                                        <button type="submit" class="btn-action-delete">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <span class="empty-icon">🔍</span>
                <p class="empty-title">検索結果がありません</p>
                <p class="empty-desc">条件を変更して再度検索してください。</p>
            </div>
        @endif
    </div>
@endsection