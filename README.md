### Installation

1. Fetch the project to desired directory
2. Navigate to directory
3. Run in console from the directory:

~~~
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
~~~

4. Run in console from the directory
   * `cp .env.example .env`
   * `./vendor/bin/sail build`
   * `./vendor/bin/sail up -d`
   * `./vendor/bin/sail artisan migrate`
6. Go to [localhost](http://localhost) in browser

### Test task definition
[Google doc](https://docs.google.com/document/d/19KSJHiiuwLNDagRqfkp4XOW8y4xbmO6ez43rp0NW5UU/edit?tab=t.0)
