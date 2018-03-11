# Diary App

## About

This is an example app to showcase how you can use End-to-End Encryption in your Laravel Apps. I've used Vue as the Frontend Framework but the code should be easily portable to any Framework of your choice.

I've written a blog post about the project. You can read it [here](https://stefanzweifel.io/posts/code-experiment-end-to-end-encrypted-diary-app).

- [Vuex Store](https://github.com/stefanzweifel/diary-app/tree/master/resources/assets/js/store)
- [Vue Router](https://github.com/stefanzweifel/diary-app/tree/master/resources/assets/js/router)
- [Editor View](https://github.com/stefanzweifel/diary-app/blob/master/resources/assets/js/router/views/EntryEditorView.vue)
- [Vue Components](https://github.com/stefanzweifel/diary-app/tree/master/resources/assets/js/components)
- [crypto.js Class](https://github.com/stefanzweifel/diary-app/blob/master/resources/assets/js/classes/Crypto.js)

## Basic Installation Instructions

- Clone Repository
- Install PHP Dependencies: `composer install`
- Install Frontend Dependencies: `npm install`
- Create .env file: `cp .env.example .env`
- Migrate Database: `php artisan migrate`
- Create OAuth Key Pair: `php artisan passport:install`
- Link storage with `php artisan storage:link`

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Stefan Zweifel at hello@stefanzweifel.io. All security vulnerabilities will be promptly addressed.

## License

MIT
