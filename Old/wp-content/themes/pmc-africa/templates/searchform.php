<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
  <div class="input-group">
    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-input form-control" placeholder="<?php _e('Search', 'roots'); ?>">
    <label class="hide"><?php _e('Search for:', 'roots'); ?></label>
    <span class="input-group-btn">
      <button type="image" class="search-submit btn btn-default"></button>
    </span>
  </div>
</form>
