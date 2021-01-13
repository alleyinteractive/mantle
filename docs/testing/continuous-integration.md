# Continuous Integration

[[toc]]

## Introduction

Using Continuous Integration (CI) in your development can help ease your mind
when adding new features to a site. This guide will help you setup your Mantle
application or project that is using Mantle's testing framework for CI via
GitHub Actions or Buddy.

::: tip Are you transitioning an existing site to Mantle's Test Framework?

Be sure to checkout [Transitioning to Test Framework](./transition.md) for more
information.
:::

## Differences from Core Tests

One difference to note is that Mantle uses a slimmed-down form of
`bin/install-wp-tests.sh` to install WordPress during CI tests. Our version
removes the unnecessary steps of installing the core unit tests and helps
promotes additional caching. You can reference the [one included with Mantle](https://github.com/alleyinteractive/mantle/blob/main/bin/install-wp-tests.sh).

## Environment Variables

## Caching

## Setting Up Continuous Integration

### GitHub Actions

The Mantle repository includes GitHub Actions for testing your Mantle
application against PHPUnit and phpcs:

- [GitHub Action for PHPUnit](https://github.com/alleyinteractive/mantle/blob/main/.github/workflows/tests.yml)
- [GitHub Action for phpcs](https://github.com/alleyinteractive/mantle/blob/main/.github/workflows/coding-standards.yml)

These actions include best practices included in this guide to test your
application. If you are working against a `wp-content/`-rooted application, you
can use the GitHub Actions from `alleyinteractive/create-mantle-app`:

TODO ADD
- [GitHub Action for PHPUnit]()
- [GitHub Action for phpcs]()

### Buddy

[Buddy](https://buddy.works/) is a fast and performance CI platform that
is in use at Alley. For internal projects, we test projects using Buddy using
the Mantle framework.

To get started, create a new project and connect your repository to Buddy. You
can use the following YAML file as a starting point Buddy. It supports
[importing this
file](https://buddy.works/docs/yaml/yaml-gui#how-to-switch-the-config-mode-to-gui)
so you can work in the GUI.


```yaml
TKTK
```
