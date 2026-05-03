# JeuNova – Docker Deployment Guide

## Prerequisites on the VPS
```bash
sudo apt-get update && sudo apt-get install -y docker.io docker-compose-plugin git
sudo systemctl enable --now docker
```

---

## 1. Copy the project to the VPS

```bash
# Option A – clone from your repo
git clone https://github.com/your-org/jeunova.git /srv/jeunova

# Option B – rsync from your machine
rsync -avz --exclude='.git' ./jeunova/ user@your-vps-ip:/srv/jeunova/
```

---

## 2. Start the stack

```bash
cd /srv/jeunova
docker compose up -d --build
```

The first boot imports `config/jeunova.sql` automatically.  
**This only runs once**; if you need to re-import, delete the volume first (see below).

---

## 3. Verify

```bash
# Check containers are healthy
docker compose ps

# Tail app logs
docker compose logs -f app

# Quick connectivity check
curl -I http://localhost:5000
```

---

## 4. Connect Nginx (on the host) as a reverse proxy

Add a server block to your Nginx config (e.g. `/etc/nginx/sites-available/jeunova`):

```nginx
server {
    listen 80;
    server_name your-domain.com;

    # Optional: redirect HTTP → HTTPS (add after certbot setup)
    # return 301 https://$host$request_uri;

    location / {
        proxy_pass         http://127.0.0.1:5000;
        proxy_http_version 1.1;
        proxy_set_header   Host              $host;
        proxy_set_header   X-Real-IP         $remote_addr;
        proxy_set_header   X-Forwarded-For   $proxy_add_x_forwarded_for;
        proxy_set_header   X-Forwarded-Proto $scheme;
        proxy_read_timeout 60s;
        client_max_body_size 20M;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/jeunova /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

---

## 5. Useful maintenance commands

| Task | Command |
|------|---------|
| Stop the stack | `docker compose stop` |
| Restart after code change | `docker compose up -d --build app` |
| View real-time logs | `docker compose logs -f` |
| Enter PHP container | `docker exec -it jeunova_app bash` |
| Enter DB container | `docker exec -it jeunova_db mariadb -u root jeunova` |
| Reset DB (re-import SQL) | `docker compose down -v && docker compose up -d --build` |
| Check memory usage | `docker stats --no-stream` |

---

## Memory budget (estimated)

| Service | Limit | Typical usage |
|---------|-------|---------------|
| MariaDB | 256 MB | ~100–150 MB |
| PHP+Apache | 256 MB | ~60–120 MB |
| OS + Docker | — | ~200–300 MB |
| **Total** | **< 700 MB** | well within 1 GB + 4 GB swap |

---

## Local XAMPP development

`config/db.php` still works with XAMPP — when `DB_HOST` env var is absent it falls
back to `localhost`, so no local config changes are needed.
