# DB Monitoring - Laravel 13 Application

Server and Database Monitoring System with Real-time Dashboard, Alert Notifications, and Job Queue Processing.

## Features

### 1. Server Monitoring
- Monitor CPU, RAM, Disk, and Network usage
- Configurable thresholds per server
- Support for Linux, Windows, and macOS

### 2. Database Monitoring
- Support for PostgreSQL, MySQL, SQL Server, DB2, and Oracle
- Query metrics: Active, Idle, Locked counts
- Configurable thresholds per database

### 3. Spike Detection & Alerts
- Real-time threshold monitoring
- Email notifications
- Telegram Bot integration
- Webhook support

### 4. Recovery Alerts
- Automatic OK status notifications when metrics return to normal

### 5. Dashboard
- Real-time monitoring with Livewire + Tailwind CSS
- Dark theme UI
- Server and database status overview
- Recent alerts log

### 6. Management
- CRUD for servers and databases
- Role-based access (Admin, Operator)

## Tech Stack

- **Framework**: Laravel 13
- **Database**: PostgreSQL (Neon)
- **Queue**: Sync (configurable to Redis)
- **UI**: TailwindCSS + Livewire
- **Auth**: Laravel Breeze

## Installation

```bash
# Clone the repository
git clone https://github.com/harys-rifai/APPS-MONITORING.git

# Install dependencies
composer install

# Install Node dependencies
npm install

# Build assets
npm run build

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start server
php artisan serve
```

## Default Login

- **Email**: harys@google.com
- **Password**: xcxcxc

## Configuration

### Database Connection
Update `.env` with your PostgreSQL credentials:
```
DB_CONNECTION=pgsql
DB_HOST=ep-blue-morning-am69itpc-pooler.c-5.us-east-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=your_password
```

### Telegram Notifications
Add to `.env`:
```
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
```

### API Endpoints
- `POST /api/metrics` - Receive metrics from monitoring agents
- `GET /api/health` - Health check

## Project Structure

```
app/
├── Console/Kernel.php          # Scheduler
├── Events/                     # Event classes
│   ├── ServerSpikeDetected.php
│   ├── ServerRecovered.php
│   ├── DatabaseSpikeDetected.php
│   └── DatabaseRecovered.php
├── Jobs/                       # Queue jobs
│   ├── CheckServerMetrics.php
│   └── CheckDatabaseMetrics.php
├── Listeners/                  # Alert listeners
├── Models/                     # Eloquent models
│   ├── Server.php
│   ├── Database.php
│   ├── DbMetric.php
│   ├── ServerMetric.php
│   └── Alert.php
├── Http/Livewire/              # Livewire components
│   ├── Dashboard.php
│   ├── ServerList.php
│   └── DatabaseList.php
└── Notifications/              # Notification classes
```

## Scheduler

The scheduler runs every minute to check:
1. Server metrics via API
2. Database query statistics

## Monitoring Agent

Create a Python/PowerShell agent on target servers to send metrics:

```python
import requests
import psutil

# Get metrics
cpu = psutil.cpu_percent()
ram = psutil.virtual_memory().percent
disk = psutil.disk_usage('/').percent
net_in = psutil.net_io_counters().bytes_recv / 1024 / 1024
net_out = psutil.net_io_counters().bytes_sent / 1024 / 1024

# Send to API
requests.post('http://your-server/api/metrics', json={
    'api_token': 'server_api_token',
    'cpu': cpu,
    'ram': ram,
    'disk': disk,
    'network_in': net_in,
    'network_out': net_out
})
```

## License

MIT License