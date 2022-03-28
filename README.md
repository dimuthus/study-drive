
## Usage

To get started, make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) on your system, and then clone this repository.

Next, navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose up -d --build site`.

After that completes, follow the steps from the [src/README.md](src/README.md) file to get your Laravel project added in (or create a new blank one).

Bringing up the Docker Compose network with `site` instead of just using `up`, ensures that only our site's containers are brought up at the start, instead of all of the command containers as well. The following are built for our web server, with their exposed ports detailed:

- **nginx** - `:81`
- **mysql** - `:3306`
- **php** - `:9000`
- **redis** - `:6379`
- **mailhog** - `:8025` 

Three additional containers are included that handle Composer, NPM, and Artisan commands *without* having to have these platforms installed on your local computer. Use the following command examples from your project root, modifying them to fit your particular use case.

- `docker-compose run --rm composer update`
- `docker-compose run --rm npm run dev`
- `docker-compose run --rm artisan migrate`

## Permissions Issues

If you encounter any issues with filesystem permissions while visiting your application or running a container command, try completing one of the sets of steps below.

**If you are using your server or local environment as the root user:**

- Bring any container(s) down with `docker-compose down`
- Rename `docker-compose.root.yml` file to `docker-compose.root.yml`, replacing the previous one
- Re-build the containers by running `docker-compose build --no-cache`

**If you are using your server or local environment as a user that is not root:**

- Bring any container(s) down with `docker-compose down`
- In your terminal, run `export UID=$(id -u)` and then `export GID=$(id -g)`
- If you see any errors about readonly variables from the above step, you can ignore them and continue
- Re-build the containers by running `docker-compose build --no-cache`

Then, either bring back up your container network or re-run the command you were trying before, and see if that fixes it.

## Persistent MySQL Storage

By default, whenever you bring down the Docker network, your MySQL data will be removed after the containers are destroyed. If you would like to have persistent data that remains after bringing containers down and back up, do the following:

1. Create a `mysql` folder in the project root, alongside the `nginx` and `src` folders.
2. Under the mysql service in your `docker-compose.yml` file, add the following lines:

```
volumes:
  - ./mysql:/var/lib/mysql
```
## HTTP Methods
Available HTTP methods on a resource

| **Verb**        | **Path**           | **Action**  | **Route Name**        | **Description**   |
| -------------   |-------------| -----| ------------- |-------------|
| GET         | /courses | index | course.index | Get all courses expected results:    {
        "id": 1,
        "name": "Alexys Mertz",
        "capacity": 3,
        "enrollments": 0,
        "availibility": "Yes",
        "created_at": "2022-03-28T14:49:20.000000Z",
        "updated_at": "2022-03-28T14:49:20.000000Z"
    } |


Available HTTP methods for registration

| **Verb**        | **Path**           | **Action**  | **Route Name**        | **Description**   |
| -------------   |-------------| -----| ------------- |-------------|
| POST         | /registrations | courseRegistration | registration.courseRegistration | For new student registration pass student_id(between 1 to 25) and course_id(between 1-15) as parameters
example:{
    "student_id":"6",
    "course_id":"2"
}
results: {
    "success": "Successfully registered for the course!"
}

if  user already registered, give the following out put.
{
    "message": "The given data was invalid.",
    "errors": {
        "student_id": [
            "This student already registered for this course"
        ]
    }
}

if student_id or course id is invalid it will disaply following out put.
{
    "message": "The given data was invalid.",
    "errors": {
        "student_id": [
            "The selected student id is invalid."
        ]
    }
}
