---
title: Official Docker images
sidebarDepth: 3
---

# Offizielle Docker Images

Castopod erstellt während des automatischen Build-Prozesses 3 Docker-Images auf
Docker Hub:

- [**`castopod/castopod`**](https://hub.docker.com/r/castopod/castopod): Ein
  umfassendes Castopod Image mit Nginx als Webserver
- [**`castopod/app`**](https://hub.docker.com/r/castopod/app): Das App Paket mit
  allen Castopod Abhängigkeiten
- [**`castopod/web-server`**](https://hub.docker.com/r/castopod/web-server): Ein
  Nginx Webserver für Castopod
- [**`castopod/video-clipper`**](https://hub.docker.com/r/castopod/video-clipper):
  Ein optionales Image, das dank ffmpeg Videoclips erstellt

Außerdem benötigt Castopod eine MySQL-kompatible Datenbank. Eine Redis-Datenbank
kann als Cache-Handler hinzugefügt werden.

## Unterstützte Tags

- `develop` [unstable], neueste Updates des development Branches
- `beta` [stable], neueste Beta-Version
- `1.0.0-beta.x` [stable], spezifischer Beta-Version Build (seit
  `1.0.0-beta.22`)
- `latest` [stable], die neuste Version
- `1.x.x` [stable], spezifische Version (seit `1.0.0`)

## Beispiel

1.  Installiere [Docker](https://docs.docker.com/get-docker/) und
    [Docker-Compose](https://docs.docker.com/compose/install/)
2.  Erstelle eine `docker-compose.yml` Datei mit folgendem Inhalt:

    ```yml
    version: "3.7"

    services:
      app:
        image: castopod/app:latest
        container_name: "castopod-app"
        volumes:
          - castopod-media:/var/www/castopod/public/media
        environment:
          MYSQL_DATABASE: castopod
          MYSQL_USER: castopod
          MYSQL_PASSWORD: changeme
          CP_BASEURL: "https://castopod.example.com"
          CP_ANALYTICS_SALT: changeme
          CP_CACHE_HANDLER: redis
          CP_REDIS_HOST: redis
        networks:
          - castopod-app
          - castopod-db
        ports:
          - 8000:8000
        restart: unless-stopped

      mariadb:
        image: mariadb:10.5
        container_name: "castopod-mariadb"
        networks:
          - castopod-db
        volumes:
          - castopod-db:/var/lib/mysql
        environment:
          MYSQL_ROOT_PASSWORD: changeme
          MYSQL_DATABASE: castopod
          MYSQL_USER: castopod
          MYSQL_PASSWORD: changeme
        restart: unless-stopped

      redis:
        image: redis:7.0-alpine
        container_name: "castopod-redis"
        volumes:
          - castopod-cache:/data
        networks:
          - castopod-app

    volumes:
      castopod-media:
      castopod-db:
      castopod-cache:

    networks:
      castopod-app:
      castopod-db:
    ```

    Es müssen einige Variablen an deine Bedürfnisse angepasst werden (z.B.
    `CP_BASEURL`, `MYSQL_ROOT_PASSWORD`, `MYSQL_PASSWORD` und
    `CP_ANALYTICS_SALT`).

3.  Einen Reverse-Proxy für TLS (SSL/HTTPS) einrichten

    TLS ist notwendig damit ActivityPub korrekt arbeiten kann. Dieser Job kann
    leicht von einem Reverse-Proxy bearbeitet werden, zum Beispiel mit
    [Caddy](https://caddyserver.com/):

    ```
    #castopod
    castopod.example.com {
        reverse_proxy localhost:8000
    }
    ```

4.  Führe `docker-compose up -d` aus, warte darauf, dass es initialisiert wird
    und gehe auf `https://castopod.example.com/cp-install` um die Einrichtung
    von Castopod abzuschließen!

5.  Ist alles da? Dann kann das Podcasten beginnen! 🎙️🚀

## Umgebungsvariablen

- **castopod/video-clipper**

  | Variablennamen             | Typ (`Standard`) | Standardwert     |
  | -------------------------- | ---------------- | ---------------- |
  | **`CP_DATABASE_HOSTNAME`** | ?string          | `"mariadb"`      |
  | **`CP_DATABASE_NAME`**     | ?string          | `MYSQL_DATABASE` |
  | **`CP_DATABASE_USERNAME`** | ?string          | `MYSQL_USER`     |
  | **`CP_DATABASE_PASSWORD`** | ?string          | `MYSQL_PASSWORD` |
  | **`CP_DATABASE_PREFIX`**   | ?string          | `"cp_"`          |

- **castopod/castopod** and **castopod/app**

  | Variablennamen                        | Typ (`Standard`)        | Standardwert      |
  | ------------------------------------- | ----------------------- | ----------------- |
  | **`CP_BASEURL`**                      | string                  | `nicht definiert` |
  | **`CP_MEDIA_BASEURL`**                | ?string                 | `CP_BASEURL`      |
  | **`CP_ADMIN_GATEWAY`**                | ?string                 | `"cp-admin"`      |
  | **`CP_AUTH_GATEWAY`**                 | ?string                 | `"cp-auth"`       |
  | **`CP_ANALYTICS_SALT`**               | string                  | `nicht definiert` |
  | **`CP_DATABASE_HOSTNAME`**            | ?string                 | `"mariadb"`       |
  | **`CP_DATABASE_NAME`**                | ?string                 | `MYSQL_DATABASE`  |
  | **`CP_DATABASE_USERNAME`**            | ?string                 | `MYSQL_USER`      |
  | **`CP_DATABASE_PASSWORD`**            | ?string                 | `MYSQL_PASSWORD`  |
  | **`CP_DATABASE_PREFIX`**              | ?string                 | `"cp_"`           |
  | **`CP_CACHE_HANDLER`**                | [`"file"` or `"redis"`] | `"file"`          |
  | **`CP_REDIS_HOST`**                   | ?string                 | `"localhost"`     |
  | **`CP_REDIS_PASSWORD`**               | ?string                 | `null`            |
  | **`CP_REDIS_PORT`**                   | ?number                 | `6379`            |
  | **`CP_REDIS_DATABASE`**               | ?number                 | `0`               |
  | **`CP_EMAIL_SMTP_HOST`**              | ?string                 | `nicht definiert` |
  | **`CP_EMAIL_FROM`**                   | ?string                 | `nicht definiert` |
  | **`CP_EMAIL_SMTP_USERNAME`**          | ?string                 | `"localhost"`     |
  | **`CP_EMAIL_SMTP_PASSWORD`**          | ?string                 | `null`            |
  | **`CP_EMAIL_SMTP_PORT`**              | ?number                 | `25`              |
  | **`CP_EMAIL_SMTP_CRYPTO`**            | [`"tls"` or `"ssl"`]    | `"tls"`           |
  | **`CP_ENABLE_2FA`**                   | ?boolean                | `nicht definiert` |
  | **`CP_MEDIA_FILE_MANAGER`**           | ?string                 | `nicht definiert` |
  | **`CP_MEDIA_S3_ENDPOINT`**            | ?string                 | `nicht definiert` |
  | **`CP_MEDIA_S3_KEY`**                 | ?string                 | `nicht definiert` |
  | **`CP_MEDIA_S3_SECRET`**              | ?string                 | `nicht definiert` |
  | **`CP_MEDIA_S3_REGION`**              | ?string                 | `nicht definiert` |
  | **`CP_MEDIA_S3_BUCKET`**              | ?string                 | `nicht definiert` |
  | **`CP_MEDIA_S3_PROTOCOL`**            | ?number                 | `nicht definiert` |
  | **`CP_MEDIA_S3_PATH_STYLE_ENDPOINT`** | ?boolean                | `nicht definiert` |
  | **`CP_MEDIA_S3_KEY_PREFIX`**          | ?string                 | `nicht definiert` |
  | **`CP_DISABLE_HTTPS`**                | ?[`0` or `1`]           | `undefined`       |
  | **`CP_MAX_BODY_SIZE`**                | ?number (with suffix)   | `512M`            |
  | **`CP_PHP_MEMORY_LIMIT`**             | ?number (with suffix)   | `512M`            |
  | **`CP_TIMEOUT`**                      | ?number                 | `900`             |

- **castopod/web-server**

  | Variablennamen         | Typ                   | Standardwert |
  | ---------------------- | --------------------- | ------------ |
  | **`CP_APP_HOSTNAME`**  | ?string               | `"app"`      |
  | **`CP_MAX_BODY_SIZE`** | ?number (with suffix) | `512M`       |
  | **`CP_TIMEOUT`**       | ?number               | `900`        |
