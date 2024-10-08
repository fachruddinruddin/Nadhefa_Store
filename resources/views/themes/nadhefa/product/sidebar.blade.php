<div class="sidebar">
    @if($categories->count() > 0)
    <div class="sidebar-widget">
        <div class="widget-title">
            <h5>Categories</h5>
        </div>
        <div class="widget-content widget-categories">
            <ul class="nav nav-category">
                @foreach ($categories as $category)
                <li class="nav-item border-bottom w-100">
                    <a class="nav-link" href="{{ shop_category_link($category) }}">{{ $category->name}}<i class='bx bx-chevron-right'></i></a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="sidebar-widget mt-4">
        <!-- Additional Sidebar Widget -->
         <div class="okok"></div>
    </div>
</div>