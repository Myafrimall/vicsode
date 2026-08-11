<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave a Review</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f5; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%); padding: 40px 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">VICSODE</h1>
                            <p style="color: #94a3b8; margin: 8px 0 0; font-size: 13px; letter-spacing: 1px;">BLENDERS & PROCESSORS</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="color: #1f2937; font-size: 22px; margin: 0 0 16px; font-weight: 700;">
                                Hi {{ $order->customer_name }}! 👋
                            </h2>

                            <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 24px;">
                                Your order <strong style="color: #1f2937;">{{ $order->order_number }}</strong> has been delivered! We hope you're enjoying your new product.
                            </p>

                            <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 32px;">
                                We'd love to hear what you think. Your feedback helps other customers make great choices and helps us keep improving.
                            </p>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('review.show', $order->review_token) }}"
                                           style="display: inline-block; background: linear-gradient(135deg, #e2624f 0%, #cf4532 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-size: 16px; font-weight: 700; box-shadow: 0 4px 14px rgba(207,69,50,0.3);">
                                            ⭐ Leave a Review
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Summary -->
                            <div style="margin-top: 36px; padding: 24px; background-color: #f9fafb; border-radius: 12px; border: 1px solid #e5e7eb;">
                                <p style="color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 12px; font-weight: 600;">Order Summary</p>
                                <p style="color: #1f2937; font-size: 14px; margin: 0 0 4px;"><strong>Order:</strong> {{ $order->order_number }}</p>
                                <p style="color: #1f2937; font-size: 14px; margin: 0 0 4px;"><strong>Total:</strong> ₦{{ number_format($order->total, 2) }}</p>
                                <p style="color: #1f2937; font-size: 14px; margin: 0;"><strong>Delivered to:</strong> {{ $order->delivery_city }}, {{ $order->delivery_state }}</p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 24px 40px; background-color: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0 0 8px;">
                                Thank you for shopping with Vicsode!
                            </p>
                            <p style="color: #9ca3af; font-size: 11px; margin: 0;">
                                If you didn't place this order, please ignore this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
