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

### 3. Realtime Database Monitor
- Direct connection to PostgreSQL databases via PDO
- Real-time connection stats (Total, Active, Idle, Locked)
- Database info: Version, Size, Table count, Max connections
- Active connections: PID, User, App, Client IP, State, Query, Duration
- Tables with size breakdown: Table Size, Index Size, Total Size
- Auto-refresh every 5 seconds using Livewire polling
- Pagination for both connections and tables

### 4. Spike Detection & Alerts
- Real-time threshold monitoring
- Email notifications
- Telegram Bot integration
- Webhook support

### 5. Recovery Alerts
- Automatic OK status notifications when metrics return to normal

### 6. Dashboard
- Real-time monitoring with Livewire + Tailwind CSS
- Aurora/Glassmorphism UI theme
- Server and database status overview
- Recent alerts log

### 7. Management
- CRUD for servers and databases
- Search functionality on Server and Database list pages
- View/Edit/Delete buttons for each record

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
Copy `.env.example` to `.env` and update with your PostgreSQL credentials:
```
DB_CONNECTION=pgsql
DB_HOST=your_host
DB_PORT=5432
DB_DATABASE=your_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Staging Database Connection (Optional)
For staging environment:
```
DB_STAGING_CONNECTION=pgsql
DB_STAGING_HOST=ep-blue-morning-am69itpc-pooler.c-5.us-east-1.aws.neon.tech
DB_STAGING_PORT=5432
DB_STAGING_DATABASE=neondb
DB_STAGING_USERNAME=neondb_owner
DB_STAGING_PASSWORD=your_password
```

Usage in code:
```php
DB::connection('pgsql_staging')->table('...')->get();
```

### Telegram Notifications (Optional)
Add to `.env`:
```
TEGRAM_BOT_TOKEN=your_bot_token
TEGRAM_CHAT_ID=your_chat_id
```

### API Endpoints
- `POST /api/metrics` - Receive metrics from monitoring agents
- `GET /api/health` - Health check

## Routes

| Route | Description |
|-------|-------------|
| `/dashboard` | Main dashboard |
| `/servers` | Server list with CRUD |
| `/databases` | Database list with CRUD |
| `/database/{id}/monitor` | Realtime PostgreSQL monitor |
| `/audit-logs` | Audit log viewer |

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
│   ├── DatabaseList.php
│   └── RealtimeDatabaseMonitor.php
├── Services/
│   └── PostgreSqlConnector.php # PostgreSQL PDO connection
└── Notifications/              # Notification classes
```

## PostgreSqlConnector Service

The `PostgreSqlConnector` service provides direct PostgreSQL connections using PDO:

```php
$connector = new PostgreSqlConnector();

$config = [
    'host' => '127.0.0.1',
    'port' => 5432,
    'database' => 'mydb',
    'username' => 'user',
    'password' => 'pass',
];

// Get connection stats
$stats = $connector->getDatabaseStats($config);
// Returns: ['active' => 0, 'idle' => 0, 'locked' => 0, 'total' => 0]

// Get database info
$info = $connector->getDatabaseInfo($config);
// Returns: ['version', 'size', 'tables', 'connections', 'max_connections']

// Get active connections
$connections = $connector->getConnectionInfo($config);
// Returns: array of connections with PID, user, app, client_ip, state, query, duration

// Get table stats with sizes
$tables = $connector->getTableStats($config);
// Returns: array of tables with n, name, schema, total_size, table_size, index_size
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

## UI Features

### Right Sidebar Layout
- Collapsible sidebar (icon-only mode)
- Hover tooltips showing menu names
- Glassmorphism styling with gradient backgrounds

### Aurora/Glassmorphism Theme
- Primary color: Indigo (#6366f1)
- Gradient backgrounds
- Translucent cards with backdrop blur

## License

MIT License