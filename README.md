Project Management Tool
=======================

Information
-----------

PM tool is designed to be a basic project management tool. It's only contains most essential parts of project management such as managing users and their roles on created projects, assigning tasks and tracking the overall progress.

Since most of the good PM alternatives were written in Ruby and Java, we started to develop one with PHP to enable ease of maintenance for PHP developers.

Built on [Scabbia Framework 1.5](https://github.com/larukedi/Scabbia-Framework).


Installation
------------
##### Alternative 1: Zip Package #####

Download [PM](https://github.com/larukedi/pm/archive/master.zip) and launch `php scabbia update`.

##### Alternative 2: Git #####

On Terminal or Command Prompt:
``` bash
git clone https://github.com/larukedi/pm pm
cd pm
php scabbia update
```

##### Alternative 3: Composer #####

On *nix:
``` bash
php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
php composer.phar create-project larukedi/pm -s dev pm
```

On Windows:
Download and install [Composer-Setup.exe](http://getcomposer.org/Composer-Setup.exe) then run:
``` bat
composer create-project larukedi/pm -s dev pm
```


Update
------
``` bash
php scabbia update
```


Requirements
------------
* PHP 5.3.3+ (http://www.php.net/)
* Composer Dependency Manager** (http://getcomposer.org/)
* Scabbia Framework** (http://larukedi.github.com/Scabbia-Framework/)

** Will be auto-installed during composer execution


License
-------
See [license.txt](license.txt)


Contributing
------------
It is publicly open for any contribution. Bugfixes, new features and extra modules are welcome.

* Fork the repo, push your changes to your fork, and submit a pull request.
* If something does not work, please report it using GitHub issues.
