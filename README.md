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

## Backend

### Running the backend dev server

use `mise start-backend` to install dependencies and start the dev server on http://localhost:8888/.

You can test an api by hitting `http://localhost:8888/api/payday?month=10&year=2026`.

### Running pre-commit checks

Or run all checks with `mise check-backend`

## Frontend

### Running the front dev server

use `mise start-frontend` to install dependencies and start the dev server.

NOTE: This will also run the PHP backend dev server.

You can view the application by visiting `http://localhost:3000/`.

### Running pre-commit checks

Or run all checks with `mise check-frontend`

## End to End tests

Run a dev server and playwright end to end tests with `mise test-e2e`

## Building the frontend

The Frontend application is entirely statically buildable. You can build the output for deployment by using `bun build frontend/index.html --outdir=out`. You can also use `mise build-frontend` to build it into the local `public/` directory that is served up by the PHP dev application server. In other words - you can build it and run it as it would be in production.

## Docker image

CI runs on main commits to run all checks, tests and then builds a simple docker image and pushes to `ghcr.io/scottaubrey/true9-payday-system`. You can run this in a container runtime, for example with docker:

```
docker run --publish 8888:8888 -it ghcr.io/scottaubrey/true9-payday-system:latest
```
