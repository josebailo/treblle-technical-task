# Treblle Task

This is a Laravel application that uses InertiaJS, Vue, and TailwindCSS for the frontend. The application is set up to run with the Sail Docker image, so you'll need to have docker and docker compose installed on your machine before getting started.

## Getting started

Here are the steps to have the project running locally:

1. Clone the repository.
```bash
git clone git@github.com:josebailo/treblle-technical-task.git
```

2. Change to the project folder.
```bash
cd treblle-technical-task
```

3. Run install script (this may take several minutes).
```bash
bash bin/install.sh
```

After the install script has ended you can visit [localhost](http://localhost) to test the application.

## Improvements

Here is a list of possible improvements to do on the application:

- Allow guests to reset the password.
- Verify user email after sign up.
- Improve validations: like better passwords, check max strings length, etc.
- Improve the structure of the js folder.
- Use [Ziggy](https://github.com/tighten/ziggy) to write routes in js files.
- Use translations in js files instead of writting directly the text in english.
- Add more and better frontend tests.
- Add some e2e tests.
- The integration with Typescript could be far better.
- The API tokens could accept more than just the name (abilities, expiration date, etc.).
