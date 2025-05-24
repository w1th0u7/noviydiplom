                        <i class="fas fa-umbrella-beach"></i> Управление турами
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.excursions.index') }}" class="{{ request()->routeIs('admin.excursions.*') ? 'active' : '' }}">
                        <i class="fas fa-landmark"></i> Управление экскурсиями
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"> 