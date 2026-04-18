# APPS-MONITORING (Laravel 13)

Advanced Server and Database Monitoring System with Multi-Tenant Architecture, Role-Based Access Control (RBAC), and Real-time Dashboard.

## 🚀 Key Features

### 1. Multi-Tenant Architecture
- **Hierarchical Structure**: Organisation → Branch → Team.
- **Data Isolation**: Automatic data filtering using Eloquent `TenantScope`.
- **Management**: Full CRUD for Organisations and Branches with dedicated management views.

### 2. Role-Based Access Control (RBAC)
- Powered by `spatie/laravel-permission`.
- **Roles**: Admin (Org), Branch Manager, Line Manager, Supervisor, and User.
- **Isolation**: Roles are hierarchical but strictly isolated per organization.

### 3. Monitoring Capabilities
- **Server Monitoring**: Real-time tracking of CPU, RAM, Disk, and Network usage.
- **Database Monitoring**: Support for PostgreSQL, MySQL, SQL Server, and Oracle.
- **Real-time PostgreSQL Monitor**: Deep dive into active connections, query duration, and table sizes.

### 4. UI/UX (Modern & Responsive)
- **Aurora/Glassmorphism Theme**: Translucent cards with backdrop blur.
- **Animated Header**: Real-time clock (WIB) and dynamic date positioning.
- **Collapsible Sidebar**: Space-efficient navigation with tooltips.
- **App Versioning**: Automatic version tracking displayed in the sidebar footer.

## 🛠️ Tech Stack

- **Framework**: Laravel 13 (PHP 8.2+)
- **Frontend**: Livewire 3 + Tailwind CSS
- **Database**: PostgreSQL
- **RBAC**: Spatie Laravel Permission
- **Timezone**: Asia/Jakarta (WIB)

## 📥 Installation

```bash
# Clone the repository
git clone https://github.com/harys-rifai/APPS-MONITORING.git

# Install PHP dependencies
composer install

# Install JS dependencies
npm install && npm run build

# Configure Environment
cp .env.example .env
# Update DB_CONNECTION=pgsql and your credentials in .env

# Run Migrations & Seeders (Required for RBAC & Initial Org)
php artisan migrate:fresh --seed

# Start Application
php artisan serve
```

## 🔐 Default Admin Login

- **Email**: `harys@google.com`
- **Password**: `xcxcxc`
- **Role**: Super Admin (Organisation Level)

## 📈 Application Versioning
The system tracks updates in the `app_versions` table. The current version is displayed at the bottom of the left sidebar.
- **v.1.0.0**: Initial Multi-tenant Rebuild.
- **v.1.0.1**: UI Refinements, Clock/Timezone fixes.

## 📝 License
MIT License