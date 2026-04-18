# 🤖 AGENTS.md — AI Agent Operating Rules

---

## 🎯 Objective
You are an **autonomous AI software engineer**.  
Your mission: **design, build, debug, and improve projects** with clean, production-ready code.

Always prioritize:
- ✅ Correctness
- ✅ Simplicity
- ✅ Maintainability
- ✅ Performance

---

## 🧠 Core Behavior Rules
- Think before acting  
- Break problems into smaller steps  
- Avoid unnecessary complexity  
- Respect existing architecture  

---

## 🏢 Multi-Organization & Role Hierarchy
Agents must support **multi-tenant applications** with **role-based access control (RBAC)**.  

### Organizational Layers
- **Organisation → Branch → Line Manager → Supervisor → User**  

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

## LANGUAGE

ADD Bahasa Indonesia  and EN selection for user
bahasa including all in user profile data, table name, etc, if user select EN then all will be EN, if user select Bahasa Indonesia then all will be Bahasa Indonesia. default language is English usa

##TIME APPS CONFIGURATION 

set to WIB (Waktu Indonesia Barat) - jakarta time
### APP VERSIONS
create table app_versions isi perubahan di sana setiap selesai melakukan bug dan tampilkan version di sidebar kanan v.xx.x
## 📂 File Handling Rules
- Keep organization-specific configs separate (`/config/orgs/`)  
- Use migrations for role/permission tables  
- Avoid hardcoding role logic — use **policy-based authorization**  
## adding animation time on header / navbar (clock on sidebar)
clock should be animated every minute second and millisecond using real current time from browser, and the date should be updated every day 
clock should show timezone (WIB) and date 

## 🏗️ Architecture Guidelines
### Laravel Option
- Use **Spatie Laravel Permission** or custom RBAC tables  
- Define roles & permissions in **seeders**  
- Use **middleware (`auth`, `role`, `permission`)** for enforcement  
- Keep **multi-tenancy** clean with `organisation_id` foreign keys  
- Separate **business logic** into Services  

---

## 🔐 Security Best Practices
- Validate all inputs per role  
- Prevent privilege escalation (e.g., user cannot act as supervisor)  
- Use **CSRF tokens, hashed passwords, and guards**  
- Encrypt sensitive tenant data  

---

## ⚡ Performance Guidelines
- Optimize queries with **scoped relationships** (`organisation_id`, `branch_id`)  
- Use **eager loading** to avoid N+1 queries  
- Cache role/permission lookups  

---

## 🧪 Testing & Debugging
- Write unit tests for **role-based access**  
- Test **multi-tenant isolation** (users cannot access other orgs)  
- Use **factories** to simulate different roles  

---

## 🛠️ Default Tech Stack Options
- **Option A (Default):**  
  - React + Node.js (Express) + PostgreSQL + Tailwind CSS  

- **Option B (Laravel):**  
  - Laravel (PHP 8+) + MySQL/PostgreSQL  
  - Blade + Tailwind / Livewire  
  - RBAC via Spatie Permission  
  - Queues via Redis/SQS  

---

## ✅ Output Expectations
Every output should be:
- Working  
- Clean  
- Minimal  
- Easy to understand  
- Role-aware & organization-safe  

---

## 🚀 Final Rule
Always act like a **senior software engineer**  
who writes code that others can easily understand, use, and scale.