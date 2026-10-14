# G1 Codex–Executor broker smoke — disposable fixture baseline

**Classification:** source-only preparation, not an autonomous PCP benchmark or a live DDEV acceptance.

## Pinned source identity

- Branch: `benchmark/g1-codex-smoke-v1`, derived from immutable
  `benchmark/fullpath-v2@3165b76d44b738c4709c3ca74f87297ff66dd397`.
- This branch is a **new disposable fixture**, not an amendment to the historic
  F2-T01 source seed or its already reviewed Draft PR #4.
- Expected PCP project id: `pcp-benchmark-g1-smoke`.
- No direct/global/shared project, Chợ Nhạc, production, or legacy PCP access.

## Fixture requirements

- Dedicated DDEV project `pcp-g1-codex-smoke`, PHP 8.4 / Drupal 11,
  MariaDB 10.11, Node 24, no project hooks or Docker compose add-ons.
- The Executor's approved `trusted_codex_tools` phases are fixed argv
  (not supplied by the model):
  - `targeted_tests`: `ddev exec php ../vendor/bin/phpunit -c core/phpunit.xml.dist modules/custom/pcp_f2_fixture/tests/src/Unit`
  - `static_analysis`: `ddev exec php ../vendor/bin/phpcs --standard=Drupal modules/custom/pcp_f2_fixture`
  - `frontend_quality`: `ddev exec npm --prefix .. run build`
- A disposable environment may require Composer dependency installation in an
  **operator-controlled setup phase**, before any Codex broker tool call.
- `npm --prefix .. run build` only checks Node runs, that an immutable PHP
  source is present and outputs `G1_NODE_BUILD_CHECK=PASS`. It is *not* a
  substitute for a real front-end build or browser/visual verification.
- A read-only check must demonstrate that the actual DDEV web container has no
  Docker socket, no privileged control/GitHub secrets, no dangerous DDEV host
  hooks, and only explicitly admitted networks/origins. **Do not presume
  baseline config alone proves running-container isolation.**

## Acceptance sequence

1. Set up **one new isolated** source clone, job workspace, credentials and
   Executor/Runtime deployment independent of historic F2 C2 DB. Verify pinned
   SHA, no active/foreign writer, zero secrets leaked and a strictly time-limited
   token scoped to the one benchmark job; don't enable this on the legacy stack.
2. Verify Codex CLI MCP configuration and its stdio tool handshake without
   spending a model call. Verify a single narrowed Executor phase request,
   absence of Docker socket and no ability to run shell/other-project commands.
3. Only with an independently confirmed positive readiness result: optionally
   execute one newly accepted source task for Codex vs direct, from two fresh
   workspaces at the same task/quality/model/effort/source baseline. Record
   time-to-accepted, tokens, real provider accounting if available, CI/head and
   total Owner interventions. One smoke pair does **not** prove p50/p90.
4. Shut down/discard only disposable smoke resources and revoke the scoped
   capability when its job ends; token deadline alone is not immediate revocation.

**Do not activate automatically from this document, branch creation or CI.**
G0 remains HOLD/NOT GO. Historical F2 job remains blocked 2/2 model calls.
