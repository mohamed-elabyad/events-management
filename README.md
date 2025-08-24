# Events Management API

A production-ready RESTful API for creating and managing events and attendees, with token-based auth (Sanctum), fine-grained authorization (Policies & Gates), resource transformers, pagination, a scheduled command that sends email reminders to attendees for events starting in the next 24 hours, and a clean, extensible codebase.

---

## Features
- **Authentication**: Register, login, and logout with Laravel Sanctum.
- **Events Management**: Full CRUD with ownership rules and pagination.
- **Attendees Management**: Users can join or leave events via nested routes.
- **Authorization**: Policies restrict updates/deletes to the resource owner.
- **Flexible Includes**: Endpoints support `?include=` to eager load relations (`owner`, `attendees`) using a custom `loadRelations()` method.
- **Notifications**: Email reminders are sent to all attendees one day before event start.
- **Scheduling**: Custom Artisan command scheduled via Laravel Scheduler to trigger reminders automatically.
- **Rate Limiting**: Throttled API routes for security.
- **Email Testing**: Integrated with [Mailtrap](https://mailtrap.io/) to preview and monitor outgoing emails safely.

---

## Tech Stack
- **Framework**: Laravel 12
- **Authentication**: Laravel Sanctum
- **Database**: MySQL (via Eloquent ORM)
- **Notifications**: Laravel Notifications (Mail, Mailtrap)
- **Scheduler**: Laravel Task Scheduling
- **Testing**: PHPUnit

---

## Installation
bash:
git clone https://github.com/mohamed-elabyad/events-management.git
cd events-management
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
---

Configure your .env file with:

Database credentials
Mailtrap SMTP settings for testing emails

---

## API Routes:
### Authentication:

POST /register → Register a new user.

POST /login → Login & receive API token.

POST /logout → Logout and revoke tokens (requires auth).

---

### Events:

GET /events → List events (supports ?include=owner,attendees).

GET /events/{id} → Show event details (with optional include).

POST /events → Create event (auth required).

PUT /events/{id} → Update event (auth + owner only).

DELETE /events/{id} → Delete event (auth + owner only).

### Attendees:

GET /events/{event}/attendees → List event attendees.

GET /events/{event}/attendees/{id} → Show attendee.

POST /events/{event}/attendees → Join event (auth required).

DELETE /events/{event}/attendees/{id} → Cancel attendance (auth + owner only).

---

## Scheduled Jobs:

Custom command: php artisan events:send-reminders

Runs daily via Laravel Scheduler.

Sends reminder emails to all attendees for events happening within 24 hours.

Uses Mailtrap for testing in development.

---

## Project Structure (Key Parts):

app/Http/Controllers/Api → Controllers for events, attendees, and auth.

app/Policies → Event & Attendee authorization logic.

app/Notifications → EventReminder notification class (email).

routes/api.php → Defines public and protected API routes.

routes/console.php → Scheduler & custom commands.

app/Traits/HasLoadRelations.php → Utility for dynamic relation loading with ?include.

---

## License:

This project is open-source under the MIT License.

---

## Made with ❤️ by Mohamed Elabyad
If you have any questions or want to get in touch, feel free to reach out:
📧 Email: m.elabyad.work@gmail.com

