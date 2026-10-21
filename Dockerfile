FROM php:8.5.12-cli-alpine as backend-base
RUN mkdir /app
WORKDIR /app

FROM backend-base as backend-deps
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
RUN composer install

FROM backend-deps as backend-deps-prod
RUN composer install --no-dev --optimize-autoloader


FROM backend-base as backend
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY --from=backend-deps-prod /app/vendor/ vendor/
COPY app.php app.php
COPY src/ src/
COPY public/ public/
ENV PHP_CLI_SERVER_WORKERS=4
CMD [ "php", "-S", "0.0.0.0:8888", "-t", "public/", "app.php" ]

FROM backend as backend-dev
COPY --from=backend-deps /app/vendor/ vendor/
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
COPY phpunit.xml phpunit.xml
COPY mago.toml mago.toml
COPY tests/ tests/


FROM oven/bun:1.4.3-alpine AS frontend-base
RUN mkdir /app
WORKDIR /app

FROM frontend-base as frontend-deps
COPY package.json package.json
COPY bun.lock bun.lock
RUN bun install -p

FROM frontend-deps as frontend
COPY --from=frontend-deps /app/package.json package.json
COPY --from=frontend-deps /app/bun.lock bun.lock
COPY --from=frontend-deps /app/node_modules node_modules
COPY frontend/ frontend/
COPY bunfig.toml bunfig.toml
RUN bun build frontend/index.html --minify --outdir=dist/

FROM frontend as frontend-dev
RUN bun install
COPY biome.json biome.json
CMD [ "bun", "test" ]

FROM backend as production
COPY --from=frontend /app/dist/* /app/public/
