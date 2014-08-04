Developer Notes
=========

This is a step-by-step guide, outlining my approach to this project.
I run Ubuntu 14 on my laptop, where I already have a running apache2/mysql/php5 stack.

###1. Downloaded supplied codebase, initialized repository

First, I needed to download the file, and put the contents in my web root.

* Unzipped the file AssistRx-Test.zip
* Copied its contents to /var/www/html/assistrx
* Performed a git init locally
* created a public repo origin on GitHub: https://github.com/jblossomweb/assistrx
* added all files as initial commit, pushed local repo to origin

###2. Created and enabled site for Apache, local clients as `local.arxtest.com`

Next, to make life easier, I created a local site for dev purposes.

* Created config: `vim /etc/apache2/sites-available/local.arxtest.com.conf`:

```sh
<VirtualHost *:80>
    <Directory "/var/www/html/assistrx">
        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
        Order allow,deny
        Allow from all
    </Directory>
    DocumentRoot "/var/www/html/assistrx"
    ServerName local.arxtest.com
    ServerAlias local.arxtest.com
    ErrorLog "/var/log/apache2/assistrx-error.log"
</VirtualHost>
```

* Enabled the newly configured site: `a2ensite local.arxtest.com`
* Restarted apache: `sudo service apache2 restart`
* Bypassed DNS on local by adding to host file `sudo vim /etc/hosts`:

<code>
192.168.X.X	local.arxtest.com
</code>

* Added same line to Windows 7 client I use on same network for IE 8/9 testing. (`C:\Windows\System32\drivers\etc
hosts`)

###3. Configured local database settings for dev

Next I had to connect the database.

* created a local mysql database schema: `arx_test`
* created a local mysql database user, with permission to schema: `arxtest`
* ran the dump file supplied with project.
* navigated to project webroot: `cd  /var/www/html/assistrx`
* copied sample file: `cp config/database.sample.php config/database.php`
* changed settings to reflect host, schema, user, and password.
* created a `.gitignore` file in the project webroot, containing `config/database.php`
* test by hitting `patients.php` in a web browser.

At first, I received an error, and quickly realized the db password cannot contain parenthesis.
I had used a secure password generator. I generated a new password for the db user without parenthesis, and made the code change to `config/database.php`

* Upon successful render of http://local.arxtest.com/patients.php I added the .gitignore, committed and pushed.

###4. Branched for dev, created markdown file for notes

Next I created a development branch, then committed this file.

* Navigated to project webroot: `cd /var/www/html/assistrx`
* Created a local branch called 'dev': `git checkout -b dev`
* Created a markdown file for notes: `vim developer_notes.md`
* Added to repo: `git add developer_notes.md`
* Committed: `git commit -am 'developer notes'`
* Pushed new branch to GitHub: `git push origin dev`
