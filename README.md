# Оценивание проектов участников олимпиады 3D Alem
Это моё первое веб-приложение которое разработано на PHP, для проведения вышеупомянутого мероприятия.

## Краткое содержание
1. [Установка необходимых программ](#установка-необходимых-программ)
    - [Установка XAMPP](#установка-xampp)
    - [Установка Composer](#установка-composer)
    - [Установка Git](#установка-git)
2. [Сборка файлов проекта](#сборка-файлов-проекта)
    - [Создание рабочей директорий](#создание-рабочей-директорий)
    - [Настройка локального поддомена](#настройка-локального-поддомена)
    - [Установка Yii](#установка-yii)
    - [Установка виджетов](#установка-виджетов)
    - [Слияние репозитория с yii](#слияние-репозитория-с-yii)
    - [Подключение статических файлов](#подключение-статических-файлов)
    - [Изменение конфигурационных файлов](#изменение-конфигурационных-файлов)
3. [Импорт базы данных](#импорт-базы-данных)
4. [Запуск проекта](#запуск-проекта)

## Установка необходимых программ
### Установка XAMPP
XAMPP - простой и распространненый дистрибутив Apache, содержащий MySQL и PHP, которое необходимо нам для создания веб-сервера принимающего HTTP-запросы и выдающего им HTTP-ответы. Для загрузки, перейдите на официальный сайт [*https://www.apachefriends.org/ru/index.html*](https://www.apachefriends.org/ru/index.html). Установщик последним шагом предлагает запустить XAMPP, подтвердите это действие. Это пригодиться впоследствии.
### Установка Composer
Это пакетный менеджер, с помощью которого мы сможем управлять зависимостями в PHP приложений. Для загрузки перейдите на официальный сайт [*https://getcomposer.org/download/*](https://getcomposer.org/download/). Для проверки корректной установки Composer, введите в командной строке `composer` и в ответ получите список его доступных команд. 
### Установка Git
Это система управления версиями, он понадобиться нам для слияния файлов данного репозитория с файлами Yii. Перейдите на официальный сайт [*https://git-scm.com/download/win*](https://git-scm.com/download/win), и выберите необходимую сборку для загрузки. После установки введите в командной строке `git version`. Вам должна отобразиться текущая версия:
```
$ git version
git version 2.26.0.windows.1    //for example
```

## Сборка файлов проекта
### Создание рабочей директорий
Так как мы уже запустили XAMPP, нажмите на кнопку "*Explorer*" в правой части "*XAMPP Control panel*". В открывшемся окне войдите в папку "*htdocs*", которое содержит папки и файлы доступные через url сервера. Поэтому создаем здесь новую папку "**test-project**".
### Настройка локального поддомена
Для удобной и красивой работы маршрутизации запросов в нашем веб-приложений, нам необходимо изначально проделать следующие процедуры: 
1) Проследовать по следующему пути `C:\xampp\apache\conf\extra\`
2) Открыть файл "**httpd-vhosts.conf**" любым текстовым редактором
3) Добавить в конце файла следующие фрагменты:
```
<VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/"
       ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/test-project/web"
    ServerName www.test-project.com
</VirtualHost>
```
4) Проследовать по следующему пути `C:\Windows\System32\drivers\etc\`
5) Открыть файл "**hosts**" любым текстовым редактором в режиме администратора
6) Добавить в конце файла следующий фрагмент:
```
127.0.0.1		www.test-project.com
```
Таким образом, после запуска Apache, мы сможем сразу обращаться к веб-приложению только по адресу *test-project.com* и все запросы будут корректно работать.
### Установка Yii
Yii это производительный PHP фреймворк, который использует для организаци кода архитектурный паттерн [MVC](https://ru.wikipedia.org/wiki/Model-View-Controller) и предназначенный для быстрой разработки современных веб-приложений. Для его установки используем *Composer*. Для этого откройте командную строку и выполните следующие команды:
```
cd ../..
cd xampp/htdocs/test-project
composer create-project --prefer-dist yiisoft/yii2-app-basic ./
```
**Примечание**: на момент создания веб-приложения использовался Yii версий 2.0.
### Установка виджетов
Нужные веб-приложению виджеты устанавливаются также с помощью *Composer*, для этого введите в командной строке:
```
composer require --prefer-dist "himiklab/yii2-recaptcha-widget"   
composer require --prefer-dist "kartik-v/yii2-widget-datepicker"
composer require --prefer-dist "kartik-v/yii2-export"
```
**Примечание**: на момент установки виджетов через командную строку, необходимо находиться в корневой директорий веб-приложения
### Слияние репозитория с yii
Так как у нас уже есть готовый каркас, теперь следует объединить файлы данного репозитория с yii2. Для этого введите в командной строке:
```
del README.md .gitignore
git init
git pull https://github.com/Zhando7/first_project.git
```
### Подключение статических файлов
Выполните следующие шаги:
1) В корневой директорий веб-приложения войти в папку "**assets**"
2) Открыть файл "*AppAsset.php*"
3) Дополнить публичные переменные класса AppAsset следующими параметрами:
```
    public $css = [
        'css/site.css',
        'css/required.css',
        'css/font-awesome.css'
    ];
    public $js = [
        'js/fusioncharts.js',
        'js/fusioncharts.charts.js',
        'js/themes/fusioncharts.theme.fint.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
```
### Изменение конфигурационных файлов
Выполните следующие шаги:
1) В корневой директорий веб-приложения войти в папку "**config**"
2) Открыть файл "*params.php*"
3) Дополнить возвращаемый массив следующими параметрами:
```
return [
	// Добавляем ниже других параметрами
	'supportEmail' => 'zhando797@gmail.com',		// Автоматическая отправка писем с указанной почты, необходимо для восстановления пароля
	'secretKeyExpire' => 60 * 60,				// Время хранения секретного ключа
]
```
4) В этой же директорий, открыть файл "*web.php*"
5) Дополнить/изменить вложенные параметры массива **$config**:
```
$config = [
	// ДОБАВЛЯЕМ В ВЕРХНЕЙ ЧАСТИ СРЕДИ ДРУГИХ ПАРАМЕТРОВ
	'layout' => 'basic',
	'defaultRoute' => 'main/index',
	'name' => '3D Алем',
	'charset' => 'UTF-8',
	'language' => 'ru_RU',

    // ЗАТЕМ ВНУТРИ МАССИВА `components`
	'components' = [

    // ДОБАВЛЯЕМ/ИЗМЕНЯЕМ НИЖЕ ДРУГИХ ПАРАМЕТРЫ
	'user' => [
		'identityClass' => 'app\models\Tables\Users',
		'enableAutoLogin' => true,
	],
	'errorHandler' => [	
	    'errorAction' => 'main/error',
	],
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => false,
        'messageConfig' => [
            'from' => ['zhando797@gmail.com' => 'zhando797'],
        ],
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'zhando797@gmail.com',
            'password' => 'ПАРОЛЬ ОТ ПОЧТЫ',            // не забудьте ввести свой настоящий пароль
            'port' => '465',
            'encryption' => 'ssl',
            ],
        ],   
        /*
        * ДОБАВЛЯЕМ НИЖЕ ЗАКОММЕНТИРОВАННОГО 'urlManager'
        * инициализируем красивые ссылки
        */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'main/index',
                '<action>'=>'main/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
    ],
	'params' => $params,

    // ПАРАМЕТРЫ МОДУЛЯ ДЛЯ ЭКСОРТА В EXCELL
	'modules' => [
		'gridview' => [
		'class' => '\kartik\grid\Module',]
		// enter optional module parameters below - only if you need to
		// use your own export download action or custom translation
		// message source
		// 'downloadAction' => 'gridview/export/download',
		// 'i18n' => []
	],
];
```
6) В этой же директорий, открыть файл "*db.php*"
7) Сменить значение `dbname=yii2basic` на `dbname=test_bd`
## Импорт базы данных
Выполните следующие действия:
1) В "*XAMPP Control panel*" запустить модули *Apache* и *MySQL*, затем нажать на кнопку "*Admin*" напротив модуля *MySQL*
2) В открывшемся окне, в левом sidebar, выполнить действие "*Создать БД*"
3) В поле "*Имя базы данных*" указать "**test_bd**" и поменять кодировку на "**utf8_general_ci**", затем подтвердить создание БД 
4) Теперь выберите созданную базу данных, затем в верхней части страницы, на панели, нажмите на "*Импорт*"
6) Для иморта базы данных, выберите файл который находится в корневой директорий веб-приложения в папке "*database*". После этого спуститесь в нижнюю часть страницы, и нажмите на кнопку "Вперед".

УРАА! Теперь всё готово.
## Запуск проекта
Наконец-то мы сделали всё необходимое, теперь осталось перейти по ссылке [test-project.com](http://www.test-project.com/)

**Примечание**: чтобы переключить проект с режима разработки на *production*, следует:
1) В корневой директории веб-приложения открыть папку "**web**"
2) Изменить значения следующих констант:
```
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
```