<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Hotel extends Eloquent {

	//protected $table = 'hotels';
    protected $template = 'http://www.trivago.se/?iPathId=%s&cip=%s&aDateRange[arr]=%s&aDateRange[dep]=%s';
    //protected $cip = 46030316040101;
    protected $cip = 46030316040102;

    public function getLink($dateFrom, $dateTo) {
        return sprintf($this->template, $this->path_id, $this->cip, $dateFrom, $dateTo);
    }
}
