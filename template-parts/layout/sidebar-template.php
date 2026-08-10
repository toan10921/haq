<div class="col-3 <?php $sidebar_pos == 'left' ? 'left-sidebar' : ($sidebar_pos == 'right' ? 'right-sidebar' : '') ?>">
    <div class="filter-overlay"></div>
    <aside id="secondary" class="widget-area">
        <button type="button" class="btn-close-filter"><i class="las la-times"></i></button>
        <?php dynamic_sidebar($sidebar); ?>
    </aside>
</div>