<?php
class Elementor_Similar_Products_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'similar_products';
    }

    public function get_title() {
        return __( 'Produits Similaires', 'plugin-name' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title control has been removed.

        $this->end_controls_section();
    }

    protected function render() {
        global $post;
        if ( ! $post ) {
            return;
        }

        $product = wc_get_product( $post->ID );
        if ( ! $product ) {
            return;
        }

        $terms = wp_get_post_terms( $product->get_id(), 'product_cat' );
        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return;
        }

        $term_ids = wp_list_pluck( $terms, 'term_id' );

        $args = [
            'post_type' => 'product',
            'posts_per_page' => 4,
            'post__not_in' => [ $product->get_id() ],
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $term_ids,
                    'operator' => 'IN',
                ],
            ],
        ];

        $similar_products = new WP_Query( $args );

        if ( $similar_products->have_posts() ) {
            // Add custom CSS for ul.similar-products
            echo '<style>
                    ul.similar-products {   
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                        gap: 16px;
                        list-style-type: none;
                        padding: 0;
                    }                    
                  </style>';

            echo '<ul class="similar-products">'; 
            while ( $similar_products->have_posts() ) {
                $similar_products->the_post();                
                wc_get_template_part( 'content', 'product' );                
            }
            echo '</ul>';

            wp_reset_postdata();
        }
    }
}

