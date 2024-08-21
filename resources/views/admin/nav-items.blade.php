@canany(['Campaign access', 'Media access', 'Page access', 'Investment access'])
    <li class="nav-item @if (request()->is([
            'admin/menu/*',
            'admin/static/page/*',
            'admin/slider/*',
            'admin/service/*',
            'admin/sector/*',
            'admin/client/*',
            'admin/fun/*'
        ])) menu-open @endif my-2">
        <a href="#" class="nav-link">
            <i class="fas fa-folder-open nav-icon"></i>
            <p>{{ __('Contents') }}<i class="right fas fa-angle-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            @can('Page access')
                <li class="nav-item">
                    <a href="{{ route('admin.static.pages.index') }}"
                        class="nav-link @if (request()->is('admin/static/page/*')) active bg-gray @endif">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <p>{{ __('Static Pages') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('admin.services.index') }}"
                        class="nav-link @if (request()->is('admin/service/*')) active bg-gray @endif">
                        <i class="fas fa-concierge-bell nav-icon"></i>
                        <p>{{ __('Services') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('admin.sectors.index') }}"
                        class="nav-link @if (request()->is('admin/sector/*')) active bg-gray @endif">
                        <i class="fas fa-industry nav-icon"></i>
                        <p>{{ __('Sectors') }}</p>
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('admin.slider.index') }}"
                    class="nav-link @if (request()->is('admin/slider/*')) active bg-gray @endif">
                    <i class="fas fa-image nav-icon"></i>
                    <p>{{ __('Homepage Banner') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.client.index') }}"
                    class="nav-link @if (request()->is('admin/client/*')) active bg-gray @endif">
                    <i class="fas fa-user nav-icon"></i>
                    <p>{{ __('Clients') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.fun.index') }}"
                    class="nav-link @if (request()->is('admin/fun/*')) active bg-gray @endif">
                    <i class="fas fa-image nav-icon"></i>
                    <p>{{ __('fun') }}</p>
                </a>
            </li>
        </ul>
    </li>
@endcanany

@can('Team access')
    <li class="nav-item @if (request()->is(['admin/team/*', 'admin/designation/*'])) menu-open @endif mb-2">
        <a href="#" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
            <p>{{ __('Teams') }}<i class="right fas fa-angle-right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.designation.index') }}"
                    class="nav-link @if (request()->is('admin/designation/*')) active bg-gray @endif">
                    <i class="fas fa-user nav-icon"></i>
                    <p>{{ __('Designations') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.teams.index') }}"
                    class="nav-link @if (request()->is('admin/team/*')) active bg-gray @endif">
                    <i class="fas fa-user-friends nav-icon"></i>
                    <p>{{ __('Members') }}</p>
                </a>
            </li>
        </ul>
    </li>
    <!--
@endcanany -->

<li class="nav-item mb-2">
    <a href="{{ route('admin.contact.index') }}"
        class="nav-link @if (request()->is('admin/contact/*')) active bg-gray @endif">
        <i class="fas fa-envelope nav-icon"></i>
        <p>{{ __('Contact Messages') }}</p>
    </a>
</li>

<li class="nav-item @if (request()->is([
        'admin/site-setting/*',
        'admin/permissions',
        'admin/permissions/*',
        'admin/roles',
        'admin/roles/*',
        'admin/users',
        'admin/users/*',
        'admin/language/*',
    ])) menu-open @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Settings
            <i class="right fas fa-angle-right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
                class="nav-link @if (request()->is('admin/users', 'admin/users/*')) active bg-gray @endif">
                <i class="fas fa-user nav-icon"></i>
                <p>Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.roles.index') }}"
                class="nav-link @if (request()->is('admin/roles', 'admin/roles/*')) active bg-gray @endif">
                <i class="fas fa-user-tag nav-icon"></i>
                <p>Roles</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.permissions.index') }}"
                class="nav-link @if (request()->is('admin/permissions')) active bg-gray @endif">
                <i class="fas fa-key nav-icon"></i>
                <p>Permissions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.site.setting.edit', 1) }}"
                class="nav-link @if (request()->is('admin/site-setting/*')) active bg-gray @endif">
                <i class="nav-icon fas fa fa-cogs"></i>
                <p>{{ __('Site Settings') }}</p>
            </a>
        </li>
    </ul>
</li>

<style>
    .active>.nav-link {
        color: #fff !important;
    }
</style>
