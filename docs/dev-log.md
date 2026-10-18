## Initial Commit

Create basic scaffolding for a project. Copy spec PDF, create a README (part of spec)

## Understanding the requirements, assumptions and decisions - Backend

The document is intentionally vague, so I will document here my understanding.

- There is a requirement to make the development environment reproducible. I will lean heavily on mise to get started, and circle back to docker if time allows.
- Architecturally there are essentially 2 application environments: backend and frontend. I will focus on the backend to start with.
- It would be useful to demonstrate proficiency for this role by using PHP
- The scope is currently incredibly small, so using libraries where possible.
  - I will use SlimPHP (a framework leaning heavily on PHP-FIG PSRs for HTTP)
  - I will use Pest to write tests.
  - Code quality matters, so I will use mago to enforce linting, formatting and some static checks
- The root will contain the mise and the PHP project bootstrap
- Any helpful commands will use mise tasks, and separately be documented in the README.md

setup basic structure:

- run `mise use --pin php mago`
- run `composer init`
- run `composer require slim/slim slim/psr7` and `composer require --dev pestphp/pest`
- create `public/`, `src/`
- run `mago init` and `pest init`
- create `app.php`
- Setup mise commands for `mise check`, `mise test` and `mise start`

## Frontend

Options:

1. Server-side rendered HTML from PHP server
2. Static HTML page with JS
3. Bundled HTML page with JS
4. React-based SPA

I chose 4) with BunJS because of it's batteries included approach to this kind of problem.

I will write a server that proxies to the PHP backend in dev, and a build process that will output to the public folder, allowing the PHP server to serve it up.

Setup basic structure:

- run `mise use --pin bun`
- run `bun add react react-dom @picocss/pico` and `bun add -d @types/react @types/react-dom`
- add `DOM` to tsconfig.json libs
- setup mise commands for `mise check-frontend`, `mise test-frontend` and `mise start-frontend`
- create a basic HTML page, index module to load react and Pico CSS, App module to output basic page structure
- For the developer experience - create `server.ts` that would use HMR to create a fast dev experience, and proxy to a running PHP server.

## E2E testing

I decided to go with playwright as it is a well supported, feature rich testing framework for end to end testing in a real browser suite.

This will run on BunJS, so only required the extra dependencies.

Setup:

- run `bun add @playwright/test -D`
- create `playwright.config.ts` from config, create `e2e` dir
- setup mise commands

## CI/CD

After getting to a fairly usable state, I started looking to deployment. Firstly - a deployment artifact. I chose to create a docker image as an output. This will combine the PHP application with the client-side build output of the bun frontend.

Next, an automated builder to enforce checks and create and publish build artifact ready for deployment. I chose github actions, as this is easy to use, free for public repos and have the github container repository integration that meant I don't need to deal with any credentials. This runs on every push to main to support a trunk-based development workflow.

Final step is continuous deployment. I reused existing infrastructure I have (a private kubernetes cluster with Flux CD). I published the deployment configuration in `deployment/` and imported this into my cluster. I then used my cloudflare integrated ingress controller to publish this at [payday.aubrey.org.uk](https://payday.aubrey.org.uk) via cloudflare tunnels.

The combination works to:

1. Run all checks, tests, frontend, backend and playwright test, in parallel.
2. build a docker image and publish this to `ghcr.io/scottaubrey/true9-payday-system`
3. detect the image push and deploy to the cluster, exposed via cloudflare tunnel to [payday.aubrey.org.uk](https://payday.aubrey.org.uk)

## Development process

I have adopted many of the practices that originated in the XP community, in particular Test-driven development, where a test is created before working code to express a small aspect of behaviour I intend to see, then an implementation is written, then I look for refactor opportunities, leaning on the tests to ensure external behaviour doesn't change (red/green/refactor loop). I also adopt the continuous integration rule of never heaving an unbuildable mainline, and a micro-commit style, where each of these steps in the red/green/refactor loop is committed. All these practices are held together by being able to mark a test as expected to fail, and so there is a small helper function for pest to expect more than just expectation failures to faciliate this style.

I used the outside-in (London-style) TDD approach, starting at the API boundary, finding collaborators as I went. I built the UI in a inside-out approach (Detroit-style), starting with components and building out of the UI and API client as needed.

After final reviews, I decided to expand my definition of working days from purely weekdays to incorporate public holidays in the UK. I used and integrated library to do this, and after reviewing a few decided on `azuyalabs/yasumi` as a purely-calculation based library. Again, adopting a red/green/refactor loop to write the expected new behaviours, then adopt the library without changing behaviour. I added new tests to cover expected functionality and moved to the new library through red/green/refactor process.
