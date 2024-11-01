<?php 		
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    echo $before_widget;
    
	echo $before_title . $title . $after_title;	
global $page_no;
$page_no=2;
     ?>
<?php 
if($err!=2){
for($i=0;$i<=4;$i++){?>
     <a href="<?php echo 'http://www.shortfundly.com/video/'.$shortfundly_data->{'results'}[$i]->{'id'}; ?>">
                            <img src="
                            <?php echo $shortfundly_data->{'results'}[$i]->{'thumb'}; ?>
							"></a>

                            <p>
								<?php echo $shortfundly_data->{'results'}[$i]->{'title'}; ?>
							</p>


<?php }}?> 
<!-- <p><?php echo "magggi ".$page_no; ?></p> -->
<button id="button_2" value="val_1" name="but1" ><</button>
<button id="button_1" value="val_1" name="but1">></button>

<!-- <input class="button-primary" type="submit" name="Example" id = "wei1"value="<?php esc_attr_e( 'GO BACK' ); ?>" /> -->

<script>
jQuery(document).ready(function($){
    console.log( 'AJAX compleaasdte' );

    $("#button_1").click(function(){
       
        console.log( 'AJAX complete1111' );

        $.post(ajaxurl, {

            action: 'shortfundly_badges_refresh_profile'

            }, function( response ) {

                console.log( 'AJAX complete' );
                                    }
            );
            location.reload();
    });


    $("#button_2").click(function(){
       
       

       $.post(ajaxurl, {

           action: 'shortfundly_badges_refresh_profil2'

           }, function( response ) {

               console.log( 'AJAX complet2' );
                                   }
           );
           location.reload();
   });

});
</script>
     <?php
	echo $after_widget; 

?>
