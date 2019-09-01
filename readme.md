# Diary App

## Word of Warning:

This app has been written in 2017. Back then I didn't knew that much about encryption. Since then, many people pointed out to me, that the app in it's current state has design flaws: App encryption key is available in the frontend/public, Master Password of a user is not connected with the app encryption key.

So yeah, I'm by no means a cryptographic expert! **Please, don't use the source code of the app as the basis of your next security project!**

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

## License

MIT
