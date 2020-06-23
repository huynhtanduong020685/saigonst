<ul {!! $options !!}>
    @foreach ($menu_nodes as $key => $row)
    <li class="nav-item {{ $row->css_class }}">
        <a class="nav-link @if ($row->url == Request::url() || Str::contains(Request::url() . '?', $row->url)) active text-orange @endif" href="{{ $row->url }}" target="{{ $row->target }}">
            @if ($row->icon_font)<i class='{{ trim($row->icon_font) }}'></i> @endif{{ $row->title }}
            @if ($row->url == Request::url()) <span class="sr-only">(current)</span> @endif
        </a>
        @if ($row->has_child)
            {!!
                Menu::generateMenu([
                    'slug' => $menu->slug,
                    'view' => 'main-menu',
                    'options' => ['class' => 'dropdown-menu'],
                    'parent_id' => $row->id,
                ])
            !!}
        @endif
    </li>
    @endforeach
</ul>
