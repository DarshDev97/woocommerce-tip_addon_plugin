<?php

add_action('woocommerce_before_add_to_cart_button', 'add_artist_tip_on_product_page');

function add_artist_tip_on_product_page()
{
    global $product;


    $product_cats = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'slugs'));

    // Define which categories should show the tip field 
    $allowed_categories = array('album', 'upcoming'); 

    $show_tip = false;
    foreach ($product_cats as $cat) {
        if (in_array($cat, $allowed_categories)) {
            $show_tip = true;
            break;
        }
    }

    if (!$show_tip) {
        return;
    }

    ?>
    <div class="artist-support-tip-product">

        <!-- Header -->
        <div class="artist-tip-header">
            <h3>Support the Artist</h3>
            <p>Love this music? Add extra support to help the artist create more amazing albums!</p>
        </div>

        <!-- Quick Tip Buttons -->
        <div class="tip-buttons-product">
            <button type="button" class="tip-btn-product" data-amount="5">$5</button>
            <button type="button" class="tip-btn-product" data-amount="10">$10</button>
            <button type="button" class="tip-btn-product" data-amount="20">$20</button>
            <button type="button" class="tip-btn-product" data-amount="50">$50</button>
        </div>

        <!-- Custom Amount Input -->
        <div class="artist-tip-custom-section">
            <label for="product_artist_tip">Or enter any custom amount:</label>
            <div class="artist-tip-input-wrapper">
                <span class="artist-tip-dollar-sign">$</span>
                <input type="number" id="product_artist_tip" name="product_artist_tip" min="0" step="0.01"
                    placeholder="Enter amount (e.g., 15.00)" value="0"
                    style="width: 100%; padding: 14px 15px 14px 35px; border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 16px; font-weight: 600; background: #fff; color: #1A1A1A; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" />
            </div>
        </div>

        <input type="hidden" name="artist_tip_amount" id="artist_tip_amount_hidden" value="0">

    </div>

    <style>
        .artist-support-tip-product {
            margin: 25px 0;
            padding: 25px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1)
        }

        .artist-tip-header {
            text-align: left;
            margin-bottom: 20px;
        }

        .artist-tip-header h3 {
            color: #fff;
            margin: 0 0 8px 0;
            font-size: 20px;
            font-weight: 600;
        }

        .artist-tip-header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .tip-buttons-product {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .tip-btn-product {
            flex: 1;
            min-width: 70px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .tip-btn-product:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .tip-btn-product.active {
            background: #fff !important;
            color: #1A1A1A !important;
            border-color: #fff !important;
        }

        .artist-tip-custom-section {
            text-align: center;
        }

        .artist-tip-custom-section label {
            color: rgba(255, 255, 255, 0.95);
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .artist-tip-input-wrapper {
            position: relative;
            max-width: 250px;
            margin: 0 auto;
        }

        .artist-tip-dollar-sign {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1A1A1A;
            font-size: 18px;
            font-weight: 600;
            z-index: 1;
        }

        .product-artist-tip-input {
            width: 100%;
            padding: 14px 15px 14px 35px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            background: #222631 !important;
            color: #1A1A1A;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-artist-tip-input:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }


        @media (max-width: 600px) {
            .tip-buttons-product {
                flex-direction: column;
            }

            .tip-btn-product {
                min-width: 100% !important;
            }
        }
    </style>

    <script>
        jQuery(document).ready(function ($) {
            // Quick tip button functionality
            $('.tip-btn-product').on('click', function (e) {
                e.preventDefault();
                var amount = $(this).data('amount');

               
                $('.tip-btn-product').removeClass('active');
                $(this).addClass('active');

               
                $('#product_artist_tip').val(amount);
                $('#artist_tip_amount_hidden').val(amount);
            });

           
            $('#product_artist_tip').on('input change', function () {
                var amount = parseFloat($(this).val()) || 0;

               
                $('.tip-btn-product').removeClass('active');

               
                $('#artist_tip_amount_hidden').val(amount);
            });
        });
    </script>
    <?php
}


add_filter('woocommerce_add_cart_item_data', 'add_artist_tip_to_cart_item', 10, 3);

function add_artist_tip_to_cart_item($cart_item_data, $product_id, $variation_id)
{
    if (isset($_POST['artist_tip_amount']) && floatval($_POST['artist_tip_amount']) > 0) {
        $cart_item_data['artist_tip'] = floatval($_POST['artist_tip_amount']);
      
        $cart_item_data['unique_key'] = md5(microtime() . rand());
    }
    return $cart_item_data;
}


add_filter('woocommerce_get_item_data', 'display_artist_tip_in_cart', 10, 2);

function display_artist_tip_in_cart($item_data, $cart_item)
{
    if (isset($cart_item['artist_tip'])) {
        $item_data[] = array(
            'name' => 'Artist Support',
            'value' => '$' . number_format($cart_item['artist_tip'], 2)
        );
    }
    return $item_data;
}


add_action('woocommerce_cart_calculate_fees', 'add_artist_tip_as_separate_fee', 10, 1);

function add_artist_tip_as_separate_fee($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    $total_tips = 0;


    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['artist_tip']) && $cart_item['artist_tip'] > 0) {
            $total_tips += $cart_item['artist_tip'];
        }
    }


    if ($total_tips > 0) {
        $cart->add_fee(
            'Artist Support',
            $total_tips,
            false
        );
    }
}


add_action('woocommerce_checkout_create_order_line_item', 'save_artist_tip_to_order', 10, 4);

function save_artist_tip_to_order($item, $cart_item_key, $values, $order)
{
    if (isset($values['artist_tip'])) {
        $item->add_meta_data('Artist Support Tip', '$' . number_format($values['artist_tip'], 2), true);
    }
}


add_action('woocommerce_admin_order_data_after_order_details', 'display_artist_tip_in_admin_order');

function display_artist_tip_in_admin_order($order)
{
    echo '<h3>Artist Support Tips</h3>';
    $total_tips = 0;

    foreach ($order->get_items() as $item) {
        $tip = $item->get_meta('Artist Support Tip');
        if ($tip) {
            echo '<p><strong>' . $item->get_name() . ' - Artist Support:</strong> ' . esc_html($tip) . '</p>';
            $total_tips += floatval(str_replace(array('$', ','), '', $tip));
        }
    }

    if ($total_tips > 0) {
        echo '<p><strong>Total Artist Support:</strong> $' . number_format($total_tips, 2) . '</p>';
    }
}



add_filter('woocommerce_cart_subtotal', 'update_mini_cart_subtotal_with_tips', 10, 3);

function update_mini_cart_subtotal_with_tips($cart_subtotal, $compound, $cart)
{
    if (is_null($cart)) {
        $cart = WC()->cart;
    }


    $total_tips = 0;
    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['artist_tip']) && $cart_item['artist_tip'] > 0) {
            $total_tips += $cart_item['artist_tip'];
        }
    }


    if ($total_tips > 0) {
        $subtotal = $cart->get_subtotal();
        $new_total = $subtotal + $total_tips;
        return wc_price($new_total);
    }

    return $cart_subtotal;
}


add_filter('woocommerce_add_to_cart_fragments', 'refresh_mini_cart_fragments_with_tips');

function refresh_mini_cart_fragments_with_tips($fragments)
{
 
    WC()->cart->calculate_totals();

    return $fragments;
}
