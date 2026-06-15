# 🚀 Duplicate Server

A Pelican plugin that allows administrators to quickly duplicate existing servers from the Admin Panel.

The plugin creates a new server using Pelican's native server creation flow, ensuring full compatibility with Wings and websocket functionality.

## ✨ Features

* Duplicate existing servers
* Assign a new allocation during creation
* Preserve server owner
* Copy startup configuration
* Copy resource limits
* Copy environment variables
* Uses Pelican's native `ServerCreationService`
* Fully compatible with Wings
* Simple Filament-based interface

## 📦 Requirements

* Pelican Panel
* Wings
* PHP 8.2+

## 📸 Usage

1. Open **Admin Panel**
2. Navigate to **Duplicate Server**
3. Select the source server
4. Select a free allocation
5. Enter a new server name
6. Click **Duplicate Server**

The plugin will create a new server using the selected configuration.

## ⚠️ Important Notes

* The new allocation must belong to the same node as the source server.
* This plugin duplicates server configuration only.
* Server files are not copied.
* The duplicated server is created using Pelican's native server creation process.

## 🛠 Installation

1. Upload the plugin to your Pelican installation.
2. Install the plugin from the Plugins section.
3. Clear caches:

```bash
php artisan optimize:clear
```

4. Restart PHP-FPM and your web server if required.

## 🔒 Security

This plugin does not execute privileged system commands and does not modify system files.

## 📝 Changelog

### v1.0.1

* Marketplace compatibility improvements
* Removed local-only metadata
* Removed privileged file-copy operations
* Improved Pelican integration
* Uses native `ServerCreationService`

## ❤️ Author

Dipsy
