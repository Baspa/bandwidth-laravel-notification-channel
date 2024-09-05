<?php

namespace NotificationChannels\BandwidthLaravelNotificationChannel;

class BandwidthMessage
{
    protected $from;
    protected $to;
    protected $text;
    protected $applicationId;

    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    public function applicationId($applicationId)
    {
        $this->applicationId = $applicationId;
        return $this;
    }

    public function toArray()
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'text' => $this->text,
            'applicationId' => $this->applicationId,
        ];
    }
}
