# True9 "payroll" Technical Test

## Useful docs

- docs/T9-TECH-TEST-25 v1.0.pdf - Original spec.
- docs/dev-log.md - log of development commits, including assumptions and decisions

## Prerequisites

[`mise`](https://mise.jdx.dev) is used to setup the dev environment. Install all needed tools using:

```shell
mise install
```

(warning: PHP might be compiled from source. You will require build tools and libraries, see [here](https://github.com/version-fox/vfox-php#prerequirements))

Install the dependencies use `composer install`, or `mise build`

## Backend

### Running the backend dev server

run a PHP dev server using `php -S localhost:8888 -t public/ app.php`

or

use `mise start` to install dependencies and start the dev server

### Running pre-commit checks

Check source code formatting with `mago format`, check for source code issues with `mago lint`, and do deeper static analysis with `mago analyze`.

Run test suites with `./vendor/bin/pest`.

Or run all checks with `mise check`

## Frontend

### Running the front dev server

Run the Frontend dev server using `bun run frontend/server.ts`

or

use `mise start-frontend` to install dependencies and start the dev server.

NOTE: This will also run the PHP backend dev server.

### Running pre-commit checks

Check source code formatting with `biome format`, check for source code issues with `biome lint`, and do deeper static analysis with `biome check`.

Run test suites with `bun test frontend/`.

Or run all checks with `mise check-frontend`
