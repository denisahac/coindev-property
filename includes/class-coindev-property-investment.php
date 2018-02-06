<?php
/**
 * Registers the investment custom post type.
 * 
 * @package CoinDev_Property
 * @subpackage CoinDev_Property/includes
 * @since 1.0
 * @author Den Isahac <den.isahac@gmail.com>
 */
class CoinDev_Property_Investment {

	/**
	 * Meta data fields.
	 *
	 * @since 1.0
	 * @access private
	 */
	private $fields = [
		'address1',
		'address2',
		'price',
		'currentnoi',
		'caprate',
		'landarea',
		'leasetype',
		'propertytype',
		'propertylease',
		'combinded',
		'remainingterms',
		'loansummary',
		'loanfunded',
		'propertyvalue',
		'loanamount',
		'ltv',
		'periodfrom',
		'downpayment',
		'lessannualdebt',
		'interestrate',
		'cashflow',
		'terms',
		'cashflowpercent',
		'amortization',
		'locationdescription',
		'tenantbrief',
		'property_desc',
		'payment'
	];

	/**
	 * Class instantiation method.
	 *
	 * @since 1.0
	 */
	function __construct() {
		add_action('init', [$this, 'create']);
		add_action('init', [$this, 'remove_comments']);
		add_action('add_meta_boxes_investment', [$this, 'meta_boxes']);
		add_action('save_post', [$this, 'save_meta'], 10, 2);
	}

	/**
	 * Registers the custom post type `investment` using the `register_post_type` method.
	 * 
	 * @since 1.0
	 */
	function create() {

		register_post_type(
			'investment',

			array(
				'label' => __('Investments', 'coindev_property'),
				'labels' => array(
					'name' => __('Investments', 'coindev_property'),
					'singular_name' => __('Investment', 'coindev_property'),
					'menu_name' => __('Investments', 'coindev_property'),
					'name_admin_bar' => __('Investment', 'coindev_property'),
					'add_new' => __('Add New', 'coindev_property'),
					'add_new_item' => __('Add New Investment', 'coindev_property'),
					'new_item' => __('New Investment', 'coindev_property'),
					'edit_item' => __('Edit Investment', 'coindev_property'),
					'view_item' => __('View Investment', 'coindev_property'),
					'all_items' => __('All Investments', 'coindev_property'),
					'search_items' => __('Search Investments', 'coindev_property'),
					'parent_item_colon' => __('Parent Investments:', 'coindev_property'),
					'not_found' => __('No Investments found.', 'coindev_property'),
					'not_found_in_trash' => __('No Investments found in Trash.', 'coindev_property')
				),

				'public' => true,

				'public_queryable' => true,

				'show_ui' => true,

				'show_in_menu' => true,

				'query_var' => true,

				'rewrite' => array(
					'slug' => 'loans'
				),

				'capability_type' => 'post',

				'has_archive' => true,

				'hierarchical' => false,

				'menu_position' => null,

				'menu_icon' => 'dashicons-store',

				'supports' => array(
					'title',
					'thumbnail'
				)
			)
		);
	}

	/**
	 * Remove comments.
	 *
	 * @since 1.0
	 */
	function remove_comments() {
		remove_post_type_support('investment', 'comments');
	}

	/**
	 * Custom meta boxes.
	 *
	 * @since 1.0
	 * @param WP_Post $investment The current post object.
	 */
	function meta_boxes($investment) {
		// Address 1
		add_meta_box(
			'investment_address1',
			__('Address 1', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'address1'
			]
		);

		// Address 2
		add_meta_box(
			'investment_address2',
			__('Address 2', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'address2'
			]
		);

		// Price
		add_meta_box(
			'investment_price',
			__('Price', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'price'
			]
		);

		// Current NOI
		add_meta_box(
			'investment_currentnoi',
			__('Current NOI', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'currentnoi'
			]
		);

		// Capital Rate
		add_meta_box(
			'investment_caprate',
			__('Capital Rate %', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'caprate'
			]
		);

		// Land Area
		add_meta_box(
			'investment_landarea',
			__('Land Area (Acre)', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'landarea'
			]
		);

		// Lease Type
		add_meta_box(
			'investment_leasetype',
			__('Lease Type', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'leasetype'
			]
		);

		// Property Type
		add_meta_box(
			'investment_propertytype',
			__('Property Type', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'propertytype'
			]
		);

		// Property Lease
		add_meta_box(
			'investment_propertylease',
			__('Property Lease', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'propertylease'
			]
		);

		// Combined Building Size (Square Foot)
		add_meta_box(
			'investment_combinded',
			__('Combined Building Size (Square Foot)', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'combinded'
			]
		);

		// Remaining Term (Year)
		add_meta_box(
			'investment_remainingterms',
			__('Remaining Terms (Year)', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'remainingterms'
			]
		);

		// Loan Summary
		add_meta_box(
			'investment_loansummary',
			__('Loan Summary', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'loansummary'
			]
		);

		// Loan Funded
		add_meta_box(
			'investment_loanfunded',
			__('Loan Funded', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'loanfunded'
			]
		);

		// Property Value
		add_meta_box(
			'investment_propertyvalue',
			__('Property Value', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'propertyvalue'
			]
		);

		// Loan Amount
		add_meta_box(
			'investment_loanamount',
			__('Loan Amount', 'coindev_property'), 
			[$this, 'textfield_meta'], 
			null, 
			'normal', 
			'low', 
			[
			 	'field' => 'loanamount'
			]
		);

		// LTV
		add_meta_box(
			'investment_ltv',
			__('LTV %', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'ltv'
			]
		);

		// Period From
		add_meta_box(
			'investment_periodfrom',
			__('Period From', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'periodfrom'
			]
		);

		// Down Payment
		add_meta_box(
			'investment_downpayment',
			__('Down Payment', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'downpayment'
			]
		);

		// Less Annual Debt.
		add_meta_box(
			'investment_lessannualdebt',
			__('Less Annual Debt.', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'lessannualdebt'
			]
		);

		// Interest Rate
		add_meta_box(
			'investment_interestrate',
			__('Interest Rate', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'interestrate'
			]
		);

		// Cash Flow
		add_meta_box(
			'investment_cashflow',
			__('Cash Flow', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'cashflow'
			]
		);

		// Fixed Terms
		add_meta_box(
			'investment_terms',
			__('Fixed Terms', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'terms'
			]
		);

		// Cash Flow Percent
		add_meta_box(
			'investment_cashflowpercent',
			__('Cash Flow Percent', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'cashflowpercent'
			]
		);

		// Amortization
		add_meta_box(
			'investment_amortization',
			__('Amortization', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'amortization'
			]
		);

		// Location Description
		add_meta_box(
			'investment_locationdescription',
			__('Location Descripton', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'locationdescription',
				'type' => 'textarea'
			]
		);

		// Highlights
		add_meta_box(
			'investment_tenantbrief',
			__('Highlights', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'tenantbrief',
				'type' => 'textarea'
			]
		);

		// Property Description
		add_meta_box(
			'investment_property_desc',
			__('Property Description', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'property_desc',
				'type' => 'textarea'
			]
		);

		// Payment
		add_meta_box(
			'investment_payment',
			__('Payment', 'coindev_property'),
			[$this, 'textfield_meta'],
			null,
			'normal',
			'low',
			[
				'field' => 'payment',
			]
		);
	}

	/**
	 * Custom meta boxes.
	 *
	 * @since 1.0
	 * @param WP_Post $post The current post object.
	 * @param array $metabox Argument array.
	 */
	function textfield_meta($post, $metabox) {
		// Current field.
		$field = $metabox['args']['field'];

		// Test if current field is in the fields array.
		if(in_array($field, $this->fields)) {

			// Post ID.
			$post_id = $post->ID;
			// Prepend underscore to the field to form the meta key.
			$meta_key = '_' . $field; 
			// Get the meta value.
			$meta_value = get_post_meta($post_id, $meta_key, true);

			// Nonce to veriry the source of data.
			$nonce_key = $field . '_nonce'; // The nonce key.
			$nonce = wp_create_nonce($nonce_key);

			?>
			<input 
				id="<?php echo $nonce_key; ?>"
				name="<?php echo $nonce_key; ?>"
				type="hidden"
				value="<?php echo $nonce; ?>"/>
			
			<?php if(array_key_exists('type', $metabox['args']) && $metabox['args']['type'] === 'textarea') : ?>
				<textarea
					id="<?php echo $field; ?>"
					class="textarea-field"
					name="<?php echo $field; ?>"
					rows="10"><?php echo $meta_value; ?>		
				</textarea>

			<?php else : ?>
				<input 
					id="<?php echo $field; ?>"
					class="text-field"
					name="<?php echo $field; ?>"
					type="text"
					value="<?php echo $meta_value; ?>"/>
			<?php endif;
		}
	}

	/**
	 * Save the custom meta data to the database.
	 *
	 * @since 1.0
	 * @param int $id The custom post type ID.
	 * @param WP_POST $investment The current post object.
	 */
	function save_meta($id, $investment) {
		// Check if the current user cannot edit the data, then, return.
		if(!current_user_can('edit_post', $id)) return;

		// If this is not an `investment` post type, don't proceed.
		if(get_post_type($id) !== 'investment') return;

		// Proceed and update meta data.
		foreach ($this->fields as $field) {
			$meta_key = '_' . $field; // Meta key.
			$nonce_key = $field . '_nonce'; // Nonce key.

			// Verify current field and its corresponding nonce
			if(isset($_POST[$field]) && isset($_POST[$nonce_key]) && wp_verify_nonce($_POST[$nonce_key], $nonce_key)) {
				update_post_meta($id, $meta_key, sanitize_text_field($_POST[$field]));
			}
		}
	}
}
