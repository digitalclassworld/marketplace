# Digital Class Marketplace

A modern, multi-vendor digital education and services marketplace platform built with **Laravel 11**, **MySQL**, and **Bootstrap 5**.

---

## 🚀 Key Modules & Architecture

### 1. 🏪 Seller Portal
- **Dashboard**: Real-time sales metrics, revenue KPIs, order graphs, and store preview.
- **Listings Builder (7-Step Wizard Architecture)**:
  - **Courses**: Online courses, lesson curriculum, pricing, video previews, and certificates.
  - **Services**: Freelance service packages, delivery turnarounds, and consultation booking.
  - **Products**: Physical items & digital downloadable products with inventory tracking.
  - **Business Directory Listings**: Complete business profile with verified badges, Google Maps location, and inquiry tracking.
- **Orders Management**: Order pipeline with category tabs (`Courses`, `Services`, `Products`, `Business`), item drawer, delivery timeline, and simulation tool.
- **Customer Messages & Chat**: 3-column messenger with customer inquiries, quick actions (*Send Brochure / PDF*, *Share Coupon*), and conversation summary.
- **Promotions & Marketing**: Multi-tier seller advertising:
  - 👑 **Featured Listing** (₹1,000)
  - 🖼️ **Homepage Banner Promotion** (₹1,500)
  - 🏷️ **Flash Sale Discount Offer** (₹1,000)
  - 🔗 **Social Media Creatives Kit** (₹2,000)
  - ✉️ **Weekly Newsletter Email Campaign** (₹2,500)

### 2. 🛡️ Super Admin Portal
- **Platform Analytics**: Total marketplace GMV, active sellers, and catalog approval queues.
- **Seller Verification**: Review PAN/GST registration documents with fast **Approve** / **Reject** workflows.
- **Catalog Verification Workflow**: Review and approve courses, services, and directory listings before publishing.
- **Platform-wide Chat Monitoring**: Super Admin audit view to inspect all customer-seller conversations and post moderation warnings.
- **Marketing Revenue Oversight**: Track advertising fee collections and campaign placements.

---

## 🛠️ Tech Stack & Requirements

- **PHP**: 8.2+
- **Framework**: Laravel 11.x
- **Database**: MySQL 8.0+
- **Frontend**: Blade, Bootstrap 5.3, FontAwesome 6, Google Fonts (*Outfit* & *Plus Jakarta Sans*)
- **Vite**: Asset bundling

---

## ⚙️ Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/digitalclassworld/marketplace.git
   cd marketplace
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` to match your MySQL server.*

4. **Run Database Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```
   *(Populates Super Admin, demo sellers, catalog, orders, chat messages, and promotions in one command.)*

5. **Start Local Development Server**:
   ```bash
   php artisan serve
   ```
   *Visit `http://127.0.0.1:8000` in your web browser.*

> [!TIP]
> For production deployment instructions on **Linux VPS (Ubuntu/Nginx/Apache)** and **cPanel Shared Hosting**, please refer to [DEPLOYMENT.md](DEPLOYMENT.md).

---

## 👥 Default Demo Credentials

| Role | Email | Password | Access URL |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@gmail.com` | `Admin@123` | `/admin/dashboard` |
| **Verified Seller** | `shop911@gmail.com` | `Seller@123` | `/seller/dashboard` |
| **Seller 2** | `seller23@gmail.com` | `Seller@123` | `/seller/dashboard` |

---

## 📄 License
Proprietary software for Digital Class Marketplace. All rights reserved.
