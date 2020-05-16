<?php
/**
 * Off canvas menu.
 *
 * @package Potter
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="potter-container potter-container-center potter-visible-large potter-nav-wrapper potter-menu-right potter-menu-offcanvasnav">

	<div class="potter-grid potter-grid-collapse">

		<div class="potter-1-4 potter-logo-container">

			<?php get_template_part( 'inc/template-parts/logo/logo' ); ?>

		</div>
		<div class="potter-3-4 potter-menu-container off-canvas-nav-containe-right">
			<nav id="navigation" class="potter-clearfix" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php esc_attr_e( 'Site Navigation', 'potter' ); ?>">
					<?php
					wp_nav_menu(array(
							'theme_location' => 'main_menu',
							'container'      => false,
							'menu_class'     => 'potter-menu',
							'depth'          => 3,
					));
				?>
			</nav>
			<div class="potter-menu-toggle-container">
				<?php do_action( 'potter_before_menu_toggle' ); ?>
				<button id="potter-menu-toggle" class="potter-nav-item potter-menu-toggle potterf potterf-hamburger" aria-label="<?php esc_attr_e( 'Site Navigation', 'potter' ); ?>" aria-controls="navigation" aria-expanded="false" aria-haspopup="true">
					<span class="screen-reader-text"><?php _e( 'Menu Toggle', 'potter' ); ?></span>
				</button>
				<?php do_action( 'potter_after_menu_toggle' ); ?>
			</div>
		</div>
	</div>
</div>
