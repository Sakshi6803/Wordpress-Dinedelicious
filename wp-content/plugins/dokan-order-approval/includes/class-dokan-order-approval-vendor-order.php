<?php
/**
 * New Vendor Pre Order Notification Email.
 *
 * An email sent to the vendor when a new order is pre-ordered for.
 *
 * @class       VendorNewOrder
 * @since       1.0.3
 * @author      Sevengits
 * @extends     WC_Email
 */
class SG_Vendor_PreOrder extends WC_Email {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->id             = 'sg_vendor_new_order';
        $this->title          = __( 'Vendor Pre Order Notification', 'dokan-order-approval' );
        $this->description    = __( 'New order emails are sent to chosen recipient(s) when a new order is received.', 'dokan-order-approval' );
        // Template paths.
		$this->template_html  = 'emails/vendor-new-preorder.php';
		$this->template_plain = 'emails/plain/vendor-new-preorder.php';
		if( file_exists(get_stylesheet_directory().'/woocommerce/'.$this->template_html) ){
			$this->template_base  = get_stylesheet_directory().'/woocommerce/';
		}elseif(file_exists(get_stylesheet_directory().'/woocommerce/'.$this->template_plain)){
			$this->template_base  = get_stylesheet_directory().'/woocommerce/';
		}else{
			$this->template_base  = SGDOA_PLUGIN_PATH . 'templates/';
		}
		
        $this->placeholders   = array(
            '{site_title}'   => $this->get_blogname(),
            '{order_date}'   => '',
            '{order_number}' => '',
        );

       		//Prevent admin email for sub-order
        add_filter( 'woocommerce_email_enabled_new_order', [ $this, 'prevent_sub_order_admin_email' ], 10, 2 );
        // Call parent constructor.
        parent::__construct();

        // Other settings.
        $this->recipient = 'vendor@ofthe.product';
    }

    /**
     * Get email subject.
     *
     * @since  3.1.0
     * @return string
     */
    public function get_default_subject() {
        return __( '[{site_title}] New customer order ({order_number}) - {order_date}', 'dokan-order-approval' );
    }

    /**
     * Get email heading.
     *
     * @since  3.1.0
     * @return string
     */
    public function get_default_heading() {
        return __( 'New Customer Order: #{order_number}', 'dokan-order-approval' );
    }

    /**
     * Trigger the sending of this email.
     *
     * @param int $order_id The Order ID.
     * @param array $order.
     */
    public function trigger( $order_id, $order = false ) {
        if ( ! $this->is_enabled() ) {
            return;
        }

        $this->setup_locale();
        if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
            $order = wc_get_order( $order_id );
        }

        if ( is_a( $order, 'WC_Order' ) ) {
            $this->object                         = $order;
            $this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
            $this->placeholders['{order_number}'] = $this->object->get_order_number();
        }

        $sellers = dokan_get_seller_id_by_order( $order_id );
        if ( empty( $sellers ) ) {
            return;
        }

        // check has sub order
        if ( $order->get_meta( 'has_sub_order' ) ) {
        	foreach ( $sellers as $seller ) {
        		$seller_info      = get_userdata( $seller );
		        $seller_email     = $seller_info->user_email;
		        $this->order_info = dokan_get_vendor_order_details( $order_id, $seller );
			    $this->send( $seller_email, $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
        	}
        } else {
        	$seller_info      = get_userdata( $sellers );
		    $seller_email     = $seller_info->user_email;
        	$this->order_info = dokan_get_vendor_order_details( $order_id, $sellers );
	        $this->send( $seller_email, $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
        }
        $this->restore_locale();
    }

    /**
     * Get content html.
     *
     * @access public
     * @return string
     */
    public function get_content_html() {
        return wc_get_template_html(
            $this->template_html, array(
                'order'         => $this->object,
                'email_heading' => $this->get_heading(),
                'sent_to_admin' => true,
                'plain_text'    => false,
                'email'         => $this,
                'order_info'    => $this->order_info,
            ), $this->template_base, $this->template_base
        );
    }

    /**
     * Get content plain.
     *
     * @access public
     * @return string
     */
    public function get_content_plain() {
        return wc_get_template_html(
            $this->template_plain, array(
                'order'         => $this->object,
                'email_heading' => $this->get_heading(),
                'sent_to_admin' => true,
                'plain_text'    => true,
                'email'         => $this,
                'order_info'    => $this->order_info,
            ), $this->template_base, $this->template_base
        );
    }

    /**
     * Initialise settings form fields.
     */
    public function init_form_fields() {
        $this->form_fields = array(
            'enabled'    => array(
                'title'   => __( 'Enable/Disable', 'dokan-order-approval' ),
                'type'    => 'checkbox',
                'label'   => __( 'Enable this email notification', 'dokan-order-approval' ),
                'default' => 'yes',
            ),
            'subject'    => array(
                'title'       => __( 'Subject', 'dokan-order-approval' ),
                'type'        => 'text',
                'desc_tip'    => true,
                /* translators: %s: list of placeholders */
                'description' => sprintf( __( 'Available placeholders: %s', 'dokan-order-approval' ), '<code>{site_title}, {order_date}, {order_number}</code>' ),
                'placeholder' => $this->get_default_subject(),
                'default'     => '',
            ),
            'heading'    => array(
                'title'       => __( 'Email heading', 'dokan-order-approval' ),
                'type'        => 'text',
                'desc_tip'    => true,
                /* translators: %s: list of placeholders */
                'description' => sprintf( __( 'Available placeholders: %s', 'dokan-order-approval' ), '<code>{site_title}, {order_date}, {order_number}</code>' ),
                'placeholder' => $this->get_default_heading(),
                'default'     => '',
            ),
            'email_type' => array(
                'title'       => __( 'Email type', 'dokan-order-approval' ),
                'type'        => 'select',
                'description' => __( 'Choose which format of email to send.', 'dokan-order-approval' ),
                'default'     => 'html',
                'class'       => 'email_type wc-enhanced-select',
                'options'     => $this->get_email_type_options(),
                'desc_tip'    => true,
            ),
        );
    }

    /**
     * Prevent sub-order email for admin
     *
     * @param $bool
     * @param $order
     *
     * @return bool
     */
    public function prevent_sub_order_admin_email( $bool, $order ) {
        if ( ! $order ) {
            return $bool;
        }

        if ( $order->get_parent_id() ) {
            return false;
        }

        return true;
    }
}
