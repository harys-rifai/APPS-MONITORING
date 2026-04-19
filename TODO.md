# Task: Seed 40 data records per table and fix pagination to show current page, next, and data count consistently

## Status: [IN PROGRESS]

### Steps:
1. [✅] Update `database/seeders/SampleDataSeeder.php` to seed 40 records each for Organisation, User, Server, Database, and add Branch seeding.
2. [ ] Execute `php artisan db:seed --class=SampleDataSeeder` to populate database.
3. [ ] Verify seeding success (check record counts).
4. [ ] Add consistent pagination info block to all 6 list blade views:
   - `resources/views/livewire/user-list.blade.php`
   - `resources/views/livewire/organisation-list.blade.php`
   - `resources/views/livewire/branch-list.blade.php`
   - `resources/views/livewire/server-list.blade.php`
   - `resources/views/livewire/database-list.blade.php`
   - `resources/views/livewire/audit-log-list.blade.php`
5. [ ] Test pagination displays "Showing X-Y of Z", current page, next links consistently.
6. [ ] Complete task.

**Next step: Edit SampleDataSeeder.php**

