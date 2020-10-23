<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationTraits;

trait LoggingTrait
{
        
    /**
     * logTitle
     *
     * @var mixed
     */
    private $logTitle;
    
    /**
     * logContent
     *
     * @var mixed
     */
    private $logContent;

    /**
     * generateLogMessage
     *
     * @param  mixed $thema
     * @param  mixed $response
     * @return string
     */
    private function generateLogMessage(string $thema, string $response):string
    {

        $date = date('Y-m-d H:i:s').'┃╍╍╍┋'.PHP_EOL;
        $thema = sprintf('Тема: %s ╍╍╍╍╍╍┋', $thema).PHP_EOL;
        $message = sprintf('Response Text: %s', $response);

        $render = $date.$thema.$message;

        return $render;

    }
        
    /**
     * setLoggingTitle
     *
     * @param  mixed $title
     * @return void
     */
    public function setLoggingTitle(string $title)
    {

        $this->logTitle = $title;

        return $this;

    }
    
    /**
     * setLoggingContent
     *
     * @param  mixed $content
     * @return void
     */
    public function setLoggingContent(string $content)
    {

        $this->logContent = $content;

        return $this;

    }

    /**
     * setSuccessLog
     *
     * @param  mixed $title
     * @param  mixed $response
     * @return void
     */
    public function setSuccessLog()
    {

        $this->appendLogg($this->connection->getSettings()->logging->success['filename'], $this->generateLogMessage($this->logTitle, $this->logContent));

    }
    
    /**
     * setErrorLog
     *
     * @param  mixed $title
     * @param  mixed $response
     * @return void
     */
    public function setErrorLog()
    {

        $this->appendLogg($this->connection->getSettings()->logging->error['filename'], $this->generateLogMessage($this->logTitle, $this->logContent));

    }
    
    /**
     * appendLogg
     *
     * @param  mixed $fileLog
     * @param  mixed $response
     * @return bool
     */
    private function appendLogg(string $fileLog, string $response):bool
    {
        
        $settings = $this->connection->getSettings();
        $path = $settings->paths->log['path'];
        $fullPath = $path.$fileLog;

        if($settings->logging['remove-current-log'] == 'true') file_put_contents(getcwd().$fullPath, $response);
        else file_put_contents(getcwd().$fullPath, $response.PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);

        return true;

    }
    
}