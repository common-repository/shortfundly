<!-- this is what is shown when you open or see in the widgets tab after activation -->
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<p>
  <label>Title</label> 
  <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>