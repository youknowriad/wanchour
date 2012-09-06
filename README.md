WANCHOUR
========

Wanchour is a web application to manage and deploy your repositories using [Anchour](http://anchour.rizeway.com).

REQUIREMENTS
============
Apache and PHP 5.3

INSTALLATION
============

* Clone the repository

        git clone https://github.com/youknowriad/wanchour.git && cd wanchour

* Get the dependancies using composer

        curl -s https://getcomposer.org/installer | php
        ./composer update

* Get the last version of anchour and chmod it

        wget http://rizeway.com/anchour.phar
        chmod +x anchour.phar

* Initialize database informations

        php app/console rizeway:wanchour:init

* Create a Virtual Host on apache to the web directory of wanchour (or just copy wanchour to your apache www folder)

* Add the daemon ```php app/console rizeway:job:daemon``` to your crontab

If you have some issues with the cache or logs directories, check this link to fix this : [Symfony Doc](http://symfony.com/doc/current/book/installation.html#configuration-and-setup)


USAGE
=====

Wanchour is based on repositories and distributions, all you have to do is add your repositories to wanchour. The repositories added must have a ```.anchour``` file in the root directory. ([More details on this file](http://anchour.rizeway.com))

After adding your repositories, you update their commands and can launch the commands defined in the .anchour file directly in your browser.

If you defined variables in your .anchour commands, you can use distributions (which are juste a set of parameters) to launch these commands with different distributions (for example to deploy a repository to multiple servers)

API
===

Wanchour offers a simple RESTful API (JSON)

 * ```http://your_anchour_url/api/repositories``` to get your repositories
 * ```http://your_anchour_url/api/distributions``` to get your distributions
 * ```http://your_anchour_url/api/deploy/{repository_id}/{command_name}/{distribution_id}``` to launch the command 'command_name' for the repository 'repository_id' with the distribution {distribution_id}. The distribution is optional
 * ```http://your_anchour_url/api/job/{job_id}``` to get job status and logs