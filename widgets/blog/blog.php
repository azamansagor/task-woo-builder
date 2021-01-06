<?php
/**
 * Elementor Blog Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Woo_Blog extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Woo_Blog widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'woo-blog';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Woo_Blog widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Woo Blog', 'woo-builder' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Woo_Blog widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-blog';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Woo_Blog widget belongs to.
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
	 * Register Woo_Blog widget controls.
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
			'post_column',
			[
				'label'   => esc_html__( 'Post Column', 'woo-builder' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'3'  => esc_html__( '4 Column ', 'turitor' ),
					'4'  => esc_html__( '3 Column', 'turitor' ),
					'6'  => esc_html__( '2 Column', 'turitor' ),
			
				],
			]
		);

		$this->add_control(
			'category',
			[
				'label'	=> __('Category', 'woo-builder'),
				'type'	=> \Elementor\Controls_Manager::SELECT2,
				'multiple'	=> true,
				'default'	=> [],
				'options'	=> $this->get_post_categories()
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => __( 'Title', 'woo-builder' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Title Color', 'woo-builder'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					 '{{WRAPPER}} .woo-blog .card-title a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
			  'label' => esc_html__( 'Margin', 'woo-builder' ),
			  'type' => \Elementor\Controls_Manager::DIMENSIONS,
			  'allowed_dimensions' => [ 'top', 'bottom' ],
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors' => [
				'{{WRAPPER}} .woo-blog .card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'desc_style_section',
			[
				'label' => __( 'Description', 'woo-builder' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'description_color',
			[
				'label' => esc_html__('Description Color', 'woo-builder'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					 '{{WRAPPER}} .woo-blog .card-text' => 'color: {{VALUE}};',
				],
			]
		   );

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => __( 'Content', 'woo-builder' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'content_border_radius',
			[
			  'label' => esc_html__( 'Border Radius', 'woo-builder' ),
			  'type' => \Elementor\Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors' => [
				'{{WRAPPER}} .card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render Woo_Blog widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$category   = $settings["category"];
		$post_column = $settings["post_column"];

		
		$args = array(
			'numberposts'      => 5,
			'orderby'          => 'post_date',
			// 'order'            => $post_sort_by,
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'suppress_filters' => true
		);

		if(is_array($category)){
			$args['category__in'] = $category;
		 }


		$posts = get_posts( $args );
		
		 $template = __DIR__ . '/templates/style-1.php';

		if( file_exists($template)){
			include  __DIR__ . '/templates/style-1.php';
		}
    	wp_reset_postdata();

	}


	public function get_post_categories(){
		$terms = get_terms(
			array(
				'taxonomy'	=> 'category',
				'hide_empty'	=> false,
				'posts_per_page'	=> -1
			)
		);

		$category_list = array();

		foreach($terms as $category){
			$category_list[$category->term_id] = [$category->name];
		}
		return $category_list;
	}

}