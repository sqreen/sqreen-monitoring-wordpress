# Sqreen monitoring for Wordpress

Automatically monitor Wordpress with Sqreen PHP agent (extension & daemon based, *not* the [Wordpress agent](https://github.com/sqreen/AgentWordpress/)).

These following events are automatically tracked:

- Login success
- Login failure
- Signup

## Getting started

- Install and configure [Sqreen for PHP](https://docs.sqreen.com/php/introduction/)
- Install the plugin
- Activate the plugin
- Wordpress should now report events to Sqreen automatically

## Development: Packaging the plugin

- Run `build.sh`
- Plugin archive is generated in `dist/`
