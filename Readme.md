# oxylabs php

## Before you start
1. Make sure you have `Docker` installed
2. Make sure you have `make` installed. 
You can install `make` with `sudo apt-get -y install make`.
Otherwise, you can run the commands from the `Makefile` manually.
3. Change project permissions to your current user with `sudo chown -R $USER:$USER .`
4. Check in `Dockerfile` if `USER_ID` and `GROUP_ID` match your current user and group id.
you can check your user id and group id with `id -u` and `id -g` commands.
If they don't match, change them in the `Dockerfile` accordingly.


## First time setup
1. `cp .env.example .env`
2. Run `make first-time-setup`
3. Run `make seed-db`
4. That's it! You can now access the application at `http://localhost:8000`

## Available commands
Check `Makefile` for available commands.

## API
Project has only one API endpoint available at `http://localhost:8000/api/notifications?user_id=2`.
