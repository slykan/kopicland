#!/bin/bash
REPO=~/kopicland

cd $REPO
echo "→ git pull..."
git pull origin main

echo "→ composer install..."
/usr/local/bin/ea-php83 /usr/local/bin/composer install --no-dev --optimize-autoloader

echo "→ npm install + build..."
npm install
npm run build

/usr/local/bin/ea-php83 artisan migrate --force
[ -L $REPO/public/storage ] || /usr/local/bin/ea-php83 artisan storage:link
/usr/local/bin/ea-php83 artisan optimize

echo "✓ Deployed!"
