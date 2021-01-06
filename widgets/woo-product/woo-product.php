<?php
/**
 * Elementor Blog Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Woo_Product extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'woo-product';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Woo Product', 'woo-builder' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-shopping-bag';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'woo-builder' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Settings', 'woo-builder' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'wc_product',
			[
				'label'	=> __('Select Product', 'woo-builder'),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'multiple'	=> true,
				'default'	=> [],
				'options'	=> $this->get_post_categories()
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$wc_product   = $settings["wc_product"];
		
		global $product;
		// $product = wc_get_product($wc_product);

		// wc_get_template_part( 'content', 'single-product' );
		$params = array(
			'p' => $wc_product,
			'post_type' => 'product',
			'posts_per_page'	=> 1
		   );
		$wc_query = new WP_Query($params); 
		if($wc_query->have_posts()){
			while($wc_query->have_posts()){
				$wc_query->the_post();
				wc_get_template_part( 'content', 'single-product' );
			}
			wp_reset_postdata();
		}
		

	}


	public function get_post_categories(){
		$args = array(
			'status' => 'publish',
		);
		$products = wc_get_products($args);

		$products_list = array();

		foreach($products as $product){
			$products_list[$product->get_id()] = [$product->get_name()];
		}
		return $products_list;
	}

}