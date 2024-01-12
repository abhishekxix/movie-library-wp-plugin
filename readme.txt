=== Movie Library ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://example.com/
Tags: comments, spam
Requires at least: 4.5
Tested up to: 6.2.2
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform your WordPress website into a Movie library.

== Description ==
Movie Library plugin provides features that turn your WordPress Website into a full fledged movie library website.

== CLI commands ==

# wp mlib-export

## Description

`wp mlib-export` is a command-line tool that allows you to export data from your Movie Library WordPress website. It provides two subcommands for exporting specific types of posts: `movies` for exporting 'mlib-movie' posts and `persons` for exporting 'mlib-person' posts.

## Installation

Before using `wp mlib-export`, ensure that you have [WP-CLI](https://wp-cli.org/) installed on your system.

## Usage

### Export Movies

To export movie data, use the following command:

```shell
$ wp mlib-export movies
```

This command will start the export process for "mlib-movie" posts. By default, the exported data will be saved to the following directory:

```
/Users/{your_username}/Local Sites/movie-library/app/public/
```

And the file will have the following default name:

```
movie-library-mlib-movie-export.csv
```

Upon successful export, you will see a message indicating the number of records imported.

### Export Persons

To export person data, use the following command:

```shell
$ wp mlib-export persons
```

This command will start the export process for "mlib-person" posts. Similar to the movie export, the exported data will be saved to the default directory and file location mentioned above.

## Examples

Here are some examples of how to use `wp mlib-export`:

#### Export movie data:

```shell
$ wp mlib-export movies
```

This command exports "mlib-movie" data and provides information about the export process and the location of the exported file.

#### Export person data:

```shell
$ wp mlib-export persons
```

This command exports "mlib-person" data and provides information about the export process and the location of the exported file.

## Notes

- Make sure you have the appropriate permissions to access the directory where the export file will be saved.
- You can customize the export directory and filename by specifying the `--directory` and `--filename` options followed by the desired path and filename.


== Instructions ==
- To view the Upcoming movies from TMDB, enter the TMDB API key in the Settings > Movie Library settings page.