<aside class="admin-menu">
    <div class="menu-block">
        <div class="brand">
            <a href="{{ route('adminTop') }}" class="brand-link">
                <span class="brand-logo">🏨</span>
                <span class="brand-text">THK Travel Admin</span>
            </a>
        </div>
        <div class="menu-section">
            <h3 class="section-title">サイト管理</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('adminHotelSearchPage', 'adminHotelSearchResult') ? 'active' : '' }}" href="{{ route('adminHotelSearchPage') }}">
                        <span class="nav-icon">🔍</span>
                        <span class="nav-label">ホテル検索</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('adminHotelCreatePage', 'adminHotelCreateProcess') ? 'active' : '' }}" href="{{ route('adminHotelCreatePage') }}">
                        <span class="nav-icon">➕</span>
                        <span class="nav-label">ホテル追加</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="menu-footer">
            <a href="{{ route('top') }}" class="portal-link" target="_blank">
                <span>🌐</span> ユーザー画面を開く
            </a>
        </div>
    </div>
</aside>