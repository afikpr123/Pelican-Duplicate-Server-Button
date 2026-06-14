# 🚀 Pelican Duplicate Server Plugin

A powerful plugin for **Pelican Panel** that allows administrators to duplicate existing servers with a single click.

Designed for game hosting providers and community owners who frequently create multiple servers with identical configurations.

---

## ✨ Features

* 📋 Duplicate existing servers directly from the Admin Panel
* 🌐 Automatically assigns a new allocation
* 👤 Preserves server owner
* 🥚 Copies Egg configuration
* ⚙️ Copies startup settings
* 💾 Copies resource limits
* 🔑 Copies environment variables
* 📂 Duplicates server files
* 🔒 Prevents allocation conflicts
* 🎨 Simple Filament-based interface

---

## 📸 Preview

After installation a new **Duplicate Server** page will appear in the Pelican Admin Panel.

1. Select a source server
2. Select a free allocation
3. Choose a new server name
4. Click **Duplicate Server**

The plugin will automatically create a fully functional copy of the original server.

---

## 📦 Requirements

* Pelican Panel
* Wings
* PHP 8.2+
* Linux host
* Root access for initial setup

---

## ⚙️ Installation

### 1. Upload the plugin

Extract the plugin into:

```text
/var/www/pelican/plugins/duplicate-server
```

### 2. Install the plugin

```bash
cd /var/www/pelican

php artisan p:plugin:install
php artisan optimize:clear
```

### 3. Configure sudo permissions

Edit sudoers:

```bash
sudo visudo
```

Add:

```text
www-data ALL=(root) NOPASSWD: /bin/cp, /bin/chown, /bin/rm
```

### 4. Restart services

```bash
systemctl restart php8.5-fpm
systemctl restart nginx
systemctl restart wings
```

---

## 🛠 How It Works

Unlike database-only cloning solutions, this plugin uses Pelican's native:

```php
ServerCreationService
```

which ensures that:

* The server is properly registered with Wings
* Websocket support works correctly
* Allocations are assigned safely
* Environment variables are validated
* Pelican remains fully aware of the new server

After creation, the plugin copies the source server files into the newly generated UUID directory.

---

## 🔒 Security Notice

The plugin requires elevated permissions to duplicate server files.

Only the following commands are allowed:

```text
/bin/cp
/bin/chown
/bin/rm
```

through a restricted sudo configuration.

---

## 🐛 Known Limitations

* Source and target allocations must be on the same node.
* Large server directories may take longer to duplicate.
* Active server processes should be stopped before duplication for best results.

---

## 📝 Changelog

### v0.1.0

* Initial release
* Server duplication support
* Environment variable cloning
* Allocation selection
* File duplication support
* Pelican native server creation integration

---

## ❤️ Credits

Developed by **Dipsy**

Built for the Pelican hosting community.
