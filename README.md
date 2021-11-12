# HAJIMERU-V2
---
Hajimeru means "to begin" and it's kind of what we're going for with this solution.

This is a collection of Docker stacks that I mainly use for personal projects. Available "as is", those stacks were not fully tested. I have yet to face any major problem that I can't solve myself AKA this is not production ready. The main purpose is to gain some knowledge about Docker and how to set up a working environment.

# .ENV FILE
```
CONTAINER_NAME=
```
This will duplicate through all the containers, easiest way to prevent name conflict and manage your containers

```
LOCAL_PORT=
```
From which port you want to acces the _app_ container. Usually port `80`.

```
TEST_PORT=
```
When you need to open another port for your unit tests. For example, this would be `9876` with Angular.

```
# !! DB_HOST    = Same as service name !!
DB_PORT         = 3306
DB_USER         = root
DB_ROOT_PWD     = root
DB_NAME         = hajimeru_db
DB_HOST         = db << This one
```
The usual MySQL logins with the `DB_HOST` which must be the **SAME** as the service name specified in the YML file.

```
PMA_PORT=8080
```
From which port you want to access the _pma_ container. Usually port `8080`.

# SET THINGS UP

In order to reduce building time, there is many _Dockerfile_ you'll have to build first. This way, you'll just have to rebuild your project container without downloading everything from the beginning.

| Dockerfile | Use case | Image name |
|--|--|--|
| Dockerfile.base | Where the OS and basic tools are defined | hajimeru-v2/base:zsh |
| Dockerfile.nvm | If your project require Node.js | hajimeru-v2/nvm:0.38.0 |
| Dockerfile.php | If your projet require Composer | hajimeru-v2/base-php:7.3-apache |

# BUILD YOUR IMAGES

Open terminal from `/conf` folder

```
docker build -t {IMAGE_NAME} -f {DOCKERFILE} .

# Example
docker build -t hajimeru-v2/base:zsh -f Dockerfile.base .
```

# BUILD YOUR CONTAINERS

Open terminal from `root` folder and don't forget to setup your `.env` file

```
docker-compose -f STACK_NAME.yml up -d

# Example
docker-compose -f laravel.yml up -d
```

If you have edited some YML/Dockerfile files, you'll probably need to rebuild the containers. Simply run this command with the `--build` option.
```
docker-compose -f STACK_NAME.yml up --build -d
```

# ACCESS CONTAINER TERMINAL

```
docker container exec -it {CONTAINER_NAME} zsh

# Example
docker container exec -it hajimeru-v2__lr zsh
```

# NAMING CONVENTION
```
${CONTAINER_NAME}__ng  = Angular
${CONTAINER_NAME}__lr  = Laravel
${CONTAINER_NAME}__db  = Database
${CONTAINER_NAME}__pma = PhpMyAdmin
```