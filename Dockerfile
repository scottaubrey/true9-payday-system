FROM php:8.5.12-cli-alpine AS backend-base
RUN mkdir /app
WORKDIR /app

FROM backend-base AS backend-deps
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
RUN composer install

FROM backend-deps AS backend-deps-prod
RUN composer install --no-dev --optimize-autoloader


FROM backend-base AS backend
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY --from=backend-deps-prod /app/vendor/ vendor/
COPY app.php app.php
COPY src/ src/
COPY public/ public/
ENV PHP_CLI_SERVER_WORKERS=4
CMD [ "php", "-S", "0.0.0.0:8888", "-t", "public/", "app.php" ]

FROM backend AS backend-dev
COPY --from=backend-deps /app/vendor/ vendor/
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
COPY phpunit.xml phpunit.xml
COPY mago.toml mago.toml
COPY tests/ tests/


FROM oven/bun:1.4.3-alpine AS frontend-base
RUN mkdir /app
WORKDIR /app

FROM frontend-base AS frontend-deps
COPY package.json package.json
COPY bun.lock bun.lock
RUN bun install -p

FROM frontend-deps AS frontend
COPY --from=frontend-deps /app/package.json package.json
COPY --from=frontend-deps /app/bun.lock bun.lock
COPY --from=frontend-deps /app/node_modules node_modules
COPY frontend/ frontend/
COPY bunfig.toml bunfig.toml
RUN bun build frontend/index.html --minify --outdir=dist/

FROM frontend AS frontend-dev
RUN bun install
COPY biome.json biome.json
CMD [ "bun", "test" ]

FROM backend AS production
COPY --from=frontend /app/dist/* /app/public/
RUN echo "expose_php = off" > /usr/local/etc/php/conf.d/remove_php_header.ini
