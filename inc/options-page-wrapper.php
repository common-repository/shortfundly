<!-- 
	this is the page which is loaded when setting's page is opened
 -->
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1><?php esc_attr_e( 'Shortfundly Shortfilm Settings', 'WpAdminStyle' ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">
                    
                    <?php if( !isset( $shortfundly_id ) || $shortfundly_id == '' ): ?>

					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span><?php esc_attr_e( 'Let us Get Started', 'WpAdminStyle' ); ?></span>
						</h2>

						<div class="inside">

							<p><?php esc_attr_e( 'Enter the X-API-KEY provided to you',
                                                 'WpAdminStyle' ); ?>
                            </p>
                            <form name="shortfundly_id_form" method="post" action=""> 
                                
                                <!-- <input type="hidden" name="shortfundly_form_submitted" value="Y"> -->
								<input type="hidden" name="shortfundly_form_submitted1" value="<?php echo wp_create_nonce('shortfundly_form_submitted1'); ?>">
                                <table class="form-table">
                                    <tr>
                                        <td>
                                            <label for="shortfundly_id">X-API-KEY</label>
                                         </td>
                                        <td>
                                            <input name="shortfundly_id" type="text" value="" class="regular-text" /><br>
                                        </td>
                                    </tr>
                              
                                </table> 
                                <p>
                                    <input class="button-primary" type="submit" name="Example" value="<?php esc_attr_e( 'SAVE' ); ?>" />
                                </p>
                            </form>    
						</div>
						<!-- .inside -->

					</div>
                    <!-- .postbox -->
					<?php else: 
						
						if($err!=2):
						?>

                    <div class="postbox">
						
					
                        <div class="handlediv" title="Click to toggle"><br></div>
                        <!-- Toggle -->
                        <h2 class="hndle"><span><?php esc_attr_e( 'Enter', 'WpAdminStyle' ); ?></span>
                        </h2>

                        <div class="inside">

                            <p><?php esc_attr_e( 'Enter the X-API-KEY provided  you',
                                                    'WpAdminStyle' ); ?>
                            </p>
                            <form name="shortfundly_id_form" method="post" action=""> 
                                
                                <!-- <input type="hidden" name="shortfundly_form_submitted" value="Y"> -->
                                <input type="hidden" name="shortfundly_form_submitted1" value="<?php echo wp_create_nonce('shortfundly_form_submitted1'); ?>">
                                <table class="form-table">
                                    <tr>
                                        <td>
                                            <label for="shortfundly_id">X-API-KEY</label>
                                            </td>
                                        <td>
                                            <input name="shortfundly_id" type="text" value="" class="regular-text" /><br>
                                        </td>
                                    </tr>
                                
                                </table> 
                                <p>
                                    <input class="button-primary" type="submit" name="Example" value="<?php esc_attr_e( 'NEW' ); ?>" />
                                </p>
                            </form>    
                        </div>
                        <!-- .inside -->

                    </div>

<?php else: ?>
<div id="poststuff"><p><?php echo "error wrong api"; $shortfundly_id=''; ?></p></div>
<input class="button-primary" type="submit" name="Example" onClick="refreshPage()" value="<?php esc_attr_e( 'GO BACK' ); ?>" />

<script>
function refreshPage(){
    window.location.reload();
} 
</script>
		<?php endif; ?>
	<?php endif; ?>

		</div>
				<!-- .meta-box-sortables .ui-sortable -->

		</div>
			<!-- post-body-content -->

			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span><?php esc_attr_e(
									'About Shortfundly', 'WpAdminStyle'
								); ?></span></h2>

						<div class="inside">
							<p><?php esc_attr_e( 'For visiting original site',
							                     'WpAdminStyle' ); ?></p>
												<a href="http://www.shortfundly.com"><?php esc_attr_e( 'click here',
							                     'WpAdminStyle' ); ?></a>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->