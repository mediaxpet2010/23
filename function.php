<?php

/**

 * Electro Child

 *

 * @package electro-child

 */



/**

 * Include all your custom code here

 */

/*   IN Afiseaza decimalele mai sus ca restul pretului*/



add_filter( 'formatted_woocommerce_price', 'ts_woo_decimal_price', 10, 5 );



function ts_woo_decimal_price( $formatted_price, $price, $decimal_places, $decimal_separator, $thousand_separator ) {



	$unit = number_format( intval( $price ), 0, $decimal_separator, $thousand_separator );



	$decimal = sprintf( '%02d', ( $price - intval( $price ) ) * 100 );



	return $unit . '<sup>' . $decimal_separator. $decimal . '</sup>';



}

/*  OUT Afiseaza decimalele mai sus ca restul pretului */



/*  IN Nu se afiseaza produsele din categoriile puse aici: */





/* am instalta un plugin category hide o gasesti in WooCommerce:  Specific Hide Categories Or Products*/













/*  OUT Nu se afiseaza produsele din categoriile puse aici: */





/*  IN Sterge Becom a Vendor din My Account */

remove_action( 'woocommerce_after_my_account', array( Dokan_Pro::init(), 'dokan_account_migration_button' ) );



/*  OUT Sterge Becom a Vendor din My Account */





/*  IN  Disable WordPress Admin Bar for all users but admins.*/ 

  show_admin_bar(false);

/*  OUT  Disable WordPress Admin Bar for all users but admins.*/ 





/*  IN  Se misca linia debranduri cu degetul pe mobil */ 

add_filter( 'ec_footer_bc_carousel_args', 'ec_child_enable_touch_drag' );

function ec_child_enable_touch_drag( $args ) {

$args['touchDrag'] = true;

return $args;

}

/*  OUT  Se misca linia debranduri cu degetul pe mobil */ 





/*  IN  Sterge cuvantul Wordpress din titlu  */

function custom_login_title( $login_title ) {

return str_replace(array( ' &lsaquo;', ' &#8212; WordPress'), array( ' &bull;', ' &#8212; Iti multumim!'),$login_title );

}

add_filter( 'login_title', 'custom_login_title' );

function custom_admin_title( $admin_title ) {

return str_replace(array( ' &lsaquo;', ' &#8212; WordPress'), array( ' &bull;', ' &#8212; Iti multumim!'),$admin_title );

}

add_filter( 'admin_title', 'custom_admin_title' );

/*  OUT  Sterge cuvantul Wordpress din titlu  */









/*  IN  Adauga cauta cautarea pentru mobil ajax Search */

function electro_handheld_header_search() { ?>

	<div class="site-search">

		<?php

			echo do_shortcode('[wcas-search-form]');

		?>

	</div> <?php

}

add_filter( 'electro_enable_live_search', '__return_false', 20 );

/*  OUT  Adauga cauta cautarea pentru mobil ajax Search */





/*  IN  Adauga in pagina dokan produse campul de add XML  */

add_action('dokan_before_listing_product', 'print_somthing_after_before_listing_produc');

function print_somthing_after_before_listing_produc () {

$num1 = '</div>';   

    printf( '

	<div class="dokan-import-xml-style">

	In cazul in care aveti posibilitatea sa generati un feed XML online din site-ul dumneavoastra care se actualizeaza automat, cu atat mai bine! .

	<br>

	Acest Feed XML trebuie sa fie realizat pe sablon Google Shopping <A HREF="https://simplo.ro/import-feed-xml-sablon-google-shopping/" target="_blank">Vezi exemplu >></a>

	<br>Link-ul generat trebuie sa se termine cu exetnesia .xml ex.: https://www.numesite/feed-simplo<b>.xml</b>

	<br><br>

	<b>Adauga link-ul XML in campul urmator:</b>

');

	echo do_shortcode(apply_filters("the_content", "[contact-form-7 id='193822']"));

	echo sprintf($num1);

}

/*  OUT  Adauga in pagina dokan produse campul de add XML  */




/* IN Nu afiseaza produsele Out of Stok  */

add_filter( 'electro_template_loop_product_thumbnail', 'ec_child_loop_stock', 10 );

function ec_child_loop_stock() {

    global $product;

    $outofstock = '';

    if ( ! $product->is_in_stock() ) {

        $outofstock = '<span class="outofstock">' . esc_html__( 'Stoc epuizat', 'woocommerce' ) . '</span>';

    }

    $thumbnail = woocommerce_get_product_thumbnail();

    echo wp_kses_post( sprintf( '<div class="product-thumbnail">%s%s</div>', $outofstock, $thumbnail ) );

}

/*  OUT  Nu afiseaza produsele Out of Stok  */







/* IN Exclude produsele Tag  */

add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $query ) {

    $query->set( 'meta_query', array( array(

       'key' => '_thumbnail_id',

       'value' => '0',

       'compare' => '>'

    )));

}

/* OUT Exclude produsele Tag  */







/* IN  Adding Settings extra menu in Settings tabs Dahsboard */

add_filter( 'dokan_get_dashboard_settings_nav', 'dokan_add_settings_menu' );

function dokan_add_settings_menu( $settings_tab ) {

	$settings_tab['contractual'] = array(

        'title' => __( 'Contractual', 'dokan'),

        'icon'  => '<i class="fa fa-file-pdf-o"></i>',

        'url'   => dokan_get_navigation_url( 'settings/contractual' ),

        'pos'   => 21

	);

	return $settings_tab;

}

add_filter( 'dokan_dashboard_settings_heading_title', 'dokan_load_settings_header', 11, 2 );

function dokan_load_settings_header( $header, $query_vars ) {

	if ( $query_vars == 'contractual' ) {

        $header = __( 'Raport Contractual', 'dokan' );

    }

    return $header;

}

add_filter( 'dokan_dashboard_settings_helper_text', 'load_helper', 10, 2 );

function load_helper( $helper_txt, $query_var ) {

	if ( $query_var == 'contractual' ) {

		$helper_txt = '

Web Media Concept SRL (Simplo.ro) isi rezerva dreptul de a modifica Conditiile de utilizare si Anexele componente

oricand este necesar, fara instiintare prealabila!<br>

Modificarile intra in vigoare la 15 zile de la publicarea lor pe site, iar in cazul in care nu sunteti de acord cu acestea

trebuie sa stergeti toate produsele adaugate in platforma Simplo.ro si apoi sa solicitati in scris stergerea contului in formularul din sectiunea Contact.

<br>

Orice utilizare a platformei dupa cele 15 zile, inseamna acceptarea acestor modificari.

<br>

Versiunea actualizata a Conditiilor de utilizare si Anexelor sale o puteti regasi oricand in contul dumneavoastra in sectiunea 

Setari & Juridic > Contractual

<br>

<font color="green">Adaugarea produselor spre vanzare pe platfomra Simplo.ro arata ca ati citit si ati acceptat toate

aceste Conditii de utilizare precum si Anexele aferente.</font>

		';

	}

	return $helper_txt;

}

add_action( 'dokan_render_settings_content', 'dokan_render_settings_content', 10 );

function dokan_render_settings_content( $query_vars ) {

	if ( isset( $query_vars['settings'] ) && $query_vars['settings'] == 'contractual' ) {

        ?>

<font color="red">Actualizat în 14-01-2022</font> Descarca / Vizualizeaza <a href="https://www.simplo.ro/raport-contractual/Conditii_de_utilizare_Simplo_.pdf" target="_blank"><i class="fa fa-download"></i>  Conditii de utilizare Simplo.pdf </a><br />

<font color="red">Actualizat în 01-01-2022</font> Descarca / Vizualizeaza <a href="https://www.simplo.ro/raport-contractual/Anexa_indicatori_de_performanta_.pdf" target="_blank"><i class="fa fa-download"></i>  Anexa indicatori de  performanta.pdf </a> <br />

<font color="red">Actualizat în 01-01-2022</font> Descarca / Vizualizeaza <a href="https://www.simplo.ro/raport-contractual/Anexa_GDPR_selleri.pdf" target="_blank"><i class="fa fa-download"></i>  Anexa GDPR selleri.pdf </a> <br />

        <?php

    }

}

/* OUT  Adding Settings extra menu in Settings tabs Dahsboard */





/* IN Adauga banner pentru mobil si pentru desktop marimi diferite  

add_action( 'woocommerce_after_single_product_summary', 'custom_text', 7 );

function custom_text() {

  print '  <a href="https://simplo.ro/?s=brad+artificial&dgwt-wcas-search-submit=&post_type=product&dgwt_wcas=1" ><picture>

  <source media="(min-width: 750px)"srcset="https://simplo.ro/wp-content/uploads/2020/11/oferta-brazi-de-craciun-2.jpg"  width="100%">

  <source media="(min-width: 465px)" srcset="https://simplo.ro/wp-content/uploads/2020/11/oferta-brazi-de-craciun-1.jpg">

  <img src="https://simplo.ro/wp-content/uploads/2020/11/oferta-brazi-de-craciun-1.jpg"><br>

</picture></a>';  

}

 OUT Adauga banner  pentru mobil si pentru desktop marimi diferite  */





/* IN Trimite email clientilor la Anularea si esuarea comenzii fara codul asta nu trimite email */

add_action('woocommerce_order_status_changed', 'send_custom_email_notifications', 10, 4 );

function send_custom_email_notifications( $order_id, $old_status, $new_status, $order ){

if ( $new_status == 'cancelled' || $new_status == 'failed' ){

$wc_emails = WC()->mailer()->get_emails(); // Get all WC_emails objects instances

$customer_email = $order->get_billing_email(); // The customer email

}

if ( $new_status == 'cancelled' ) {

// change the recipient of this instance

$wc_emails['WC_Email_Cancelled_Order']->recipient = $customer_email;

// Sending the email from this instance

$wc_emails['WC_Email_Cancelled_Order']->trigger( $order_id );

}

elseif ( $new_status == 'failed' ) {

// change the recipient of this instance

$wc_emails['WC_Email_Failed_Order']->recipient = $customer_email;

// Sending the email from this instance

$wc_emails['WC_Email_Failed_Order']->trigger( $order_id );

}

}

/* OUT Trimite email clientilor la Anularea si esuarea comenzii fara codul asta nu trimite email */









/* IN Adauga produsele upsell inainte de descrierea produsului( produsel UPsell se adauga in pagina fiecarui produs Editeaza produs > Date produs > Produse legate > Upsells)  */



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

 

// ---------------------------

// 2. Echo Upsells In Another Position

 

add_action( 'woocommerce_after_single_product_summary', 'bbloomer_woocommerce_output_upsells', 5 );

 

function bbloomer_woocommerce_output_upsells() {

woocommerce_upsell_display( 5,3 ); // Display max 5 products, 3 per row

}

/* OUT Adauga produsele upsell inainte de descrierea produsului( produsel UPsell se adauga in pagina fiecarui produs Editeaza produs > Date produs > Produse legate > Upsells)  */




/* IN Modifica numarul produselor (Upsell in pagina produsului)  */


add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );

  function jk_related_products_args( $args ) {

	$args['posts_per_page'] = 12; // 4 related products

	$args['columns'] = 2; // arranged in 2 columns

	return $args;

}

/* OUT Modifica numarul produselor (Upsell in pagina produsului)  */





/* IN Apare numarul de prodse in wishlist si in compare 

add_filter( 'electro_show_wishlist_count', '__return_true' );

add_filter( 'electro_show_compare_count', '__return_true' );

 Out Apare numarul de prodse in wishlist si in compare */





/* IN Nu arata cuponul daca este inscris in Vendor)  */

add_filter ('dokan_ensure_vendor_coupon', '__return_false');

/* OUT Nu arata cuponul daca este inscris in Vendor)  */

/* IN Sterge selectarea limbilor din sectiunea de administreare  */
add_filter( 'login_display_language_dropdown', '__return_false' );
/* OUT Sterge selectarea limbilor din sectiunea de administreare  */

/* IN Schimba imaginea de funadal cand nu e imagine adaugata  */

add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');



function custom_woocommerce_placeholder_img_src( $src ) {

  $upload_dir = wp_upload_dir();

  $uploads = untrailingslashit( $upload_dir['baseurl'] );

  // replace with path to your image

  $src = $uploads . '/2021/04/woocommerce-placeholder-300x300-1.png';

   

  return $src;

}

/* Iout Schimba imaginea de funadal cand nu e imagine adaugata  */





/* IN Arata imaginile produselor in administrare 

add_filter( 'manage_edit-shop_order_columns', 'admin_orders_list_add_column', 15, 1 );

function admin_orders_list_add_column( $columns ){

    $columns['custom_column'] = __( 'Imagini', 'woocommerce' );



    return $columns;

}



// The data of the new custom column in admin order list

add_action( 'manage_shop_order_posts_custom_column' , 'admin_orders_list_column_content', 15, 2 );

function admin_orders_list_column_content( $column, $post_id ){

    global $the_order;



    if( 'custom_column' === $column ){

        $count = 0;



        // Loop through order items

        foreach( $the_order->get_items() as $item ) {

            $product = $item->get_product(); // The WC_Product Object

            $style   = $count > 0 ? ' style="padding-left:6px;"' : '';

	



            // Display product thumbnail

            printf( '<span%s>%s</span>', $style, $product->get_image( array( 70, 70 ) ) );

	

			

			

			

            $count++;

        }

    }

}



 OUT Arata imaginile produselor in administrare */











/* IN Tine restranse taburile de la Descriere */



add_action( 'woocommerce_before_single_product', 'ec_child_wc_tabs_in_extended_view', 20 );



function ec_child_wc_tabs_in_extended_view() {

    $style  = electro_get_single_product_style();



    if ( 'extended' === $style ) {

        remove_action( 'woocommerce_after_single_product_summary', 'electro_output_product_data_tabs', 10 );

        add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

    }

}



/* OUT Tine restranse taburile de la Descriere  */



/* IN  Contacteaza vanzator */



add_action( 'woocommerce_single_product_summary', 'display_author_name', 12 );

function display_author_name() {

    // Get the author ID (the vendor ID)

    $vendor_id = get_post_field( 'post_author', get_the_id() );

    // Get the WP_User object (the vendor) from author ID

    $vendor = new WP_User($vendor_id);



    $store_info  = dokan_get_store_info( $vendor_id ); // Get the store data

    $store_name  = $store_info['store_name'];          // Get the store name

    $store_url   = dokan_get_store_url( $vendor_id );  // Get the store URL



    $vendor_name = $vendor->display_name;              // Get the vendor name

    $address     = $vendor->billing_address_1;           // Get the vendor address

    $postcode    = $vendor->billing_postcode;          // Get the vendor postcode

    $city        = $vendor->billing_city;              // Get the vendor city

    $state       = $vendor->billing_state;             // Get the vendor state

    $country     = $vendor->billing_country;           // Get the vendor country



    // Display the seller name linked to the store

    printf( '

	

	<br><i class="far fa-circle" style="color:green"></i>  Vândut și livrat de: <a href="%s"><u style="color:green;">%s</u></a>

	

', $store_url, $store_name );

}

/* OUT  Contacteaza vanzator */



/* IN Transforma SKU in Cond Produs  */



add_action( 'woocommerce_single_product_summary', 'electro_template_loop_product_sku',  12 );

function electro_template_loop_product_sku() {

    global $product;



    $sku = $product->get_sku();



    if ( empty( $sku ) ) {

        $sku = 'n/a';

    }



    ?>

    <div style="font-weight: bold;"><i class="far fa-circle" style="color:green"></i> <?php echo sprintf( esc_html__( 'Cod produs: %s', 'electro' ), $sku ); ?></div><?php

}

/* OUT Transforma SKU in Cond Produs  */





/* IN Adauga banner pentru mobil si pentru desktop marimi diferite  */

add_action( 'woocommerce_single_product_summary', 'custom_text', 20 );

function custom_text() {

  print ' 

  <br><br>

  <div style="border: 2px solid #ddd;

    border-radius: 1.214em;

    padding: 2.143em 2.357em;"> 

	<table width="100%" style="margin-top:-30px; margin-bottom:-20px;">

	<tr><td><i class="fas fa-gift"></i> <b>Inscrie-te in Newsletter:</b></td></tr>

	<table>

	<table width="100%" style="border-style: hidden; margin-bottom:-40px;">

	<tr>

	<td>

<!--<img src="https://simplo.ro/wp-content/uploads/2020/11/craciun.png">

<a href="https://simplo.ro/categorie-produs/sezonier/articole-craciun/page/3/" target="_blank" >

<p align="right"><b> <font color="green"> Vezi detalii</font></b></p></a></p>

	</td>-->

	

<td width="35%">

<img src="https://simplo.ro/wp-content/uploads/2021/04/cupon1.png">

</td>

<td width="65%"> <p style="margin-top: 10px;">	

<a href="https://simplo.ro/370133-2/" target="_blank" >

 Obține un cupon în valoare <br>de <b>20 lei, cadou</b>!



<p align="right"><b> <font color="green"> Vezi detalii</font></b></p></a></p>

 </td>

 </tr></table>

</div><br>



';  

}


 /*OUT Adauga banner  pentru mobil si pentru desktop marimi diferite  */







/**

 * @snippet       Scroll to tab - WooCommerce Single Product

 * @how-to        Get CustomizeWoo.com FREE

 * @author        Rodolfo Melogli

 * @compatible    WooCommerce 3.5.7

 * @donate $9     https://businessbloomer.com/bloomer-armada/

 */

 

add_action( 'woocommerce_after_add_to_cart_button', 'bbloomer_scroll_to_and_open_product_tab', 21 );

  

function bbloomer_scroll_to_and_open_product_tab() {

    

   global $post, $product;   

    

    

   // LINK TO SCROLL TO INTREBARE TAB

   if ( comments_open() ) {

      echo '<div class="xoo-wsc-ft-buttons-cont"><p type="submit" class="buton_contact">

	  <a class="jump-to-tab" href="#tab-seller_enquiry_form">' . __( '<b><i class="fas fa-mail-bulk"></i> Contacteaza Vanzator</b>', 'woocommerce' ) . '</a></p></div>';

   }

    

   ?>

      <script>

      jQuery(document).ready(function($){

         $('a.jump-to-tab').click(function(e){

            e.preventDefault();

            var tabhash = $(this).attr("href");

            var tabli = 'li.' + tabhash.substring(1);

            var tabpanel = '.panel' + tabhash;

            $(".wc-tabs li").each(function() {

               if ( $(this).hasClass("active") ) {

                  $(this).removeClass("active");

               }

            });

            $(tabli).addClass("active");

            $(".woocommerce-tabs .panel").css("display","none");

            $(tabpanel).css("display","block");

            $('html,body').animate({scrollTop:$(tabpanel).offset().top}, 750);

         });

      });

      </script>

   <?php

    

}





add_filter('the_content', 'do_shortcode');



// IN Display the product thumbnail in order view pages

add_filter( 'woocommerce_order_item_name', 'display_product_image_in_order_item', 20, 3 );

function display_product_image_in_order_item( $item_name, $item, $is_visible ) {

    // Targeting view order pages only

    if( is_wc_endpoint_url( 'view-order' ) ) {

        $product       = $item->get_product(); // Get the WC_Product object (from order item)

        $product_image = $product->get_image(array( 50, 50)); // Get the product thumbnail (from product object)

        $item_name     = '<div class="item-thumbnail">' . $product_image . '</div>' . $item_name;

    }

    return $item_name;

}



// IN adauga autoamat focus keywords

function update_focus_keywords() {

$posts = get_posts(array(

'posts_per_page' => 100,

'offset' => 900,

'post_type' => 'product' // Replace post with the name of your post type

));

foreach($posts as $p){

// Checks if Rank Math keyword already exists and only updates if it doesn’t have it

$rank_math_keyword = get_post_meta( $p->ID, 'rank_math_focus_keyword', true );

if ( ! $rank_math_keyword ){

update_post_meta($p->ID,'rank_math_focus_keyword',strtolower(get_the_title($p->ID)));

}

}

}

add_action( 'init', 'update_focus_keywords' );





// IN MODIFICA descrierea la produsele vechi



add_action( 'rank_math/frontend/description', function( $generated ) {

	if ( ! is_product() ) {

		return $generated;

	}



	global $post;

	$desc = RankMath\Helper::get_settings( "titles.pt_product_description" );

	$desc = RankMath\Helper::replace_vars( $desc, $post );

	return empty( $desc ) ? $generated : $desc;

});





/*   
//Adding Read More Button to excerpts

// Shorten product long descrition with read more button
function filter_the_content( $content ) {
    // Only for single product pages
    if( ! is_product() ) return $content;

    // Set the limit of words
    $limit = 100;
    
    // Strip p tags if needed
    $content = str_replace( array( '<p>', '</p>' ), '', $content );

    // If the content is longer than the predetermined limit
    if ( str_word_count( $content, 0 ) > $limit ) {
        // Returns an associative array, where the key is the numeric position of the word inside the string and the value is the actual word itself
        $arr = str_word_count( $content, 2 );
        
        // Return all the keys or a subset of the keys of an array
        $pos = array_keys( $arr );
        
        // First part
        $text = '<p>' . substr( $content, 0, $pos[$limit] ) . '<span id="dots">...</span>';
        
        // More part
        $text .= '<span id="more">' . substr( $content, $pos[$limit] ) . '</span></p>';
        
        // Read button
        $text .= '<button id="read-button"></button>';
        
        $content = force_balance_tags( $text ); // needded
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready( function ($) {
            // Settings
            var read_more_btn_txt = '<b>Vezi mai mult </b><i class="fas fa-chevron-down"></i>';
            var read_less_btn_txt = '<b>Vezi mai putin </b> <i class="fas fa-chevron-up"></i>';
            
            // Selectors
            var more = '#more';
            var read_button = '#read-button';
            var dots = '#dots';
            
            // On load
            $( more ).hide();
            $( read_button ).html( read_more_btn_txt );

            // On click
            $( read_button ).on( 'click', function() {
                if ( $( more ).is( ':hidden' ) ) {
                    $( more ).show();
                    $( dots ).hide();
                    $( read_button ).html( read_less_btn_txt );
                } else {
                    $( more ).hide();
                    $( dots ).show();
                    $( read_button ).html( read_more_btn_txt );
                }
            });

        });
    </script>
    <?php
    return $content;
}
add_filter( 'the_content', 'filter_the_content', 10, 1 );
*/


// shows the number of products published on the product category page

