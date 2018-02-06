<?php 
/**
 * functions.php equivalent for WP plugins.
 *
 * @package CoinDev_Property
 * @since 1.0
 * @author Den Isahac <den.isahac@gmail.com>
 */

/**
 * Add support for thumbnail to `investment` post type.
 *
 * @since 1.0
 */
add_theme_support('post-thumbnails', array('investment'));

/**
 * Flush rewrite for our custom post type.
 *
 * @since 1.0
 */
function coindev_property_flush_rules() {
	flush_rewrite_rules();
}


/**
 * Filter for investment post type.
 *
 * @since 1.0
 * @param WP_Query $query the instance of the WP_Query
 */
function coindev_property_pre_get_posts($query) {
	// validate the proper query target
	if(!is_admin() && $query->is_main_query() && is_post_type_archive('investment')) {
		$orderby = $query->get('orderby');
		$meta_key = $query->get('meta_key');
		$meta_query = $query->get('meta_query');
		$s = $query->get('s');

		$q = isset($_GET['q']) ? $_GET['q'] : '';
		$leasetype = isset($_GET['_leasetype']) ? $_GET['_leasetype'] : null;
		$propertytype = isset($_GET['_propertytype']) ? $_GET['_propertytype'] : null;

		# interest rate (_interestrate)
		$min_interest_rate = isset($_GET['min_interest_rate']) ? $_GET['min_interest_rate'] : '';
    $max_interest_rate = isset($_GET['max_interest_rate']) ? $_GET['max_interest_rate'] : '';

    if(!empty($min_interest_rate) && !empty($max_interest_rate)) {
    	$meta_query[] = coindev_property_create_query_range('_interestrate', $min_interest_rate, $max_interest_rate);
    }

    # fixed term (_terms)
    $min_fixed_term = isset($_GET['min_fixed_term']) ? $_GET['min_fixed_term'] : '';
    $max_fixed_term = isset($_GET['max_fixed_term']) ? $_GET['max_fixed_term'] : '';

    if(!empty($min_fixed_term) && !empty($max_fixed_term)) {
			$meta_query[] = coindev_property_create_query_range('_terms', $min_fixed_term, $max_fixed_term);
    }

    # amortization (_amortization)
    $min_amortization = isset($_GET['min_amortization']) ? $_GET['min_amortization'] : '';
    $max_amortization = isset($_GET['max_amortization']) ? $_GET['max_amortization'] : '';

    if(!empty($min_amortization) && !empty($max_amortization)) {
    	$meta_query[] = coindev_property_create_query_range('_interestrate', $min_interest_rate, $max_interest_rate);
    }

    # loan amount (_loanamount)
    $min_loan_amount = isset($_GET['min_loan_amount']) ? $_GET['min_loan_amount'] : '';
    $max_loan_amount = isset($_GET['max_loan_amount']) ? $_GET['max_loan_amount'] : '';

    if(!empty($min_loan_amount) && !empty($max_loan_amount)) {
    	$meta_query[] = coindev_property_create_query_range('_loanamount', $min_loan_amount, $max_loan_amount);
    }

    # payment (_payment)
    $min_payment = isset($_GET['min_payment']) ? $_GET['min_payment'] : '';
    $max_payment = isset($_GET['max_payment']) ? $_GET['max_payment'] : '';

    if(!empty($min_payment) && !empty($max_payment)) {
    	$meta_query[] = coindev_property_create_query_range('_payment', $min_payment, $max_payment);
    }

    # building size (_combinded)
    $min_building_size = isset($_GET['min_building_size']) ? $_GET['min_building_size'] : '';
    $max_building_size = isset($_GET['max_building_size']) ? $_GET['max_building_size'] : '';

    if(!empty($min_building_size) && !empty($max_building_size)) {
    	$meta_query[] = coindev_property_create_query_range('_combinded', $min_building_size, $max_building_size);
    }

    # loan to value ()
    $min_ltv = isset($_GET['min_ltv']) ? $_GET['min_ltv'] : '';
    $max_ltv = isset($_GET['max_ltv']) ? $_GET['max_ltv'] : '';

    if(!empty($min_ltv) && !empty($max_ltv)) {
    	$meta_query[] = coindev_property_create_query_range('_ltv', $min_ltv, $max_ltv);	
    }

    # current net operating income (_currentnoi)
    $min_noi = isset($_GET['min_noi']) ? $_GET['min_noi'] : '';
    $max_noi = isset($_GET['max_noi']) ? $_GET['max_noi'] : '';

    if(!empty($min_noi) && !empty($max_noi)) {
    	$meta_query[] = coindev_property_create_query_range('_currentnoi', $min_noi, $max_noi);	
    }

    # capital rate (_caprate)
    $min_capital_rate = isset($_GET['min_capital_rate']) ? $_GET['min_capital_rate'] : '';
    $max_capital_rate = isset($_GET['max_capital_rate']) ? $_GET['max_capital_rate'] : '';

    if(!empty($min_capital_rate) && !empty($max_capital_rate)) {
  		$meta_query[] = coindev_property_create_query_range('_caprate', $min_capital_rate, $max_capital_rate);
    }

    # land area (_landarea`)
    $min_land_area = isset($_GET['min_land_area']) ? $_GET['min_land_area'] : '';
    $max_land_area = isset($_GET['max_land_area']) ? $_GET['max_land_area'] : '';

    if(!empty($min_land_area) && !empty($max_land_area)) {
			$meta_query[] = coindev_property_create_query_range('_landarea', $min_land_area, $max_land_area);
    }

    # remaining terms (_remainingterms)
    $min_remaining_terms = isset($_GET['min_remaining_terms']) ? $_GET['min_remaining_terms'] : '';
    $max_remaining_terms = isset($_GET['max_remaining_terms']) ? $_GET['max_remaining_terms'] : '';

    if(!empty($min_remaining_terms) && !empty($max_remaining_terms)) {
			$meta_query[] = coindev_property_create_query_range('_remainingterms', $min_remaining_terms, $max_remaining_terms);
    }

		$order = isset($_GET['order']) ? $_GET['order'] : null;

		// filter
		// ------

		if(!empty($q)) {
			// $s = $q;

			$meta_query[] = array(
				'meta_query' => array(
				 	'relation' => 'OR',
					coindev_property_create_meta_arr('title', $address, 'LIKE'),
					coindev_property_create_meta_arr('_address1', $address, 'LIKE'),
					coindev_property_create_meta_arr('_address2', $address, 'LIKE'),
					coindev_property_create_meta_arr('_locationdescription', $address, 'LIKE'),
					coindev_property_create_meta_arr('_tenantbrief', $address, 'LIKE'),
					coindev_property_create_meta_arr('_property_desc', $address, 'LIKE')
				)
			);
		}

		# filter: _leasetype
		if(!empty($leasetype)) {
			$meta_query[] = coindev_property_create_meta_arr('_leasetype', $leasetype, '=');
		}

		# filter: _propertytype
		if(!empty($propertytype)) {
			$meta_query[] = coindev_property_create_meta_arr('_propertytype', $propertytype, '=');
		}

		// ordering
		if($order == null || $order == 'date') {
			$orderby = 'date';
		} else {
			$orderby = 'meta_value_num';
			$meta_key = $order;
		}

		// update orderby statement
		$query->set('orderby', $orderby);
		$query->set('meta_key', $meta_key);
		$query->set('meta_query', $meta_query);
		$query->set('s', $s);
	}
}
add_action('pre_get_posts', 'coindev_property_pre_get_posts');

/**
 * Create an array using the supplied parameter as a key-value pair.
 *
 * @since 1.0
 * @param String $key
 * @param String $value
 * @param String $comparator
 * @return array The constructed array.
 */
function coindev_property_create_meta_arr($key, $value, $comparator = '=') {
	return array(
		'key' => $key,
		'value' => $value,
		'compare' => $comparator
	);
}

/**
 * Meta query for comparing values in range.
 *
 * @since 1.0
 * @param string $key
 * @param float $min The minimum value.
 * @param float $max The maximum value.
 * @return array The constructed array.
 */
function coindev_property_create_query_range($key, $min, $max) {
	return coindev_property_create_meta_arr2($key, array($min, $max), 'DECIMAL', 'BETWEEN');
}

/**
 * Create an array using the supplied parameter as a key-value pair.
 *
 * @since 1.0
 * @param String $key
 * @param String $value
 * @param String $type
 * @param String $comparator
 * @param array The constructed array.
 */
function coindev_property_create_meta_arr2($key, $value, $type, $comparator = '=') {
	return array(
		'key' => $key,
		'value' => $value,
		'type' => $type,
		'compare' => $comparator
	);
}


/**
 * Get all the investment options as an multi-dimensional array.
 * 
 * @since 1.0
 * @return Array $properties
 */
function coindev_property_investment_properties() {
	$properties = array(
		'lease_types' => array(), 
		'property_types' => array(),
		'property_leases' => array()
	);

	$args = array(
		'post_type' => 'investment',
		'posts_per_page' => -1,
	); // WP_Query arguments

	$investments = new WP_Query($args); // retrieve the list of investments as per arguments

	if($investments->have_posts()) {
		while($investments->have_posts()) {
			$investments->the_post();

			$lease_type = get_post_meta(get_the_ID(), '_leasetype', true);
			$property_type = get_post_meta(get_the_ID(), '_propertytype', true);
			$property_lease = get_post_meta(get_the_ID(), '_propertylease', true);

			if(!empty($lease_type) && !in_array($lease_type, $properties['lease_types']))
				array_push($properties['lease_types'], $lease_type);

			if(!empty($property_type) && !in_array($property_type, $properties['property_types']))
				array_push($properties['property_types'], $property_type);

			if(!empty($property_lease) && !in_array($property_lease, $properties['property_leases']))
				array_push($properties['property_leases'], $property_lease);
		}
	}

	wp_reset_postdata(); // reset the global $post variable

	return $properties;
}

/**
 * Echo `active` if the $key content is the same with the $value.
 *
 * @since 1.0
 * @param String $key
 * @param String $value
 */
function sort_active($key, $value) {
	if(strtolower($key) === strtolower($value)) {
		echo 'active';
	}
}

/**
 * Shorthand for isset() and $_GET.
 *
 * @since 1.0
 * @param String $param the parameter
 * @return String the value of the query string
 */
function shrthnd_get($param) {
	if(isset($_GET[$param])){
		return $_GET[$param];
	} else {
		return '';
	}
}

/**
 * Convert dollar string number to float value; removing the dollar sign.
 *
 * @since 1.0
 * @param string $amount The amount in string format.
 * @return float The converted value.
 */
function float_to_dllr_str($amount) {
	$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
	$curr = 'USD';

	$float_amount = floatval($formatter->parseCurrency($amount, $curr));
	
	return $float_amount;
}

/**
 * Convert string to number.
 * 
 * @since 1.0
 * @param string str The string to convert.
 * @return int the converted value.
 */
function convert_str($str) {
	return to_float($str);
}

/**
 * Test the value if it exists and not empty.
 *
 * @since 1.0
 * @param object $obj
 * @return $obj
 */
function new_value($obj) {
	if(isset($obj) && !empty($obj)) return convert_str($obj);

	return 0;
}

/**
 * This function takes the last comma or dot (if any) to make a clean float, 
 * ignoring thousand separator, currency or any other letter
 *
 * @since 1.0
 * @see http://php.net/manual/en/function.floatval.php#114486
 * @param string $num The string to convert
 * @return float The converted number
 */
function to_float($num) {
    return (double) filter_var($num, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/**
 * Format investments post type data.
 *
 * @since 1.0
 */
function coindev_property_format_investments() {
	// WP_Query args
	$args = array(
		'post_type' => 'investment',
		'posts_per_page' => -1
	);

	$investments = new WP_Query($args);

	if($investments->have_posts()) {
		while($investments->have_posts()) {
			$investments->the_post();

			// Load to Value
			$ltv = get_post_meta(get_the_ID(), '_ltv', true);
			$new_ltv = new_value($ltv);
			if($new_ltv != 0) update_post_meta(get_the_ID(), '_ltv', $new_ltv, $ltv);

			// Interest Rate
			$interest_rate = get_post_meta(get_the_ID(), '_interestrate', true);
			$new_interest_rate = new_value($interest_rate);
			if($new_interest_rate !=0) update_post_meta(get_the_ID(), '_interestrate', $new_interest_rate, $interest_rate);

			// Capital Rate
			$capital_rate = get_post_meta(get_the_ID(), '_caprate', true);
			$new_capital_rate = new_value($capital_rate);
			if($new_capital_rate !=0) update_post_meta(get_the_ID(), '_caprate', $new_capital_rate, $capital_rate);

			// Remaining Terms
			$remaining_terms = get_post_meta(get_the_ID(), '_remainingterms', true);
			$new_remaining_terms = new_value($remaining_terms);
			if(strpos($remaining_terms, 'Approx') < 0 && $new_remaining_terms != 0) update_post_meta(get_the_ID(), '_remainingterms', $new_remaining_terms, $remaining_terms);

			// Building Size
			$building_size = get_post_meta(get_the_ID(), '_combinded', true);
			$new_building_size = new_value($building_size);
			if($new_building_size < 1) update_post_meta(get_the_ID(), '_combinded', $new_building_size, $building_size);

			// Land Area
			$land_area = get_post_meta(get_the_ID(), '_landarea', true);
			$new_land_area = new_value($land_area);
			if($new_land_area != 0) update_post_meta(get_the_ID(), '_landarea', $new_land_area, $land_area);
		}
	}
}
add_action('after_switch_theme', 'coindev_property_format_investments');


/**
 * The search filter.
 *
 * @since 1.0
 */
function coindev_property_search_filter() {
	$properties = coindev_property_investment_properties();

	$investment_url = get_post_type_archive_link('investment');

	if(is_post_type_archive('investment')) 
		$investment_url = $_SERVER['REQUEST_URI'];
	?>
	<section class="filter">
	  <h2 class="hide"><?php _e('Filter Options', 'coindev_property'); ?></h2>

	  <form class="form form--filter" method="get" action="<?php echo $investment_url; ?>">
	    <div class="form__header">
	      <div class="form__group form__group--search">
	        <?php 
	        $q = isset($_GET['q']) ? $_GET['q'] : '';
	        ?>
	        <label for="q">
	          <input id="q" name="q" type="text" placeholder="<?php _e('Search', 'coindev_property'); ?>" value="<?php echo $q; ?>">
	        </label>

	        <button id="search" name="search" class="button button--search" type="submit">
	          <i class="dashicons dashicons-search"></i>
	        </button>
	      </div>

	      <a class="button button--more js-more" href="#more">
	        <i class="dashicons dashicons-chart-bar"></i> 
	        <?php _e('Filter', 'coindev_property'); ?>
	      </a>
	    </div>
	    
	    <div id="more" class="filter__more">
	      <h3 class="hide"><?php _e('More Options', 'coindev_property'); ?></h3>
	      
	      <!-- Lease Type -->
	      <div class="filter__block">
	        <h4 class="filter__block__header"><?php _e('Lease Type', 'coindev_property'); ?></h4>

	        <ul>
	          <?php 
	          $leasetype = isset($_GET['_leasetype']) ? $_GET['_leasetype'] : '';

	          foreach ($properties['lease_types'] as $lease_type) :
	            $leasetype_class = '';
	            
	            if(!empty($leasetype) && $leasetype == $lease_type)  : 
	              $leasetype_class = 'active';
	              $leasetype_url = remove_query_arg('_leasetype');
	            else : 
	              $leasetype_url = add_query_arg('_leasetype', $lease_type, $investment_url);
	            endif;

	            printf('<li><a class="%3$s" href="%1$s" title="%2$s">%2$s</a></li>', $leasetype_url, $lease_type, $leasetype_class);
	          endforeach; ?>
	        </ul>

	        <input type="hidden" name="_leasetype" value="<?php echo $leasetype; ?>">
	      </div> <!-- end of: Lease Type -->

	      <!-- Property Type -->
	      <div class="filter__block">
	        <h4 class="filter__block__header"><?php _e('Property Type', 'coindev_property'); ?></h4>
	        <ul>
	          <?php 
	          $propertytype = isset($_GET['_propertytype']) ?  $_GET['_propertytype'] : '';

	          foreach($properties['property_types'] as $property_type) : 
	            $propertytype_class = '';
	            
	            if(!empty($propertytype) && $propertytype == $property_type) :
	              $propertytype_class = 'active';
	              $propertytype_url = remove_query_arg('_propertytype');
	            else :
	              $propertytype_url = add_query_arg('_propertytype', $property_type, $investment_url);
	            endif;

	            printf('<li><a class="%3$s" href="%1$s" title="%2$s">%2$s</a></li>', $propertytype_url, $property_type, $propertytype_class); 
	          endforeach; ?>
	        </ul>

	        <input type="hidden" name="_propertytype" value="<?php echo $propertytype; ?>">
	      </div> <!-- end of: Property Type -->
	      
	      <!-- Numbers -->
	      <div class="filter__block filter__block--numbers">
	        <h4 class="filter__block__header"><?php _e('Numbers', 'coindev_property'); ?></h4>
	  
	         <!-- Interest Rate -->
	         <?php 
	          $interest_rate_class = '';
	          $min_interest_rate = isset($_GET['min_interest_rate']) ? $_GET['min_interest_rate'] : '';
	          $max_interest_rate = isset($_GET['max_interest_rate']) ? $_GET['max_interest_rate'] : '';
	         
	          if(!empty($min_interest_rate) && !empty($max_interest_rate)) $interest_rate_class = 'active';
	         ?>
	         <div class="filter__item <?php echo $interest_rate_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Interest Rate (%)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_interest_rate" type="number" step="any" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_interest_rate; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_interest_rate" type="number" step="any" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_interest_rate; ?>">
	          </div> 
	        
	        </div> <!-- end of: Interest Rate -->
	        
	        <!-- Fixed Term -->
	        <?php
	        $fixed_term_class = '';
	        $min_fixed_term = isset($_GET['min_fixed_term']) ? $_GET['min_fixed_term'] : '';
	        $max_fixed_term = isset($_GET['max_fixed_term']) ? $_GET['max_fixed_term'] : '';

	        if(!empty($min_fixed_term) && !empty($max_fixed_term)) $fixed_term_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $fixed_term_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Fixed Term (Years)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_fixed_term" type="number" placeholder="<?php _e('0', 'coindev_property'); ?>" value="<?php echo $min_fixed_term; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_fixed_term" type="number" placeholder="<?php _e('0', 'coindev_property'); ?>" value="<?php echo $max_fixed_term; ?>">
	          </div>
	        </div> <!-- end of: Fixed Term -->

	        <!-- Amortization -->
	        <?php
	        $amortization_class = '';
	        $min_amortization = isset($_GET['min_amortization']) ? $_GET['min_amortization'] : '';
	        $max_amortization = isset($_GET['max_amortization']) ? $_GET['max_amortization'] : '';

	        if(!empty($min_amortization) && !empty($max_amortization)) $amortization_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $amortization_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Amortization (Years)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_amortization" type="number" placeholder="<?php _e('0', 'coindev_property'); ?>" value="<?php echo $min_amortization; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_amortization" type="number" placeholder="<?php _e('0', 'coindev_property'); ?>" value="<?php echo $max_amortization; ?>">
	          </div>
	        </div> <!-- end of: Amortization -->
	        
	        <!-- Loan Amount -->
	        <?php 
	        $loan_amount_class = '';
	        $min_loan_amount = isset($_GET['min_loan_amount']) ? $_GET['min_loan_amount'] : '';
	        $max_loan_amount = isset($_GET['max_loan_amount']) ? $_GET['max_loan_amount'] : '';

	        if(!empty($min_loan_amount) && !empty($max_loan_amount)) $loan_amount_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $loan_amount_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Loan Amount ($)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_loan_amount" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_loan_amount; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_loan_amount" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_loan_amount; ?>">
	          </div>
	        </div> <!-- end of: Loan Amount -->

	        <!-- Payment -->
	        <?php
	        $payment_class = '';
	        $min_payment = isset($_GET['min_payment']) ? $_GET['min_payment'] : '';
	        $max_payment = isset($_GET['max_payment']) ? $_GET['max_payment'] : '';

	        if(!empty($min_payment) && !empty($max_payment)) $payment_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $payment_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Payment ($)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_payment" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_payment; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_payment" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_payment; ?>">
	          </div>
	        </div> <!-- end of: Payment -->

	        <!-- Bulding Size -->
	        <?php 
	        $building_size_class = '';
	        $min_building_size = isset($_GET['min_building_size']) ? $_GET['min_building_size'] : '';
	        $max_building_size = isset($_GET['max_building_size']) ? $_GET['max_building_size'] : '';

	        if(!empty($min_building_size) && !empty($max_building_size)) $building_size_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $building_size_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Building Size (SF)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_building_size" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_building_size; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_building_size" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_building_size; ?>">
	          </div>
	        </div> <!-- end of: Building Size -->

	      </div> <!-- end of: Numbers -->
	      
	      <!-- Others -->
	      <div class="filter__block filter__block--numbers">
	         <h4 class="filter__block__header"><?php _e('Others', 'coindev_property'); ?></h4>

	        <!-- Loan to value -->
	        <?php
	        $ltv_class = '';
	        $min_ltv = isset($_GET['min_ltv']) ? $_GET['min_ltv'] : '';
	        $max_ltv = isset($_GET['max_ltv']) ? $_GET['max_ltv'] : '';

	        if(!empty($min_ltv) && !empty($max_ltv)) $ltv_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $ltv_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('LTV (%)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_ltv" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_ltv; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_ltv" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_ltv; ?>">
	          </div>
	        </div> <!-- end of: Load to value -->
	        
	         <!-- Net Operating Income -->
	        <?php
	        $noi_class = '';
	        $min_noi = isset($_GET['min_noi']) ? $_GET['min_noi'] : '';
	        $max_noi = isset($_GET['max_noi']) ? $_GET['max_noi'] : '';

	        if(!empty($min_noi) && !empty($max_noi)) $noi_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $noi_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Net Operating Income ($)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_noi" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_noi; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_noi" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_noi; ?>">
	          </div>
	        </div> <!-- end of: Net Operating Income -->

	        <!-- Capital Rate -->
	        <?php
	        $capital_rate_class = '';
	        $min_capital_rate = isset($_GET['min_capital_rate']) ? $_GET['min_capital_rate'] : '';
	        $max_capital_rate = isset($_GET['max_capital_rate']) ? $_GET['max_capital_rate'] : '';

	        if(!empty($min_capital_rate) && !empty($max_capital_rate)) $capital_rate_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $capital_rate_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Capital Rate (%)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_capital_rate" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_capital_rate; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_capital_rate" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_capital_rate; ?>">
	          </div>
	        </div> <!-- end of: Capital Rate -->

	        <!-- Land Size -->
	        <?php
	        $land_size_class = '';
	        $min_land_area = isset($_GET['min_land_area']) ? $_GET['min_land_area'] : '';
	        $max_land_area = isset($_GET['max_land_area']) ? $_GET['max_land_area'] : '';

	        if(!empty($min_land_area) && !empty($max_land_area)) $land_size_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $land_size_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Land Size (Acres)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_land_area" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $min_land_area; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_land_area" step="any" type="number" placeholder="<?php _e('0.00', 'coindev_property'); ?>" value="<?php echo $max_land_area; ?>">
	          </div>
	        </div> <!-- end of: Land Size -->

	        <!-- Remaining Terms -->
	        <?php
	        $remaining_terms_class = '';
	        $min_remaining_terms = isset($_GET['min_remaining_terms']) ? $_GET['min_remaining_terms'] : '';
	        $max_remaining_terms = isset($_GET['max_remaining_terms']) ? $_GET['max_remaining_terms'] : '';

	        if(!empty($min_remaining_terms) && !empty($max_remaining_terms)) $remaining_terms_class = 'active';
	        ?>
	        <div class="filter__item <?php echo $remaining_terms_class; ?>">
	          <h5 class="filter__item__title">
	            <?php _e('Remaining Terms (Years)', 'coindev_property'); ?>          
	          </h5>

	          <div class="range-group">
	            <input name="min_remaining_terms" type="number" placeholder="<?php _e('0', 'coindev_property'); ?>" value="<?php echo $min_remaining_terms; ?>">

	            <span><?php _e('To', 'coindev_property'); ?></span>

	            <input name="max_remaining_terms" type="number" placeholder="<?php _e('0', 'coindev_property'); ?>" value="<?php echo $max_remaining_terms; ?>">
	          </div>
	        </div> <!-- end of: Remaining Terms -->
	      </div> <!-- end of: Others -->

	      <!-- Sort by -->
	      <div class="filter__block filter__block--sort">
	        <h4 class="filter__block__header"><?php _e('Sort by', 'coindev_property'); ?></h4>
	        <?php
	          $counter = 0;
	          $order = isset($_GET['order']) ? $_GET['order'] : '';

	          $ordering = array(
	            'relevance' => __('Relevance', 'coindev_property'),
	            'date' => __('Date', 'coindev_property'),
	            '_ltv' => __('LTV', 'coindev_property'),
	            '_interestrate' => __('Interest Rate', 'coindev_property'),
	            '_terms' => __('Fixed Term', 'coindev_property'),
	            '_amortization' => __('Amortization', 'coindev_property'),
	            '_loanamount' => __('Loan Amount', 'coindev_property'),
	            '_payment' => __('Payment', 'coindev_property'),
	            '_combinded' => __('Building Size', 'coindev_property'),
	            '_currentnoi' => __('Current NOI', 'coindev_property'),
	            '_caprate' => __('Capital Rate', 'coindev_property'),
	            '_landarea' => __('Land Area', 'coindev_property'),
	            '_remainingterms' => __('Remaining Terms', 'coindev_property')
	          ); ?>

	        <ul>
	          <?php foreach($ordering as $key => $value) : 
	            $counter++;

	            if($counter === 1 && empty($order)) :
	               printf('<li><a class="active active--no-click" href="%1$s" title="%2$s">%2$s</a></li>', 'javascript:void(0)', $value);
	            else: 
	              $class = '';

	              if(!empty($order) && $order === $key) :
	                $class = 'active';
	                $order_class = remove_query_arg('order');
	              else :
	                $order_class = add_query_arg('order', $key, $investment_url);
	              endif;

	              printf('<li><a class="%3$s" href="%1$s" title="%2$s">%2$s</a></li>', $order_class, $value, $class);
	            endif; 
	          endforeach; ?>
	        </ul>

	        <input type="hidden" name="order" value="<?php echo $order; ?>">
	      </div> <!-- end of: Sort by -->

	      <div class="filter__buttons">
	        <button type="submit" class="button"><?php _e('Apply', 'coindev_property'); ?></button>
	        <a class="button button--cancel js-button--cancel" href="#"><?php _e('Clear', 'coindev_property'); ?></a>
	      </div>
	    </div>
	  </form>
	</section>
	<?php
}

/**
 * Shortcode for the search filter.
 *
 * @since 1.0
 */
function coindev_property_shortcode_search_filter() {
	ob_start();
	coindev_property_search_filter();
	return ob_get_clean();
}
add_shortcode('coindev_property_search_filter', 'coindev_property_shortcode_search_filter');