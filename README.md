# SSC Members

A WordPress plugin to help you build a members area on a website with an optional generic user that could be shared between people.

## Background

I needed to migrate [http://www.swanagesailingclub.org.uk/](http://www.swanagesailingclub.org.uk/) from Drupal 7 to WordPress and needed functionality to provide a simple members section on the site. I wrote custom D7 module for such members functionality [here](https://github.com/klasharr/php-drupal7-ssc). This is my first foray into WordPress development so this is also a good exercise in using the APIs. The sailing club website has a downloads section for members and [https://wordpress.org/plugins/download-monitor/](https://wordpress.org/plugins/download-monitor/) works nicely to fulfill that requirement.

## What it does

1. Lets you choose a subscriber role user to be your generic user. This user does not see any profile or admin pages and can not request a password reset
2. Adds a new post type for member pages which has /members as the base URL segment
3. Adds a 'Members only' flag to the post edit pages
4. Lets you display logged in and logged out versions of the primary menu depending on session state. Currently the names of the menus are hardcoded
5. Prevents member pages or private posts appearing anywhere when logged out
6. Adds a switchable debug mode which adds a red bar on member only posts or pages
7. Provides a shortcode `[ssc-member email="example@example.com" ]Mr Example[/ssc-member]` that will display the email next to a name for a logged in user, but not for a logged out user.


## Do you have a demo?

Yes, go to [http://ssc.klausharris.de/](http://ssc.klausharris.de/), the generic user you can try is:

user: test
pass: a

## Can I use it?

It's now October 2017, come back in December as there are a couple of things to change. It is now in production on [http://www.swanagesailingclub.org.uk/](http://www.swanagesailingclub.org.uk/).

## Can I request a feature?

Yes. Reach me at: [https://klaus.blog/contact/](https://klaus.blog/contact/) or raise an issue.