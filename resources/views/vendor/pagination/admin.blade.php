@if ($paginator->hasPages())
    <nav>
        <ul class="admin-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="admin-pagination-btn" data-direction="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="fallback-arrow">‹</span>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" class="admin-pagination-btn" data-direction="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="fallback-arrow">‹</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true">
                        <span class="admin-pagination-btn">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <span class="admin-pagination-btn">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="admin-pagination-btn">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="admin-pagination-btn" data-direction="next">
                        <i class="fas fa-chevron-right"></i>
                        <span class="fallback-arrow">›</span>
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="admin-pagination-btn" data-direction="next">
                        <i class="fas fa-chevron-right"></i>
                        <span class="fallback-arrow">›</span>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        /* Показываем Font Awesome иконки по умолчанию */
        .admin-pagination-btn .fas {
            display: inline-block;
        }
        
        /* Скрываем fallback стрелки по умолчанию */
        .admin-pagination-btn .fallback-arrow {
            display: none;
        }
        
        /* Если Font Awesome не загрузился, показываем fallback */
        @supports not (font-family: "Font Awesome 6 Free") {
            .admin-pagination-btn .fas {
                display: none;
            }
            .admin-pagination-btn .fallback-arrow {
                display: inline-block;
                font-size: 16px;
                font-weight: bold;
            }
        }
    </style>
@endif 