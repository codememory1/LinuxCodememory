<?php

namespace System\Support;

use System\classes\AppEnv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use System\Codememory\Make\Make;

/**
 * Class Mail
 * @package System\Support
 */
class Mail
{
    /**
     *
     * @var type object PHPMailer
     */
    protected $mail;

    /**
     * Mail constructor.
     */
    public function __construct()
    {
        
        $this->mail = new PHPMailer(true);
        
    }
    
    /*
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     * Функция serverSettings() эта функция настраивает 
     * Отправку, получает настройки и cfg, и подстовляет их
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     * 
     * Settings Server Mail
     *  AND Settings User 
     */
    private function serverSettings()
    {
        
        $this->mail->isSMTP();
        
        $this->mail->Host = AppEnv::get('MAIL_HOST');
        
        $this->mail->SMTPAuth = true;
        
        $this->mail->Username = AppEnv::get('MAIL_USER');
        
        $this->mail->Password = AppEnv::get('MAIL_PASSWORD');
        
        $this->mail->SMTPSecure = AppEnv::get('SMTPSecure_MAIL');
        
        $this->mail->Port = AppEnv::get('MAIL_PORT');
        
        $this->mail->CharSet = AppEnv::get('MAIL_CHARSET');
        
    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_===
     * Функция getContent(), параметр $file, путь к шаблону Mail
     * Проверяет если нет папки Mail то создает
     * Проверяет если есть папка Mail и нет файла который указан
     * В пааметре, то создает Заменяет в нем маркеры, и возврощает
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_===
     */
    /**
     * @param $file
     * @param   array $replace
     *
     * @return false|mixed|string
     */
    public function getContent($file, $replace = [])
    {
        Make::Dir('resources/templates/Mail');
        Make::File('resources/templates/Mail/'.$file, []);
        
        $content = file_get_contents('../resources/templates/Mail/'.$file.'.tpl');
        
        
        foreach($replace as $key => $rep)
        {
            $content = str_replace($key, $rep, $content);
            
        }
        
        return $content;
        
        
    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     * Получение контента, что будет отправлено,
     * Параметр $admin имеете массив: ключи в $admin
     * user => login - обязательно, 
     * name => name - не обязательно
     * 
     * Параметр $to, кому отправить, можно указать несколько,
     * Пример: ["example@gmail.com", "example2@gmail.com"],
     * Или 1 как строку
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     */
    public function from($admin = [], $to = [])
    {
        
        if(empty($admin["user"]) || !array_key_exists("user", $admin))
        {
            $username = AppEnv::get('MAIL_USER');
        }else
        {
            $username = $admin["user"];
        }
        
        
        if(array_key_exists("name", $admin))
        {
            $name = $admin["name"];
        }else
        {
            $name = "";
        }
        
        $this->mail->setFrom($username, $name);
        
        if(is_array($to))
        {
            
            foreach($to as $toMail)
            {
                $this->mail->addAddress($toMail);
            }
            
        }else
        {
            $this->mail->addAddress($to);
        }

    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     * Функция `attachment` это прекрепляет к сообщению что-то
     * Параметр $patch путь, что прикрепить, $desc описание 
     * Прикрепленного файла
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     */
    /**
     * @param $patch
     * @param   string $desc
     *
     * @throws Exception
     */
    public function attachment($patch, $desc = "")
    {
        $desc = (string) $desc;
        $patch = "../".$patch;
        
        $this->mail->addAttachment($patch, $desc);
        
    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
     * Функция collect имеет 2 параметра $subject, $body
     * $subject - тема сообщения
     * $body - контент что отправить функция $this->getContent()
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
     */
    /**
     * @param $subject
     * @param $body
     */
    public function collect($subject, $body)
    {
        
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->isHTML = AppEnv::get('MAIL_HTML');
        
    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_===
     * Функция send проверяет, если сообщение отправилось
     * ТО вернет true
     * ИНАЧЕ вернет false
     * ===_===_===_===_===_===_===_===_===_===_===_===_===_=== 
     */
    /**
     * @return bool
     * @throws Exception
     */
    public function send()
    {
        
        if(!$this->mail->send())
        {
            return false;
        }
        
        return true;
    }
    
}
