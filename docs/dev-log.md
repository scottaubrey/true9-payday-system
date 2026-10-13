# Initial Commit

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
