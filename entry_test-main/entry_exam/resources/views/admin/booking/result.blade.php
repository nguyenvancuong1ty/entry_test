@extends('admin.booking.search')

@section('search_results')
    <div class="result-card">
        <div class="result-header">
            <h3 class="result-title">予約検索結果</h3>
            @if ($bookingList->isNotEmpty())
                <span class="result-badge">{{ $bookingList->total() }} 件</span>
            @endif
        </div>

        @if ($bookingList->isNotEmpty())
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="col-customer">顧客名</th>
                            <th class="col-contact">顧客連絡先</th>
                            <th class="col-hotel">ホテル名</th>
                            <th class="col-datetime">チェックイン日時</th>
                            <th class="col-datetime">チェックアウト日時</th>
                            <th class="col-timestamp">予約日時</th>
                            <th class="col-timestamp">情報更新日時</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookingList as $booking)
                            <tr>
                                <td class="cell-name cell-customer">
                                    <div class="hotel-info">
                                        <div class="hotel-thumb-placeholder">👤</div>
                                        <strong>{{ $booking->customer_name }}</strong>
                                    </div>
                                </td>
                                <td class="cell-contact">
                                    <span class="cell-contact-text">{{ $booking->customer_contact }}</span>
                                </td>
                                <td class="cell-hotel">
                                    @if ($booking->hotel)
                                        <a href="{{ route('hotelDetail', ['hotel_id' => $booking->hotel->hotel_id]) }}" target="_blank" rel="noopener noreferrer" class="hotel-link">
                                            {{ $booking->hotel->hotel_name }}
                                        </a>
                                        <div class="hotel-sub-pref">{{ $booking->hotel->prefecture?->prefecture_name ?? '' }}</div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="cell-datetime">
                                    <strong>{{ $booking->checkin_time_text }}</strong>
                                </td>
                                <td class="cell-datetime">
                                    <strong>{{ $booking->checkout_time_text }}</strong>
                                </td>
                                <td class="text-muted cell-timestamp">
                                    {{ $booking->created_at }}
                                </td>
                                <td class="text-muted cell-timestamp">
                                    {{ $booking->updated_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-common.pagination :paginator="$bookingList" />
        @else
            <div class="empty-state">
                <span class="empty-icon">📅</span>
                <p class="empty-title">予約情報が見つかりません</p>
                <p class="empty-desc">検索条件を変更して再度検索してください。</p>
            </div>
        @endif
    </div>
@endsection
