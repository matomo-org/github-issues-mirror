# GitHub Issues Mirror

This project allows you to provide a read-only mirror for your GitHub issues which brings several advantages:

* Data ownership
* Better for SEO in case not all of your GitHub issues are indexed by Google
* In case GitHub is down you can still access your issues

Try it, it's easy to setup! No database needed

## Setup

* `git clone git@github.com:piwik/github-issues-mirror.git`
* `cd src`
* `curl -s https://getcomposer.org/installer | php`
* `php composer.phar install`

Make sure to point your vhost to `src/public`. The `src/tmp` directory has to be writable.

### Import issues from GitHub

`cd src/tasks && php import_github_issues.php`

You may want to setup a cronjob to import the issues regularly. The first time you run the importer you might run into the [Rate Limit](https://developer.github.com/v3/rate_limit/). In such a case just execute the script an hour later again. As [conditional requests](https://developer.github.com/v3/#conditional-requests) are used it should fetch only changed and not already imported issues the next time. Meaning after executing this script often enough you should no longer run into the rate limit.

## Configuration

See [src/config/config.php](src/config/config.php)

## Data structure

All issues are stored as JSON on the file system in [src/data](src/data):

* There is one JSON file for each issue in [src/data/issues](src/data/issues). To not end up having too many files in one directory they are split into subdirectories from 1 to 100. Otherwise the file names are equal to the issue number: 1875.json = Issue 1875.
* There is one JSON file for each page in [src/data/pages](src/data/pages). `1.json` === Page 1, `2.json` === Page 2, ...

## License

GPL v3 (or later) see [LICENSE](LICENSE)
