---
name: deploy
description: Build the theme for production, write a commit message, commit (including dist/) and push the current branch so WP Pusher deploys it.
disable-model-invocation: true
argument-hint: "[optional commit message or hint]"
---

# Deploy: build → commit → push

Deployment is WP Pusher: it pulls the pushed branch, including the committed `dist/` build. Run these steps in order and stop at the first failure.

## 1. Preflight

- `git status -sb` and `git log --oneline @{u}..HEAD`.
- Stop if the branch is `main`. Ask before continuing.
- Stop if there is nothing to commit and nothing to push.
- If the branch is already ahead of the remote with commits you didn't make in this run, list them and ask before pushing them.
- Never merge, cherry-pick or push `parked/ci-github-actions` (parked GitHub Actions deploy, kept local on purpose).

## 2. Build

```sh
PATH=/usr/local/bin:$PATH npm run build
```

- `npm` is not on the default shell PATH, hence the prefix.
- `npm run build` checks the Node version, removes `dist/hot` and runs the production Vite build.
- If the build fails, show the error and stop. Don't commit.
- A running `vite dev` server doesn't need stopping. Remind the user that it rewrites `dist/hot` only on its next start.

## 3. Review what changed

- `git status --short` and `git diff --stat`.
- Read the source diff (not `dist/`) closely enough to write an accurate message.
- `dist/hot` must not be committed. If it exists, delete it.
- Flag anything that looks unintended (secrets, `.env`, stray debug code, unrelated files) and ask before including it.

## 4. Commit

- Stage source changes and `dist/`: `git add -A`, after checking the list from step 3.
- Commit message in Conventional Commits style, matching history:
  - `type(scope): summary`, lowercase, imperative, ≤ 72 chars.
  - Types: `feat`, `fix`, `style`, `refactor`, `chore`, `a11y`.
  - Scope is the component name when the change is about one component, e.g. `fix(SliderImages): ...`.
  - Several unrelated changes: a short summary line plus a bullet body, one bullet per change.
  - Leave the build out of the message. `dist/` updates are implied.
- If the user passed an argument (`$ARGUMENTS`), use it as the message or as a hint for it.
- Show the message in the reply, then commit. No `--no-verify`, no amending existing commits.

## 5. Push

- `git push origin HEAD`. Never force-push.
- If the push is rejected because the remote moved, stop and tell the user. Don't rebase or merge on your own.

## 6. Report

Briefly:
- commit hash and message
- branch pushed
- that WP Pusher deploys on its side, so a push-to-deploy webhook updates staging; otherwise the user triggers "Update theme" in WP Pusher
