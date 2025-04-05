document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.getElementById('loginBtn');

    loginBtn.addEventListener('click', function() {
        console.log('Кнопка логина нажата!');
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const data = {
            username: username,
            password: password
        };
        console.log('Данные для отправки:', data);

        fetch('/authenticate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                console.log('Ответ сервера:', response);
                if (!response.ok) {
                    if (response.status === 401) {
                        throw new Error('Ошибка аутентификации');
                    } else {
                        throw new Error('Ошибка сети: ' + response.status);
                    }
                }
                return response.json();
            })
            .then(data => {
                console.log('Данные от сервера:', data);
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                } else {
                    alert('Ошибка аутентификации: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                if (error.message === 'Ошибка аутентификации') {
                    alert('Неправильный логин или пароль.');
                } else {
                    alert('Ошибка сети при аутентификации. Проверьте подключение к Интернету.');
                }
            });
    });

    const isAuthenticated = "{{ session('authenticated') }}";
    if (isAuthenticated !== '1') {
        //modal.style.display = "block"; //Удалите 
         alert('Пожалуйста, введите логин и пароль для продолжения.');//замените
        console.log('Пожалуйста, введите логин и пароль для продолжения.');
    } else {
        //modal.style.display = "none"; //Удалите 
        console.log('Модальное окно не показано session');
    }
});