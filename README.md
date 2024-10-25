# Crypto View

**Crypto View** is a cryptocurrency analysis and alerting application that integrates with TradingView and Telegram to provide real-time alerts based on custom-defined conditions. It is designed to help users monitor and receive notifications on specific crypto asset price movements.

## Features

- **Real-time Alerts**: Receive Telegram notifications based on TradingView webhook events.
- **Custom Conditions**: Define rules for alerts, comparing all plot values from TradingView.
- **User Settings**: Configure individual settings.
- **Flexible Integrations**: Utilizes Laravel and Redis for optimized handling of asynchronous tasks.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)

## Requirements

- PHP 8.1 or higher
- Laravel 11
- Redis (for queue management)
- TradingView account (to set up webhooks)
- Telegram Bot API token

## Installation

1. **Install Dependencies**

   ```bash
   composer install

2. **Set Up Environment Variables**

   ```bash
   cp .env.example .env

3. **Generate Application Key**

   ```bash
   php artisan key:generate

4. **Configure Database**. Update your .env file with your database credentials, then run migrations:

   ```bash
   php artisan migrate

5. **Set Up Redis**. Make sure Redis is installed and running. Update .env to reflect your Redis configuration.

6. **Generate Admin User**. Create an admin user for the application interface:
    ```bash 
   php artisan make:filament-user

7. **Configure Telegram**. Obtain a Telegram Bot API token and update it in the admin configurations to enable Telegram notifications.

## Configuration

- **TradingView Webhook Setup**: In TradingView, set up webhook alerts with the URL endpoint **webhook/alert**.
- **Alert Settings**:  Configure TradingView alerts by defining conditions and including the following data structure in the alert's message field:
   ```
  {
    "plot_data": {
      "plot_0": {{plot_0}},
      "plot_1": {{plot_1}},
      "plot_2": {{plot_2}},
      "plot_3": {{plot_3}},
      "plot_19": {{plot_19}}
      
    },
    "exchange": "{{exchange}}",
    "ticker": "{{ticker}}"
  }

## Usage
1. **Starting the Server**
   ```
   docker compose start
2. **Running Queues**
   ```
   php artisan queue:work
