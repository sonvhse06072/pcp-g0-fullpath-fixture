# PCP F2 — isolated Drupal 11 direct-intake fixture

Private **source-only** benchmark fixture for [Personal Coding Platform G0-02](https://github.com/sonvhse06072/personal-coding-platform/issues/595).

This is a **new independent business-neutral problem**, not the G0D-T01 EventLabelNormalizer fixture or a copy of its code, trial, workspace, or seed. It has its own PHP class, Drupal service, tests, work order, Git commit and benchmark branch. Only third-party Drupal dependency versions/lock are carried forward from the previously CI-validated Drupal 11 toolchain, to avoid unstable package resolution. No G0D-T01 source changes or old benchmark branches are made.

## Baseline functionality

Module `pcp_f2_fixture` exposes `pcp_f2_fixture.window_overlap`, with `WindowOverlapDetector::intersects()`. Initial implementation handles **same-day half-open minute intervals** and rejects invalid windows. Unit and Drupal Kernel tests prove this simple baseline.

[Proposed F2-T01 acceptance contract](docs/F2-T01.md) describes a **separate future change** to support crossing midnight; it is deliberately **not implemented** in the immutable initial seed.

## Verification (GitHub-hosted; no local DDEV or provider)

The `validation` workflow runs locked Composer installation, PHP syntax, Drupal PHPCS, Unit and real Drupal Kernel tests on ephemeral `ubuntu-24.04`. It has read-only `GITHUB_TOKEN`, no secrets, no self-hosted runner, no Docker socket bind, and no deploy job.

Do not treat hosted CI or this README as PCP full-path operation. No Runtime/Executor/provisioning/model/credential activation is implied by this repository. The separately approved ProjectBaseline revision, fresh PostgreSQL/volume/UID, GitHub delivery token and provider egress remain gated in PCP #595.

## Branch discipline

- `main`: reviewed fixture implementation.
- `benchmark/fullpath`: immutable seed for **new** F2 future tickets, created only after baseline PR passes hosted CI and is accepted.
- `ai/*`: candidate implementations through PR + exact-head CI, never direct push to baseline.

**DO NOT** reuse or modify `pcp-g0-drupal-fixture` branches `benchmark/direct` or `benchmark/pcp`, PR #4/#5, historical G0D-T01 journals, or any Chợ Nhạc worktree.
