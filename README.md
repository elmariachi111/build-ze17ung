build-zeitung
=============

A Symfony project created on May 10, 2017, 10:15 pm.

```
composer install
npm install
gulp --production
#create .env file with MEETUP_API_KEY=...
bin/console server:start
```

Deploy
======
needs heroku toolbelt https://devcenter.heroku.com/articles/getting-started-with-php#set-up

```
heroku create #if new
heroku buildpacks:set heroku/nodejs
heroku buildpacks:set heroku/php --index 2

heroku config:set SYMFONY_ENV=prod
heroku config:set MEETUP_API_KEY=...

heroku git:remote --app (app)
git push heroku master

```
