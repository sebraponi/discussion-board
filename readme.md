# Discussion Board

This is an open source forum made in Laravel.

## Installation

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet.
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone https://github.com/sebraponi/discussion-board.git
cd discussion-board && composer install && npm install

npm run dev

php artisan migrate
```

### Step 2

Next, boot up a server and visit your forum:
http://discussion-board.test/threads
