<?php

/* Translation file. Array keys are arranged alphabetically */

return [
    /* Buttons */
    'buttons' => [
        'adjust_stock' => 'Adjust Stock',
        'back_to_login' => 'Back to login',
        'back_to_shop' => 'Back to shop',
        'buy' => 'Buy Now',
        'cancel' => 'Cancel',
        'continue_shopping' => 'Continue Shopping',
        'delete' => 'Delete',
        'go_to_dashboard' => 'Go to dashboard',
        'login' => 'Login',
        'payment_sent' => 'Payment Sent',
        'place_order' => 'Place order',
        'register' => 'Register',
        'save' => 'Save',
        'send_reset_link' => 'Send Password Reset Link',
        'sent' => 'Sent',
        'submit' => 'Submit',
        'subscribe' => 'Subscribe'
    ],
    /* Headings and subheadings */
    'headings' => [
        'api_keys' => 'API Keys',
        'basic_info' => 'Basic Info',
        'country_and_code' => 'Country & Calling Code',
        'manage' => 'Manage',
        'menu' => 'Menu',
        'order' => 'Order',
        'order_summary' => 'Order Summary',
        'payment_info' => 'Payment Information',
        'payment_success' => 'Thank you for your order',
        'pending_shipment' => 'Pending Shipment',
        'price' => 'Price',
        'product' => 'Product',
        'qty' => 'Qty',
        'sent_shipment' => 'Sent Shipment',
        'settings' => 'Settings',
        'shipping_details' => 'Shipping Details',
        'tracking_info' => 'Tracking Info',
        'tracking_number' => 'Tracking Number',
        'users' => 'Users'
    ],
    /* Input labels and placeholders*/
    'labels' => [
        'address_1' => 'Address Line 1',
        'address_2' => 'Address Line 2',
        'amount' => 'Amount',
        'calling_code' => 'Calling Code',
        'city' => 'City',
        'code' => 'Code',
        'confirm_password' => 'Confirm Password',
        'country' => 'Country',
        'credit_card' => 'Credit Card',
        'currency' => 'Currency',
        'currency_symbol' => '$',
        'description' => 'Description',
        'email' => 'Email',
        'item' => 'Item',
        'key' => 'Key',
        'name' => 'Name',
        'options' => 'Options',
        'orders' => 'Orders',
        'order_no' => 'Order no.',
        'password' => 'Password',
        'phone' => 'Phone',
        'phone_tracking' => 'Tracking will be sent via SMS',
        'photo' => 'Photo',
        'postal' => 'Postal',
        'price' => 'Price',
        'product' => 'Product',
        'secret' => 'Secret',
        'site_name' => 'Site Name',
        'shipping' => 'Shipping',
        'state' => 'State/Province',
        'stock' => 'Stock',
        'tracking_number' => 'Tracking Number',
        'username' => 'Username'
    ],
    /* Mails */
    'mails' => [
        'greetings' => 'Hi!',
        'password_reset' => [
            'action' => 'Reset Password',
            'intro' => 'You are receiving this email because we received a password reset request for your account.',
            'line1' => 'This password reset link will expire in 60 minutes.',
            'line2' => 'If you did not request a password reset, no further action is required.',
        ]
    ],
    /* Notifications */
    'notifications' => [
        'added' => 'was added',
        'created' => 'was created',
        'deleted' => 'was deleted',
        'key_not_saved' => 'There was an error saving your keys',
        'key_saved' => 'Your new keys were saved',
        'not_saved' => 'Data not saved.',
        'shipment_sent' => 'Shipment sent',
        'stock_adjusted' => 'Stock adjusted',
        'updated' => 'was updated',
    ],
    /* SMS messages */
    'sms' => [
        'shipping_created' => "SekaiFarm here, Your order has been received & we'll update you shortly with tracking information. Order # :productName",
        'shipping_sent' => "SekaiFarm here, Your order #:productName was just sent with :carrier. Tracking # :trackingNumber"
    ],
    /* Paragraphs and text */
    'texts' => [
        'already_subscribed' => 'Already subscribed?',
        'cart' => 'Cart',
        'change_password' => 'Change Password',
        'check_payment' => 'Checking Payment, 15 Seconds',
        'delete_confirm' => 'Are you sure you want to delete',
        'forgot_password' => 'Forgot your password?',
        'free' => 'Free',
        'free_shipping' => 'free shipping',
        'logout' => 'logout',
        'my_dashboard' => 'My Dashboard',
        'no_products' => 'There are no products',
        'no_pending' => 'There are no pending shipments',
        'no_sent' => 'There are no sent shipments',
        'order_number' => 'Order Number:',
        'per_month' => 'per month',
        'refresh' => "Don't refresh the page",
        'reset_password' => 'Reset Password',
        'shipping_time' => 'Will ship within 48 hours to',
        'sign_in' => 'Sign In',
        'subscription_success' => 'Subscription Success!',
        'subscription_success_message' => 'Thank you for subscribing to our product. You will receive <strong>:qty :product</strong> and will be charge <strong>:total</strong> every month.',
        'total' => 'Total'
    ],
    'countries' => [
        'united_states' => 'United States',
        'china' => 'China',
        'macau' => 'Macau',
        'hong_kong' => 'Hong Kong',
        'taiwan' => 'Taiwan',
        'United States' => 'United States',
        'China' => 'China',
        'Macau' => 'Macau',
        'Hong Kong' => 'Hong Kong',
        'Taiwan' => 'Taiwan'
    ]
];


/*

//add this to validition.php

 'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'callingCode' => [ // custom validation message for calling code not_regex
            'not_regex' => 'The calling code field is required.'
        ],
        'country' => [
            'not_regex' => 'Country is Required.',
            'required_calling_code' => 'Country calling code is required.'
        ],
        'phone' => [ // custom validation message for phone review
            'not_found' => 'Phone number not found.',
            'not_allowed' => 'Only one review per order allowed.'
        ]
    ],

    'attributes' => [
        'comment' => 'comment',
        'phone' => 'phone'
    ],

];

*/