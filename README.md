# MediFlow

MediFlow is a Clinic Management Information System (SIM Klinik) built with Laravel 13.

The system is designed to help clinics manage patients, registrations, queues, medical examinations, medical records, billing, payments, and operational reporting through a simple and role-based workflow.

## Current Version

MVP Version

Roles:

* Admin
* Cashier
* Doctor

### Role Responsibilities

**Admin**

* Manage master data
* Manage registrations
* Manage queues
* Manage billing
* Manage pharmacy
* View reports
* Configure application settings

**Cashier**

* Manage invoices
* Process payments
* Approve and reject payments
* Handle refunds
* Open and close cashier shifts
* Perform daily cash reconciliation
* Generate cashier reports

**Doctor**

* Manage examinations
* Create medical records
* View patient medical history

---

## Features

### Authentication

* Login
* Logout
* Registration
* Email Verification
* Password Confirmation
* Profile Management
* Avatar Upload

### Authorization

* Role-Based Access Control (RBAC)
* Admin Role
* Doctor Role
* Cashier Role
* Role Middleware
* Laravel Policies

---

## Master Data

### Patient Management

* Create Patient
* Edit Patient
* Soft Delete Patient
* Restore Patient
* Force Delete Patient
* Medical Record Number (MRN) Generation
* Active / Inactive Status

### Doctor Management

* Create Doctor
* Edit Doctor
* Soft Delete Doctor
* Restore Doctor
* Force Delete Doctor
* Doctor Code Generation

### Polyclinic Management

* Create Polyclinic
* Edit Polyclinic
* Soft Delete Polyclinic
* Restore Polyclinic
* Force Delete Polyclinic

---

## Registration Module

* Patient Registration
* Registration Number Generation
* Automatic Polyclinic Assignment
* Complaint Recording
* Registration Status Management

Registration Status:

* Registered
* Completed
* Cancelled

---

## Queue Management

Queue is automatically generated after registration.

Features:

* Queue Number Generation
* Call Queue
* Start Examination
* Finish Examination
* Cancel Queue

Queue Workflow:

```text
waiting
   ↓
called
   ↓
in_progress
   ↓
done

or

waiting/called/in_progress
   ↓
cancelled
```

---

## Examination Module

Doctor Features:

* View Assigned Queues
* Start Examination
* Record Vital Signs
* Record Diagnosis
* Record Examination Notes
* Complete Examination

Medical Data:

* Chief Complaint
* Height
* Weight
* Blood Pressure
* Heart Rate
* Body Temperature
* Respiratory Rate
* Diagnosis
* Examination Notes

---

## Medical Records

* Automatic Medical Record Creation
* Medical Record History
* Doctor Medical Record Viewer
* Patient Medical History Tracking

---

## Billing & Payment

### Invoice Management

* Automatic Invoice Generation
* Invoice Number Generation
* Invoice Item Management
* Invoice Status Management
* Manual Discount
* Manual Tax Calculation

Invoice Status:

* Unpaid
* Paid
* Cancelled

### Payment Management

* Cash Payment
* Bank Transfer
* QRIS Payment
* Payment Approval Workflow
* Payment Rejection Workflow
* Payment Proof Upload
* Payment Reference Number
* Refund Management
* Cashier Tracking
* Automatic Invoice Settlement

Payment Status:

* Pending
* Paid
* Rejected
* Refunded

### Receipt

* Receipt View
* PDF Receipt Export

### Cashier Shift

* Open Cashier Shift
* Close Cashier Shift
* Expected Closing Balance
* Actual Closing Balance
* Difference Calculation
* Daily Cash Reconciliation
* Cashier Shift History

---

## Pharmacy

### Medication Management

* Medication CRUD
* Stock Adjustment
* Stock History
* Stock Movement Logging

---

## Reports

### Financial Report

* Revenue Summary
* Date Range Filtering
* PDF Export

### Registration Report

* Registration Statistics
* Doctor Filtering
* Polyclinic Filtering
* Date Range Filtering
* PDF Export

### Patient Report

* Gender Filtering
* Active Status Filtering
* PDF Export

### Medical Record Report

* Doctor Filtering
* Patient Filtering
* Date Range Filtering
* PDF Export

### Cashier Shift Report

* Shift Summary
* Cash Reconciliation Report
* Excel Export
* Daily Closing Report

---

## Activity Logging

System activities are automatically recorded.

Examples:

* User Created
* User Updated
* User Deleted
* Patient Created
* Registration Created
* Queue Updated
* Medical Record Created
* Invoice Updated
* Payment Recorded
* Payment Approved
* Payment Rejected
* Payment Refunded
* Cashier Shift Opened
* Cashier Shift Closed
* Medication Stock Adjusted
* SATUSEHAT Synchronization

---

## Media Library

* File Upload
* File Management
* Media Protection

---

## Settings

* Application Settings
* SATUSEHAT Configuration
* Organization Validation

---

## SATUSEHAT Integration

Current Foundation:

* OAuth Token Management
* Organization Validation
* Patient Synchronization
* Practitioner Synchronization

Planned:

* Encounter Integration
* Observation Integration
* Medication (KFA) Integration
* Prescription Integration

---

## Tech Stack

### Backend

* PHP 8.3
* Laravel 13
* MySQL

### Frontend

* Blade
* Tailwind CSS
* Alpine.js
* jQuery
* DataTables

### Reporting

* DomPDF
* Laravel Excel

---

## Packages

* spatie/laravel-permission
* spatie/laravel-activitylog
* spatie/laravel-medialibrary
* spatie/laravel-settings
* yajra/laravel-datatables
* maatwebsite/excel
* barryvdh/laravel-dompdf

---

## Installation

Clone repository:

```bash
git clone <repository-url>
cd mediflow
```

Install dependencies:

```bash
composer install
npm install
```

Create environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure database and run migrations:

```bash
php artisan migrate --seed
```

Create storage link:

```bash
php artisan storage:link
```

Run application:

```bash
php artisan serve
npm run dev
```

---

## Demo Accounts

### Admin

Email:

[admin@gmail.com](mailto:admin@gmail.com)

Password:

123456789

### Doctor

Create through admin panel.

---

## Project Status

Current Progress:

* Sprint 1: Master Data ✅
* Sprint 2: Registration & Queue ✅
* Sprint 3: Examination & Medical Records ✅
* Sprint 4: Billing Foundation ✅
* Sprint 5: Payment Workflow ✅
* Sprint 6: Reporting ✅
* Sprint 7: Pharmacy Foundation ✅
* Sprint 8: Cashier Management ✅
* Sprint 9: SATUSEHAT Foundation ✅

Current Completed Modules:

* Authentication
* Authorization (RBAC)
* Dashboard
* Users
* Patients
* Doctors
* Polyclinics
* Registrations
* Queues
* Examinations
* Medical Records
* Invoices
* Payments
* Refunds
* Receipts
* Cashier Shift Management
* Financial Reports
* Registration Reports
* Patient Reports
* Medical Record Reports
* Cashier Shift Reports
* Medication Management
* Activity Logs
* Media Library
* Application Settings
* SATUSEHAT Foundation

---

## Planned Features

### Phase 10

* KFA Medication Integration (Paused)
* SATUSEHAT Encounter Integration
* SATUSEHAT Observation Integration

### Phase 11

* Production Readiness
* BPJS Integration
* Laboratory Module
* Dashboard Analytics

### Future Roadmap

* Multi Doctor Scheduling
* Multi Branch Support
* Inventory Management
* Advanced Analytics
* REST API

---

## License

MIT License
