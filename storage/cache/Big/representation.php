<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>
<script>
    let settingsModal = [];
    let contentsModal = [];
</script>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Представления</span>
        </div>
        <div class="content-abs" style="height: 700px">
            <?php echo \View::theme('flash'); ?>
            <div class="menu-interface-site">
                <button class="btn active" dinamic-btn="create">Создать</button>
                <button class="btn" dinamic-btn="all-rep">Все представления</button>
            </div>

            <div class="container-dinamic interface-settings-container">
                <div class="page-dinamic" name-dinamic-page="all-rep">

                    <table class="table-representations">
                        <thead>
                            <th style="position: relative;">
                                №
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Имя события
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Событие
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Имя БД
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Имя Таблицы
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Url запроса
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Мутод запроса
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Запросов
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Дата создания
                                <span class="resize"></span>
                            </th>
                            <th style="position: relative;">
                                Действие
                            </th>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <center>
                        <button class="show-next-representation btn btn-info <?php echo count($getRepr) > 10 ? '' : 'hidden'; ?>">Показать еще <span class="loader-next-repr"></span></button>
                    </center>
                </div>
                <div class="page-dinamic active" name-dinamic-page="create">
                    <form action="<?php echo route('FastDB.representation-handler'); ?>" method="POST" class="column">
                        <label for="">
                            <span style="font-size: 14px;">Выбирите событие:</span>
                        </label>
                        <ul style="padding-left: 30px;padding-top: 10px;display: grid;">
                            <label for="">
                                <input type="radio" name="event" class="marker" value="Auth">
                                <span style="font-size: 13px;position: relative;bottom: 7px;left:4px">
                                    Авторизация
                                </span>
                            </label>
                            <label for="">
                                <input type="radio" name="event" class="marker" value="CreateTable">
                                <span style="font-size: 13px;position: relative;bottom: 7px;left:4px">
                                    Создание Таблицы
                                </span>
                            </label>
                            <label for="">
                                <input type="radio" name="event" class="marker" value="CreateDatabase">
                                <span style="font-size: 13px;position: relative;bottom: 7px;left:4px">
                                    Создание БД
                                </span>
                            </label>
                            <label for="">
                                <input type="radio" name="event" class="marker" value="AddRecord">
                                <span style="font-size: 13px;position: relative;bottom: 7px;left:4px">
                                    Добавление новой записи в таблицу
                                </span>
                            </label>
                            <label for="">
                                <input type="radio" name="event" class="marker" value="DeleteRecord">
                                <span style="font-size: 13px;position: relative;bottom: 7px;left:4px">
                                    Удаление записи из таблицы
                                </span>
                            </label>
                        </ul>
                        <div class="hr-light"></div>
                        <label for="" style="margin-top: 10px;display: block;font-size: 14px;">
                            Имя события
                        </label>
                        <ul style="padding-top: 10px;display: grid;grid-gap: 7px;">
                            <input type="text" name="event-name" placeholder="Введите название события">
                        </ul>
                        <div class="hr-light"></div>
                        <ul style="padding-top: 20px;display: grid;grid-gap: 7px;grid-template-columns: 1fr 1fr;">
                            <div style="margin: 0px;position: relative;bottom: 17px;">
                                <label for="">
                                    Название Базы Данных
                                </label>
                                <input type="text" name="dbname" placeholder="Введите название существующей БД">
                            </div>
                            <div style="margin: 0px;position: relative;bottom: 17px;">
                                <label for="">
                                    Название Таблицы
                                </label>
                                <input type="text" name="table-name" placeholder="Введите название таблицы из указанной бд">
                            </div>
                        </ul>

                        <div class="hr-light"></div>
                        <label for="" style="margin-top: 10px;display: block;font-size: 14px;">
                            Ссылка скрипта
                        </label>
                        <ul style="padding-top: 10px;display: grid;grid-gap: 7px;grid-template-columns: 1fr 1fr 1fr;">
                            <input type="text" name="url-script" placeholder="URL обработчик">
                            <div class="method" style="margin: 0px;">
                                <select name="method-request">
                                    <option value="">Метод запроса</option>
                                    <option value="get">GET</option>
                                    <option value="post">POST</option>
                                </select>
                            </div>
                            <div class="method" style="margin: 0px;position: relative;bottom: 17px;">
                                <label for="">
                                    Кол-во запросов (< 0 бесконечно)
                                </label>
                                <input type="number" name="count-request" placeholder="Кол-во запросов" value="-1">
                            </div>
                        </ul>
                        <button class="btn btn-success" style="margin: 0px">Создать Представление</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>
<script>
    let data = [
        <?php foreach($getRepr as $k => $data): ?>
            {
                id: "<?php echo $k + 1; ?>",
                nameEvent: "<?php echo $data['name']; ?>",
                event: "<?php echo $data['event']; ?>",
                dbname: "<?php echo $data['dbanme']; ?>",
                tableName: "<?php echo $data['table-name']; ?>",
                urlScript: "<?php echo $data['url-script']; ?>",
                requestMethod: "<?php echo $data['request-method']; ?>",
                requests: "<span style='color: orange'><?php echo $data['requests']; ?></span> из <span style='color: red'><?php echo $data['max-request'] < 0 ? "<i class='far fa-infinity'></i>" : $data['max-request']; ?></span>",
                dateCreate: "<?php echo $data['date-create']; ?>",
                actions: "<a class='btn btn-info' button-open-modal='get-response-<?php echo $k; ?>'><i class='fal fa-poll-h'></i></a><a href='' class='btn btn-error'><i class='far fa-trash-alt'></i></a>"
            },
        <?php endforeach; ?>
    ];

    function addRepresentation(data) {
        let table = document.querySelector('.table-representations > tbody');
        let tr = document.createElement('tr');

        for(let i = 0; i < Object.keys(data).length; i++) {
            let IE = data[i];

            let viewTr = '<tr><td>' + IE.id + '</td><td>' + IE.nameEvent + '</td><td>' + IE.event + '</td><td>' + IE.dbname + '</td><td>' + IE.tableName + '</td><td>' + IE.urlScript + '</td><td>' + IE.requestMethod + '</td><td>' + IE.requests + '</td><td>' + IE.dateCreate + '</td><td>' + IE.actions + '</td></tr>';
        
            table.innerHTML += viewTr;

        }
    }

    setTimeout(() => {
        PaginationTable.data(data)
            .settings(10, 5)
            .upload(function(data, all) {
                addRepresentation(data);
            })
            .onClick(document.querySelector('.show-next-representation'), function(data, all, loaded) {
                addRepresentation(data);

                setTimeout(() => {
                    if(loaded >= all) {
                        document.querySelector('.show-next-representation').classList.add('hidden');
                    }
                }, 100);
            }, {
                selector: document.querySelector('.loader-next-repr'),
                icon: '...'
            })
    }, 100);
    
</script>
<script>
    settingsModal.push(
        <?php foreach($getRepr as $k => $data): ?>
            {
                id: 'get-response-<?php echo $k; ?>',
                title: 'Ответ запроса',
                height: 'max-content'
            },
        <?php endforeach; ?>
        );
    contentsModal.push(
        <?php foreach($getRepr as $k => $data): ?>
            {
                content: '<div class="content-modal-response"><span class="statusResponseSpan">Статус ответа: <span class="circle" status-code="<?php echo $data["statusCode"]; ?>"></span> <?php echo $data["statusCode"] === "-" ? "<span class=no_status_code>Неизветсный</span>" : $data["statusCode"]; ?></span><div class="hr-light"></div><div><span class="statusResponseSpan">Текст ответа: </span><div style="max-height: 400px;padding-bottom: 10px;word-break: break-word;overflow: auto;margin-left: 35px;"><?php echo $data["response"]; ?></div></div></div><div class="footer-modal" style="position: inherit;"><button class="btn btn-info close-modal-btn" modal-close="get-response-<?php echo $k; ?>">Закрыть</button></div>'
            },
        <?php endforeach; ?>
        );
</script>
<script>
    setTimeout(() => {
        new Modal(true, settingsModal).content(contentsModal).render();
    }, 100);
</script>

