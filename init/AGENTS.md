# AGENTS.md — AI Agent Operating Rules

---

## Objective
You are an **autonomous AI software engineer**.  
Your mission: **design, build, debug, and improve projects** with clean, production-ready code.

Always prioritize:
- Correctness
- Simplicity
- Maintainability
- Performance

---

## Core Behavior Rules
- Think before acting
- Break problems into smaller steps
- Avoid unnecessary complexity
- Respect existing architecture

---

## Multi-Organization & Role Hierarchy
Agents must support **multi-tenant applications** with **role-based access control (RBAC)**.

### Organizational Layers
- Organisation → Branch → Line Manager → Supervisor → User

### Role Responsibilities
- **Admin (Organisation Level)**
  - Manage global settings, tenants, and system-wide policies
  - Create branches and assign line managers

- **Branch Manager**
  - Oversee branch operations
  - Assign supervisors and manage branch-level resources

- **Line Manager**
  - Manage teams within a branch
  - Approve workflows and escalate issues

- **Supervisor**
  - Directly oversee users
  - Validate tasks, monitor performance

- **User**
  - Perform assigned tasks
  - Limited access to data and actions

### RBAC Rules
- Always enforce **least privilege principle**
- Roles must be **hierarchical but isolated per organization**
- Permissions should be **configurable via policy files or database tables**
- Use **middleware/guards** to enforce access control

---

## Language
- ADD Bahasa Indonesia and EN selection for user
- Bahasa including all in user profile data, table name, etc
- If user select EN then all will be EN
- If user select Bahasa Indonesia then all will be Bahasa Indonesia
- Default language is English (USA)

---

## Time Apps Configuration
- Set to WIB (Waktu Indonesia Barat) - Jakarta time

---

## App Versions
- Create table `app_versions`
- Store changes every bug fix or feature
- Display version in sidebar right as v.xx.x

---

## File Handling Rules
- Keep organization-specific configs separate (`/config/orgs/`)
- Use migrations for role/permission tables
- Avoid hardcoding role logic — use **policy-based authorization**

---

## Clock Animation
- Add animated clock in header/navbar (sidebar)
- Clock should be animated every minute, second, and millisecond using real current time from browser
- Date should be updated every day
- Clock should show timezone (WIB) and date

---

## Architecture Guidelines
### Laravel (Default)
- Use **Spatie Laravel Permission** for RBAC
- Define roles & permissions in **seeders**
- Use **middleware (`auth`, `role`, `permission`)** for enforcement
- Keep **multi-tenancy** clean with `organisation_id` foreign keys
- Separate **business logic** into Services
- Use Livewire for interactive components
- Use Blade templates with Tailwind CSS

---

## Security Best Practices
- Validate all inputs per role
- Prevent privilege escalation (e.g., user cannot act as supervisor)
- Use CSRF tokens, hashed passwords, and guards
- Encrypt sensitive tenant data

---

## Performance Guidelines
- Optimize queries with **scoped relationships** (`organisation_id`, `branch_id`)
- Use **eager loading** to avoid N+1 queries
- Cache role/permission lookups

---

## Testing & Debugging
- Write unit tests for **role-based access**
- Test **multi-tenant isolation** (users cannot access other orgs)
- Use **factories** to simulate different roles

---

## Tech Stack
- Laravel 13 (PHP 8.3+)
- Livewire 4
- Spatie Laravel Permission
- Blade + Tailwind CSS
- MySQL/PostgreSQL

---

## Output Expectations
Every output should be:
- Working
- Clean
- Minimal
- Easy to understand
- Role-aware & organization-safe

---

## Final Rule
Always act like a **senior software engineer**
who writes code that others can easily understand, use, and scale.