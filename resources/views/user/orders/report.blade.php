<!DOCTYPE html>
<html>
<head>
    <title>Order Report</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }

        /* Container */
        .container {
            max-width: 960px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
        }

        /* Header */
        h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Order Details */
        .order-details {
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.6;
        }
        .order-details p {
            margin: 10px 0;
        }
        .order-details strong {
            color: #34495e;
        }
        .order-details .total {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #2980b9;
            color: #fff;
            text-transform: uppercase;
        }
        td {
            background-color: #f9f9f9;
        }
        td:first-child {
            font-weight: bold;
            color: #555;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px 0;
            background: #2c3e50;
            color: #ecf0f1;
            font-size: 14px;
            border-top: 4px solid #2980b9;
        }

        /* Buttons */
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #2980b9;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #1a5d85;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            table th, table td {
                font-size: 14px;
                padding: 10px;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Report</h2>
        <div class="order-details">
            <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Room No:</strong> {{ $order->room_no }}</p>
            <p><strong>Room Type:</strong> {{ $order->room->roomtype->name }}</p>
            <p><strong>Check-in Date:</strong> {{ $order->check_in }}</p>
            <p><strong>Check-out Date:</strong> {{ $order->check_out }}</p>
            <p class="total"><strong>Total Price:</strong> ${{ $order->room->price * $order->stayDays + 15 + 25 }}</p>
            <p><strong>Booked On:</strong> {{ $order->created_at }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row, replace with actual data -->
                <tr>
                    <td>Room Service</td>
                    <td>$20</td>
                </tr>
                <tr>
                    <td>Laundry</td>
                    <td>$15</td>
                </tr>

            </tbody>
        </table>

    </div>
    <footer>
        © 2025 Hotel Management System. All rights reserved.
    </footer>
</body>
</html>
