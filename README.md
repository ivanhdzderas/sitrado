# Sitrado

**Internal management platform for consulting firms**: controlled documents with approval workflows, meetings and minutes, projects with Gantt charts, and 8D problem-solving analysis, all in one web app.

Built with **PHP 8 · CodeIgniter 4 · MySQL · Bootstrap · jQuery**.

---

## Why it exists

Quality-certified organizations (ISO-style management systems) need to prove that every procedure, policy and form is controlled: who requested a change, who approved it, who has read the current version, and what was agreed in each meeting. Sitrado replaces the shared folders, spreadsheets and email threads usually used for this with a single system that tracks the whole lifecycle.

## Features

### Document control
- Documents organized in a configurable **hierarchy of groups, subgroups and menus**.
- **Change request workflow**: request → review → approval, with configurable approvers per document and status tracking.
- **Per-user and per-document permissions** (read / download / manage).
- **Read receipts**: the system records who has viewed each document version.
- Built-in viewer, search, downloads and an archive of deleted documents.

### Meetings and minutes
- Schedule meetings with participants, agenda topics and meeting-room reservations.
- Capture **minutes** during the meeting: agreements, owners and due dates.
- Follow-up of **pending agreements** with alerts, rescheduling, and minutes exported to **PDF** and sent by **email**.

### Projects
- Projects and subprojects with task assignment and team workload view.
- **Gantt chart** of activities and dates, notes and attachments per project.

### Continuous improvement
- **8D analysis** (problem-solving method used in quality management): team, temporary, permanent and preventive solutions, plus verification.
- Improvement proposals and **business cases** with alternatives.

### Administration
- Multi-company setup, users with levels, and dynamic menus per role.
- Company announcements with read tracking, shared calendar and attendance log.
- Reports exported to Excel and PDF, with charts.

## Tech stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2+, CodeIgniter 4.7 (MVC, Query Builder, sessions, CSRF) |
| Database | MySQL 8 / MariaDB (51 tables, schema in [`database/schema.sql`](database/schema.sql)) |
| Frontend | Bootstrap, jQuery, DataTables, Select2, SweetAlert2, jQuery Validate |
| Documents & reports | FPDF (PDF), PHPExcel (Excel), JpGraph (charts) |
| Email | PHPMailer over SMTP |
| Security | `password_hash` / `password_verify`, CSRF protection, credentials kept in `.env` |

## Getting started

**Requirements:** PHP 8.2+ (with `intl`, `mbstring`, `mysqli`), Composer, MySQL 8.

```bash
git clone https://github.com/ivanhdzderas/sitrado.git
cd sitrado
composer install

# Configuration
cp env .env
```

Edit `.env`:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = 127.0.0.1
database.default.database = sitrado
database.default.username = root
database.default.password =

# Optional: SMTP used for meeting minutes and access notifications
email.smtpHost  = smtp.example.com
email.smtpUser  = notifications@example.com
email.smtpPass  = your-password
email.fromEmail = notifications@example.com
```

Create the database and load the schema:

```bash
mysql -u root -e "CREATE DATABASE sitrado CHARACTER SET utf8mb4"
mysql -u root sitrado < database/schema.sql
```

Create the first user (passwords are stored with `password_hash`):

```bash
php -r "echo password_hash('ChangeMe123', PASSWORD_DEFAULT), PHP_EOL;"
```

```sql
INSERT INTO usuario (nombre, usuario, pass, tipo, juntas, img, plaza, departamento, puesto, nivel, correo, asistente, ingreso)
VALUES ('Admin', 'admin', '<hash from above>', '1', 'SI', '', 0, 'Admin', 'Admin', '1', 'admin@example.com', 0, '2026-01-01');
```

Run it:

```bash
php spark serve
```

Open http://localhost:8080 and sign in. Uploaded documents are stored in `public/archivos/`, which is intentionally not versioned.

## Project structure

```
app/
├── Config/        # Routes, database, filters
├── Controllers/   # Request handling
├── Models/        # Data access (Query Builder)
└── Views/         # Screens by module: archivos, juntas, proyectos, 8d, mejora...
database/
└── schema.sql     # Database structure (no data)
public/            # Web root: index.php, assets, PDF/Excel/mail libraries
```

## Roadmap

- Split the legacy `Login` controller, which still serves most routes, into one controller per module (`Documentos`, `Juntas`, `Proyectos`...), which are already scaffolded.
- Replace the bundled PHPExcel and PHPMailer copies with Composer packages (PhpSpreadsheet, PHPMailer 6).
- Convert `database/schema.sql` into CodeIgniter migrations and seeders with demo data.
- Feature tests for the document approval workflow.

## Author

**Ivan Hernandez** · Full-stack developer (PHP, .NET, JavaScript)
[GitHub](https://github.com/ivanhdzderas)
