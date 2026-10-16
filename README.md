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

## End 2 End tests

### Running the frontend dev server

Install the JS dependencies with `bun install`, then the browser dependencies with `bun run playwright install`.

Then run the test suite with `bun run playwright test`.

Or you can use mise to do all the above, with `mise test-e2e`

## Building the frontend

The Frontend application is entirely statically buildable. You can build the output for deployment by using `bun build frontend/index.html --outdir=out`. You can also use `mise build-frontend` to build it into the local `public/` directory that is served up by the PHP dev application server. In other words - you can build it and run it as it would be in production.
