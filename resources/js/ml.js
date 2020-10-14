import Vue from 'vue'
import {
    MLInstaller,
    MLCreate,
    MLanguage
} from 'vue-multilanguage'

Vue.use(MLInstaller)

export default new MLCreate({
    initial: 'ru',
    save: process.env.NODE_ENV === 'production',
    languages: [
        new MLanguage('ru').create({
            sitename: "Калькулятор",
            name: 'Имя',
            login: 'Вход',
            email: 'Почтовый ящик',
            rememberme: 'Запомнить меня?',
            password: 'Пароль',
            newpassword: 'Новый пароль',
            users: 'Пользователи',
            saved: 'Закладки',
            profile: 'Профиль',
            logout: 'Выход',
            edit: 'Редактировать',
            remove: 'Удалить',
            remove_name: 'Удалить {0}?',
            add: 'Добавить',
            search: 'Поиск',
            none: 'Пусто',
            save: 'Сохранить',
            saved_changes: 'Изменения сохранены',
            cancel: 'Отмена',


            error_remove: 'Ошибка удаления',
            error_reload: 'Перезагрузить',
            error_validation: 'Ошибка валидации',
            error_network: 'Ошибка сети',

            error_validate_name: 'Имя должно быть не менее 3 символов',
            error_validate_email: 'Email занят',
            error_validate_password: 'Пароль должен быть не менее 3 символов'
        }),
        new MLanguage('en').create({
            sitename: "Calculator",
            name: 'Name',
            login: 'Login',
            rememberme: 'Remember Me?',
            email: 'E-mail adress',
            password: 'Password',
            newpassword: 'New password',
            users: 'Users',
            saved: 'Bookmarks',
            profile: 'Profile',
            logout: 'Logout',
            edit: 'Edit',
            remove: 'Remove',
            remove_name: 'Remove {0}?',
            add: 'Add',
            search: 'Search',
            none: 'Is empty',
            save: 'Save',
            saved_changes: 'Changes saved',
            cancel: 'Cancel',


            error_remove: 'Remove error',
            error_reload: 'Reload',
            error_validation: 'Validation error',
            error_network: 'Network error',

            error_validate_name: 'Name must be at least 3 characters',
            error_validate_email: 'Email busy',
            error_validate_password: 'Password must be at least 3 characters'
        }),
    ]
})
