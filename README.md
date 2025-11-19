🎵 Features

Beautiful tip interface with quick-select buttons ($5, $10, $20, $50)
Custom amount input - customers can enter any amount they want
Category-specific display - only shows on designated product categories
Separate line item - tips appear as "Artist Support" in cart, not added to product price
PayPal compatible - works seamlessly with PayPal and other payment gateways
Mobile responsive - looks great on all devices
Admin order tracking - tips displayed in order details for easy tracking


Method 1: Code Snippets Plugin (Recommended)

Install and activate the Code Snippets plugin
Go to Snippets → Add New
Copy and paste the code from artist-support-tip.php
Set "Run snippet everywhere"
Save and activate

Method 2: Functions.php

Go to Appearance → Theme File Editor
Select functions.php
Paste the code at the bottom
Click Update File

Method 3: Custom Plugin

Upload the plugin folder to /wp-content/plugins/
Activate through the Plugins menu in WordPress

⚙️ Configuration

Set your product categories - Edit line 17 in the code:

php$allowed_categories = array('album', 'upcoming');
Replace with your category slugs where tips should appear.

Customize tip amounts - Edit lines 47-50 to change button values:

<button type="button" class="tip-btn-product" data-amount="5">$5</button>
```

3. **Customize colors** - Modify the CSS section (lines 70-200) to match your theme

## 🎨 Customization

### Change Colors
Find these CSS properties in the code:
- Background: `background: rgba(255, 255, 255, 0.03);`
- Button colors: `.tip-btn-product` styles
- Input border: `border-color: #d4af37;`

### Change Text
- Header: Line 43 - `<h3>Support the Artist</h3>`
- Description: Line 44
- Label: Line 56

### Change Button Amounts
Edit the button values in lines 47-50

## 📋 How It Works

1. Customer views a music album in designated categories
2. Tip field appears above "Add to Cart" button
3. Customer selects a quick amount or enters custom amount
4. Product is added to cart with tip as separate line item
5. Cart displays:
   - Product name and price (unchanged)
   - Artist Support amount (below product)
   - Combined total in subtotal
6. Tip appears as "Artist Support" fee in checkout
7. Full amount (product + tip) sent to payment gateway
8. Admin can see tips in order details

## 🛒 Cart Display Example
```
Crown Snatcher                    $10.00
  └─ Artist Support: $10.00
1 × $10.00

Subtotal:                         $20.00
💳 Payment Gateway Compatibility

✅ PayPal Standard
✅ PayPal Express
✅ Stripe
✅ Square
✅ All standard WooCommerce gateways

📦 Requirements

WordPress 5.0+
WooCommerce 3.0+
PHP 7.0+

🐛 Troubleshooting
Tip field not showing:

Check that your product is in the correct category
Verify category slug matches in configuration

Mini cart not updating:

Clear browser cache
Clear WooCommerce cache
Check for theme conflicts

Styling issues:

Your theme CSS may override styles
Add !important to CSS rules if needed

📞 Support
If you encounter any issues or have questions:

Contact: info.technofyweb@gmail.com

⭐ If this helped your project, please star this repository!
