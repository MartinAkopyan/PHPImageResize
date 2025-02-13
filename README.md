# PHP Image Resizer

## 📌 Overview
This project is a **PHP-based image resizing application** that allows users to upload an image, resize it to multiple predefined dimensions, and download the resized images as a ZIP archive.  
The application is built with **PHP 8.1**, uses **Imagine Library** for image processing, and runs inside a **Dockerized environment** with **Nginx and PHP-FPM**.

---

## 🚀 Features
- ✅ Upload and resize images (JPEG, PNG)
- ✅ Choose multiple predefined sizes for resizing (200x200, 400x400, 600x600)
- ✅ Download resized images as a ZIP archive
- ✅ Automatically deletes temporary images after downloading
- ✅ Runs inside Docker with **PHP-FPM & Nginx**
- ✅ Uses **Imagine Library** for efficient image processing

---

## 🛠 How to Run  

1. Ensure that **Docker** and **Docker Compose** are installed.  
2. Clone the repository:  
   ```bash
   git clone git@github.com:MartinAkopyan/PHPImageResize.git
3. Navigate to the project directory
   ```bash
   cd martinakopyan-phptodoapp
4. Build and start the container:
   ```bash
   docker-compose up --build -d
5. Open the app in your browser:  
   👉 [http://localhost:8000](http://localhost:8000)
