<!-- Sidebar -->
<nav id="sidebar" class="d-flex flex-column p-3">
    <div class="logo-container">
        <img src="/img/logoams.png" alt="{{ __('cms.sidebar.logo') }}">
    </div>
    <div class="search-container position-relative">
        <input type="text" class="form-control" placeholder="{{ __('cms.sidebar.search_placeholder') }}" id="searchInput" autocomplete="off">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" href="#"><i class="fas fa-home me-2"></i> <span>{{ __('cms.sidebar.dashboard') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#categoryMenu" role="button" aria-expanded="false" aria-controls="categoryMenu">
                <span><i class="fas fa-th-large me-2"></i> <span>{{ __('cms.sidebar.categories.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.categories.create' || Route::currentRouteName() == 'admin.categories.index' ? 'show' : '' }}" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.categories.create' ? 'active' : '' }}" href="{{ route('admin.categories.create') }}">{{ __('cms.sidebar.categories.add_new') }}</a></li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">{{ __('cms.sidebar.categories.list') }}</a></li>
                </ul>
            </div>
        </li>           
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#brandMenu" role="button" aria-expanded="false" aria-controls="brandMenu">
                <span><i class="fas fa-tags me-2"></i> <span>{{ __('cms.sidebar.brands.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.brands.create' || Route::currentRouteName() == 'admin.brands.index' ? 'show' : '' }}" id="brandMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.brands.create' ? 'active' : '' }}" href="{{ route('admin.brands.create') }}">{{ __('cms.sidebar.brands.add_new') }}</a></li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.brands.index' ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">{{ __('cms.sidebar.brands.list') }}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#productMenu" role="button" aria-expanded="false" aria-controls="productMenu">
                <span><i class="fas fa-box me-2"></i> <span>{{ __('cms.sidebar.products.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.products.create' || Route::currentRouteName() == 'admin.products.index' ? 'show' : '' }}" id="productMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.products.create' ? 'active' : '' }}" href="{{ route('admin.products.create') }}">{{ __('cms.sidebar.products.add_new') }}</a></li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}" href="{{ route('admin.products.index') }}">{{ __('cms.sidebar.products.list') }}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#customerMenu" role="button" aria-expanded="false" aria-controls="customerMenu">
                <span><i class="fas fa-users me-2"></i> <span>{{ __('cms.sidebar.customers.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.customers.create', 'admin.customers.index']) ? 'show' : '' }}" id="customerMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.customers.index' ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">{{ __('cms.sidebar.brands.list') }}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#blogMenu" role="button" aria-expanded="false" aria-controls="blogMenu">
                <span><i class="fas fa-blog me-2"></i> <span>Blog</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.blogs.*') ? 'show' : '' }}" id="blogMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}" href="{{ route('admin.blogs.create') }}">Tambah Baru</a></li>
                    <li><a class="nav-link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">Daftar</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuMenu" role="button" aria-expanded="false" aria-controls="menuMenu">
                <span><i class="fas fa-bars me-2"></i> <span>{{ __('cms.sidebar.menu.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.menus.create' || Route::currentRouteName() == 'admin.menus.index' ? 'show' : '' }}" id="menuMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menus.create' ? 'active' : '' }}" href="{{ route('admin.menus.create') }}">{{ __('cms.sidebar.menu.add_new') }}</a></li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menus.index' ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">{{ __('cms.sidebar.menu.list') }}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menuItemMenu" role="button" aria-expanded="false" aria-controls="menuItemMenu">
                <span><i class="fas fa-list me-2"></i> <span>{{ __('cms.sidebar.menu_items.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'admin.menuitems.create' || Route::currentRouteName() == 'admin.menuitems.index' ? 'show' : '' }}" id="menuItemMenu">
                <ul class="nav flex-column ms-3">
                    @if(isset($menu) && $menu)
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menu.items.create' ? 'active' : '' }}" href="{{ route('admin.menus.items.create', $menu) }}">{{ __('cms.sidebar.menu_items.add_new') }}</a></li>
                    <li><a class="nav-link {{ Route::currentRouteName() == 'admin.menus.item.index' ? 'active' : '' }}" href="{{ route('admin.menus.item.index') }}">{{ __('cms.sidebar.menu_items.list') }}</a></li>
                    @endif
                </ul>
            </div>
        </li>                       
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#siteSettingsMenu" role="button" aria-expanded="false" aria-controls="siteSettingsMenu">
                <span><i class="fas fa-cog me-2"></i> <span>{{ __('cms.sidebar.site_settings.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ Route::currentRouteName() == 'site-settings.index' ? 'show' : '' }}" id="siteSettingsMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ Route::currentRouteName() == 'site-settings.index' ? 'active' : '' }}" href="{{ route('site-settings.index') }}">{{ __('cms.sidebar.site_settings.manage') }}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#languageMenu" role="button" aria-expanded="false" aria-controls="languageMenu">
                <span><i class="fas fa-language me-2"></i> <span>{{ __('cms.sidebar.languages.title') }}</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.languages.*') ? 'show' : '' }}" id="languageMenu">
                <ul class="nav flex-column ms-3">
                    <li><a class="nav-link {{ request()->routeIs('admin.languages.create') ? 'active' : '' }}" href="{{ route('admin.languages.create') }}">{{ __('cms.sidebar.languages.add_new') }}</a></li>
                    <li><a class="nav-link {{ request()->routeIs('admin.languages.index') ? 'active' : '' }}" href="{{ route('admin.languages.index') }}">{{ __('cms.sidebar.languages.list') }}</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#pageMenu" role="button" aria-expanded="false" aria-controls="pageMenu">
            <span><i class="fas fa-file-alt me-2"></i> <span>Pages</span></span>
            <i class="fas fa-chevron-down"></i>
        </a>
        <div class="collapse {{ Route::currentRouteName() == 'admin.pages.create' || Route::currentRouteName() == 'admin.pages.index' ? 'show' : '' }}" id="pageMenu">
            <ul class="nav flex-column ms-3">
                <li>
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.pages.create' ? 'active' : '' }}" href="{{ route('admin.pages.create') }}">
                    Add New
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.pages.index' ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    List
                    </a>
                </li>
            </ul>
        </div>
    </li>
    </ul>
</nav>