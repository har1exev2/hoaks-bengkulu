FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY . /app

RUN chmod +x /app/docker-entrypoint.sh \
    && mkdir -p /data

EXPOSE 8080

ENTRYPOINT ["/app/docker-entrypoint.sh"]
