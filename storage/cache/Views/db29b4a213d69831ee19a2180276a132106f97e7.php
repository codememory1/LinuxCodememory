<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container-chat">
    <div class="content-chat"></div>
    <div style="margin-top: 7px">
        <form class="formMessage" enctype="multipart/form-data">
            <input class="input-message" type="text" name="message" placeholder="Сообщение..." style="padding: 7px 10px;padding-right: 46%;">
            <input type="file" name="file[]" class="fileInput">
            <button class="send-message">-></button>
        </form>
    </div>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
    }
    .container-chat {
        width: 400px;
        height: 430px;
        border: 1px solid #000;
        margin: 100px;
    }
    .content-chat {
        overflow: auto;
        display: block;
        width: 100%;
        height: 390px;
        overflow-x: hidden;
    }
    .content-chat div {
        word-break: break-word;
    }
    .my-message {
        display: flex;
        justify-content: flex-end;
        width: 100%;
        float: right;
        word-break: break-all;
        padding: 6px 7px;
    }
    .you-message {
        display: flex;
        justify-content: flex-start;
        width: 100%;
        word-break: break-all;
        padding: 6px 7px;
    }
    .my-message span {
        background: #0b7cf0;
        color: #fff;
        border: 1px solid #2066cf;
        max-width: 70%;
    }
    .you-message span {
        background: #eae5e5;
        border: 1px solid #000;
        max-width: 70%;
    }
    .content-chat div > span {
        padding: 3px 10px;
        border-radius: 5px;
    }
    img {
        width: 25px;
        height: 25px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://www.workerman.net/demos/phpsocketio-chat/socket.io-client/socket.io.js"></script>
<script>
    let sock = io('//:2021');
    const dataUser = {
        session: '<?php echo e($session); ?>',
        userid: '<?php echo e($userid); ?>',
        sessionId: '<?php echo e(Session::sessionId()); ?>'
    };

    const send = document.querySelector('.send-message');
    const input = document.querySelector('.input-message');
    const fileInput = document.querySelector('.fileInput');
    const form = document.querySelector('form');

    send.addEventListener('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/chat/send/' + dataUser.userid,
            type: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                input.value = '';
                fileInput.value = '';
                console.log(response);
            },
            error: function(response) {
                console.log('Error send Message')
            }
         });
    });

    sock.emit('data', dataUser);
    sock.on('chat-message', function(data) {

        const content = document.querySelector('.content-chat');

        let result = '';
        
        const keys = Object.keys(data);
        for(let i = 0; i < keys.length; i++)
        {
           
            let div = document.createElement('div');
            let span = document.createElement('span');
            
            if(data[i].fromId == dataUser.session)
            {
                div.classList.add('my-message');
            }
            else
            {
                div.classList.add('you-message');
            }

            span.innerHTML = data[i].message;
            if(data[i].img !== null && data[i].img != '')
            {
                let image = document.createElement('img');
                image.setAttribute('src', '/src/images/' + data[i].img);
                span.innerHTML += image.outerHTML;
            }
            div.innerHTML = span.outerHTML;

            result += div.outerHTML;
        }
        
        content.innerHTML = result;

    });

</script>
</body>
</html><?php /**PATH W:\domains\myDb.loc\resources\Views/chat.blade.php ENDPATH**/ ?>