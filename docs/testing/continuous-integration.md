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
promotes additional caching. You can reference the [one included with
Mantle](https://github.com/alleyinteractive/mantle/blob/main/bin/install-wp-tests.sh).
Using Mantle's install script can increase the performance of installing
WordPress in your tests by 50% (1-2 seconds versus 4-5).

## Environment Variables

By default, no variables need to be set to run your tests. It is reccomended to
set the following variables before running:

- `CACHEDIR`: `/tmp/test-cache`
- `WP_CORE_DIR`: `/tmp/wordpress`

The `CACHEDIR` variable defines the location of the cache folder used for tests.
If possible, cache that folder and use it across tests to improve performance.
For tests using the mantle installation script, `WP_DEVELOP_DIR` and
`WP_TESTS_DIR` are unused and do not need to be defined.

## Caching

Caching can improve the performance of your tests by a great deal. Your tests
should cache the dependencies installed using Composer and the remote files
downloaded during testing (the `CACHEDIR` variable). The configurations included
in this guide will use the recommended caching for testing.

## Setting Up Continuous Integration

### GitHub Actions

The Mantle repository includes GitHub Actions for testing your Mantle
application against PHPUnit and phpcs:

- [GitHub Action for PHPUnit](https://github.com/alleyinteractive/mantle/blob/main/.github/workflows/tests.yml)
- [GitHub Action for phpcs](https://github.com/alleyinteractive/mantle/blob/main/.github/workflows/coding-standards.yml)

These actions include best practices included in this guide to test your
application. If you are working against a `wp-content/`-rooted application, you
can use the GitHub Actions from `alleyinteractive/create-mantle-app`:

- [GitHub Action for PHPUnit](https://github.com/alleyinteractive/create-mantle-app/blob/main/.github/workflows/tests.yml)
- [GitHub Action for phpcs](https://github.com/alleyinteractive/create-mantle-app/blob/main/.github/workflows/coding-standards.yml)

### Buddy

[Buddy](https://buddy.works/) is a fast and performance CI platform that
is in use at Alley. For internal projects, we test projects using Buddy using
the Mantle framework.

To get started, create a new project and connect your repository to Buddy. You
can use the following YAML file as a starting point Buddy. It supports
[importing this
file](https://buddy.works/docs/yaml/yaml-gui#how-to-switch-the-config-mode-to-gui)
so you can work in the GUI.

With the below configuration, Mantle can run Unit Tests and Coding Standards
tests on every Pull Request in under 30 seconds. This configuration is for
testing a single plugin/theme/project.

```yaml
- pipeline: "Test Pull Requests"
  trigger_mode: "ON_EVERY_PUSH"
  ref_name: "refs/pull/*"
  ref_type: "WILDCARD"
  priority: "NORMAL"
  fail_on_prepare_env_warning: true
  clone_depth: 1
  trigger_condition: "ALWAYS"
  actions:
  - action: "Setup Composer"
    type: "BUILD"
    working_directory: "/buddy/mantle"
    docker_image_name: "alleyops/ci-resources"
    docker_image_tag: "latest"
    execute_commands:
    - "# Install Dependencies"
    - "composer install"
    cached_dirs:
    - "/root/.composer/cache"
    volume_mappings:
    - "/:/buddy/mantle"
    trigger_condition: "ALWAYS"
    shell: "BASH"
  - action: "Setup WordPress and Run Unit Tests"
    type: "BUILD"
    working_directory: "/buddy/mantle"
    docker_image_name: "alleyops/ci-resources"
    docker_image_tag: "latest"
    execute_commands:
    - "# Install WordPress"
    - "bash bin/install-wp-tests.sh wordpress_unit_tests root root mysql $WP_VERSION"
    - ""
    - "# Go into the core directory and replace wp-content."
    - "mkdir -p ${WP_CORE_DIR}/wp-content/plugins/mantle"
    - "rsync -aWq --no-compress . ${WP_CORE_DIR}/wp-content/plugins/mantle"
    - ""
    - "# Run Unit Tests"
    - "cd ${WP_CORE_DIR}/wp-content/plugins/mantle"
    - "composer run phpunit"
    services:
    - type: "MYSQL"
      version: "5.7"
      connection:
        host: "mysql"
        port: 3306
        user: "root"
        password: "root"
    cached_dirs:
    - "/tmp/test-cache"
    - "/tmp/wordpress"
    volume_mappings:
    - "/:/buddy/mantle"
    trigger_condition: "ALWAYS"
    shell: "BASH"
    run_next_parallel: true
  - action: "Run PHPCS"
    type: "BUILD"
    working_directory: "/buddy/mantle"
    docker_image_name: "alleyops/ci-resources"
    docker_image_tag: "latest"
    execute_commands:
    - "composer run phpcs"
    volume_mappings:
    - "/:/buddy/mantle"
    trigger_condition: "ALWAYS"
    shell: "BASH"
  variables:
  - key: "CACHEDIR"
    value: "/tmp/test-cache"
    description: "Cache folder for remote requests."
  - key: "SKIP_DISCOVERY"
    value: "true"
  - key: "WP_CORE_DIR"
    value: "/tmp/wordpress"
    description: "WordPress checkout folder."
  - key: "WP_VERSION"
    value: "latest"
```

#### Buddy for a `/wp-content/`-rooted Project

If you are looking for a `/wp-content/`-rooted Buddy YAML, you can use
this configuration:

```yaml
- pipeline: "Test Pull Requests"
  trigger_mode: "ON_EVERY_PUSH"
  ref_name: "refs/pull/*"
  ref_type: "WILDCARD"
  priority: "NORMAL"
  fail_on_prepare_env_warning: true
  clone_depth: 1
  trigger_condition: "ALWAYS"
  actions:
  - action: "Setup Composer"
    type: "BUILD"
    working_directory: "/buddy/mantle"
    docker_image_name: "alleyops/ci-resources"
    docker_image_tag: "7.4-fpm-wp"
    execute_commands:
    - "# Install Dependencies"
    - "composer install"
    cached_dirs:
    - "/root/.composer/cache"
    volume_mappings:
    - "/:/buddy/mantle"
    trigger_condition: "ALWAYS"
    shell: "BASH"
  - action: "Setup WordPress and Run Unit Tests"
    type: "BUILD"
    working_directory: "/buddy/mantle"
    docker_image_name: "alleyops/ci-resources"
    docker_image_tag: "7.4-fpm-wp"
    execute_commands:
    - "# Install WordPress"
    - "bash bin/install-wp-tests.sh wordpress_unit_tests root root mysql $WP_VERSION"
    - ""
    - "# Go into the core directory and replace wp-content."
    - "rm -rf ${WP_CORE_DIR}/wp-content"
    - "mkdir -p ${WP_CORE_DIR}/wp-content/"
    - "rsync -aWq --no-compress . ${WP_CORE_DIR}/wp-content/"
    - ""
    - "# Run Unit Tests"
    - "cd ${WP_CORE_DIR}/wp-content/mu-plugins/mantle-app"
    - "../../vendor/bin/phpunit"
    services:
    - type: "MYSQL"
      version: "5.7"
      connection:
        host: "mysql"
        port: 3306
        user: "root"
        password: "root"
    cached_dirs:
    - "/tmp/test-cache"
    - "/tmp/wordpress"
    volume_mappings:
    - "/:/buddy/mantle"
    trigger_condition: "ALWAYS"
    shell: "BASH"
    run_next_parallel: true
  - action: "Run PHPCS"
    type: "BUILD"
    working_directory: "/buddy/mantle"
    docker_image_name: "alleyops/ci-resources"
    docker_image_tag: "7.4-fpm-wp"
    execute_commands:
    - "composer run phpcs"
    volume_mappings:
    - "/:/buddy/mantle"
    trigger_condition: "ALWAYS"
    shell: "BASH"
  variables:
  - key: "CACHEDIR"
    value: "/tmp/test-cache"
    description: "Cache folder for remote requests."
  - key: "SKIP_DISCOVERY"
    value: "true"
  - key: "WP_CORE_DIR"
    value: "/tmp/wordpress"
    description: "WordPress checkout folder."
  - key: "WP_VERSION"
    value: "latest"

```
