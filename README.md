# 🏥 Doctor Appointment Booking System

![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.x-orange?logo=mysql)
![HTML](https://img.shields.io/badge/HTML-5-E34F26?logo=html5&logoColor=white)
![CSS](https://img.shields.io/badge/CSS-3-1572B6?logo=css3&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?logo=tailwind-css)
![Brevo](https://img.shields.io/badge/Brevo-SMTP-blueviolet)
![Twilio](https://img.shields.io/badge/Twilio-SMS-red?logo=twilio)
![Apache](https://img.shields.io/badge/Apache-Server-D22128?logo=apache)
![License](https://img.shields.io/badge/License-MIT-green)


A full-stack **Doctor Appointment Booking System** built with **PHP, MySQL, and Tailwind CSS**, featuring a secure admin panel, real-time appointment management, email notifications via **Brevo**, and SMS alerts via **Twilio**.

---

## 🚀 Key Features

### 👤 Patient Features
- Browse doctors by specialty
- View available appointment slots
- Book appointments without registration
- Receive **email confirmation** after booking
- Receive **SMS notification** when appointment is approved
- View booking confirmation page

---

### 🛠️ Admin Features
- Secure admin authentication
- Add, edit, and manage doctors
- Create and manage time slots
- Approve or cancel appointments
- Automatic email & SMS notifications on approval
- Real-time appointment status updates

---

## 📧 Email & SMS Notifications

- **Email:** Brevo (SMTP, free tier)
- **SMS:** Twilio (free trial)
- Emails are sent:
  - On booking confirmation
  - On admin approval (optional extension)
- SMS is sent:
  - When admin approves an appointment

---

## 🧑‍💻 Tech Stack

| Layer | Technology |
|-----|-----------|
| Frontend | HTML, Tailwind CSS |
| Backend | PHP (Procedural) |
| Database | MySQL |
| Email | Brevo (SMTP + PHPMailer) |
| SMS | Twilio API |
| Auth | PHP Sessions |
| Server | Apache (XAMPP) |

---

## 📁 Project Structure

```text
doctor-appointment-system/
├── admin/
│   ├── auth.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── doctors.php
│   ├── add-doctor.php
│   ├── edit-doctor.php
│   ├── time-slots.php
│   ├── appointments.php
│   └── update-appointment-status.php
│
├── config/
│   ├── db.php
│   └── env.php
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── send-email.php
│   └── send-sms.php
│
├── assets/
│   ├── css/
│   └── images/
│
├── index.php
├── doctor.php
├── book.php
├── booking-success.php
├── login.php
├── logout.php
├── my-appointments.php
│
├── .env.example
└── README.md
```

---
## ⚙️ Installation & Setup

### 1️⃣ Clone Repository
```text
git clone https://github.com/badhonacharia/doctor-appointment-system.git
```
### 2️⃣  Move to Server Root
```text
xampp/htdocs/doctor-appointment-system
```

### 3️⃣ Create Database

- Create a MySQL database

- Import the provided SQL schema


### 4️⃣ Configure Environment

Create a .env file using .env.example

```text
BREVO_SMTP_HOST=
BREVO_SMTP_PORT=
BREVO_SMTP_USER=
BREVO_SMTP_PASS=

TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=
```

### 5️⃣ Update Database Connection

Edit:

```text
config/db.php
```

### 6️⃣ Run the Project
```text
http://localhost/doctor-appointment-system
```
---
## 🔐 Security Notes
- .env file is excluded from GitHub
- API keys are never hardcoded
- Admin authentication protected via middleware
- Prepared statements used to prevent SQL injection
---
## 🌱 Future Enhancements
- User registration & login
- OTP-based login via SMS
- Email approval notification
- PDF appointment receipt
- Role-based admin permissions
- Live deployment (VPS / shared hosting)
---

## ⚠️ Disclaimer


This project is intended for educational and demonstration purposes.
It is not a certified medical system.

---
## 👨‍💻 Author

**[Badhon Acharia](https://octteen.com/badhonacharia/)**

Web Developer | PHP | WordPress | Backend System

**[GitHub](https://github.com/badhonacharia/)**   **[Portfolio](https://octteen.com/badhonacharia/)**

---
